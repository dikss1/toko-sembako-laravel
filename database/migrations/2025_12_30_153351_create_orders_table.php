<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('kode')->unique();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal');

            $table->integer('subtotal')->default(0);

            // pickup / delivery
            $table->string('shipping_method')->default('pickup');
            $table->integer('shipping_fee')->default(0);

            $table->integer('total')->default(0);

            // status order
            $table->string('status')->default('pending'); 
            // payment status
            $table->string('payment_status')->default('unpaid'); 
            // bukti bayar
            $table->string('payment_proof_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
