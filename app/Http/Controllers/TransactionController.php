<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $q = Transaction::with(['customer', 'user'])->latest();

        $user = Auth::user();
        if ($user && !$user->isAdmin()) {
            $q->where('user_id', Auth::id());
        }

        $transactions = $q->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = Auth::user();
        $customer = $user?->customer;

        if (!$customer) {
            return redirect()->route('profile')
                ->withErrors(['msg' => 'Profil customer belum lengkap. Silakan lengkapi profil dulu.']);
        }

        $products = Product::orderBy('nama')->get();
        return view('transactions.create', compact('customer', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        $user = Auth::user();
        $customer = $user?->customer;

        if (!$customer) {
            return back()->withErrors(['msg' => 'Profil customer tidak ditemukan.'])->withInput();
        }

        return DB::transaction(function () use ($request, $user, $customer) {

            $trx = Transaction::create([
                'kode' => 'TRX-' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'tanggal' => $request->tanggal,
                'total' => 0,
            ]);

            $grand = 0;

            foreach ($request->items as $row) {
                $product = Product::lockForUpdate()->findOrFail($row['product_id']);
                $qty = (int) $row['qty'];

                if ($qty > (int)$product->stok) {
                    $max = (int)$product->stok;
                    throw new HttpException(
                        422,
                        "Stok {$product->nama} tidak cukup. Maksimal yang bisa dibeli: {$max}."
                    );
                }

                $harga = (int) $product->harga;
                $subtotal = $harga * $qty;

                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stok', $qty);
                $grand += $subtotal;
            }

            $trx->update(['total' => $grand]);

            return redirect()
                ->route('transactions.show', $trx)
                ->with('success', 'Transaksi berhasil dibuat.');
        });
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if ($user && !$user->isAdmin() && $transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load(['customer', 'user', 'items.product']);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        DB::transaction(function () use ($transaction) {
            $transaction->load('items');

            foreach ($transaction->items as $item) {
                Product::where('id', $item->product_id)->increment('stok', $item->qty);
            }

            $transaction->delete();
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus.');
    }
}
