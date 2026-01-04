<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();      // pembeli (user)
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();  // profil customer

            $table->date('tanggal');

            // pengiriman
            $table->enum('delivery_method', ['pickup','delivery'])->default('pickup');
            $table->unsignedBigInteger('shipping_fee')->default(0);

            // hitungan
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('total')->default(0);

            // pembayaran & status
            $table->enum('payment_status', ['unpaid','waiting_confirm','paid'])->default('unpaid');
            $table->string('payment_proof_path')->nullable();
            $table->timestamp('paid_at')->nullable();

            // status order (proses)
            $table->enum('status', ['menunggu_pembayaran','diproses','dikirim','selesai','dibatalkan'])
                  ->default('menunggu_pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
