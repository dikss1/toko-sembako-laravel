<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->default('pending_payment')->after('total');
            }
            if (!Schema::hasColumn('transactions', 'shipping_fee')) {
                $table->bigInteger('shipping_fee')->default(0)->after('status');
            }
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('shipping_fee'); // qris/manual
            }
            if (!Schema::hasColumn('transactions', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_method'); // path upload
            }
            if (!Schema::hasColumn('transactions', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_proof');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            foreach (['status','shipping_fee','payment_method','payment_proof','paid_at'] as $col) {
                if (Schema::hasColumn('transactions', $col)) $table->dropColumn($col);
            }
        });
    }
};
