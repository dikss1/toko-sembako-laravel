<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /** tampilkan halaman register */
    public function create(): View
    {
        return view('auth.register');
    }

    /** proses register */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // tambahan profil customer
            'alamat' => ['required', 'string', 'max:255'],
            'no_tlp' => ['required', 'string', 'max:30'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // default customer
        ]);

        // auto create row customer
        Customer::create([
            'user_id' => $user->id,
            'nama'    => $request->name,
            'alamat'  => $request->alamat,
            'no_tlp'  => $request->no_tlp,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // setelah register masuk ke toko
        return redirect()->route('shop.index');
    }
}
