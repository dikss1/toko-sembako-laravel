<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'user_id')) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')
                    ->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('customers', 'alamat')) {
                $table->string('alamat')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('customers', 'no_tlp')) {
                $table->string('no_tlp')->nullable()->after('alamat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'no_tlp')) $table->dropColumn('no_tlp');
            if (Schema::hasColumn('customers', 'alamat')) $table->dropColumn('alamat');
            if (Schema::hasColumn('customers', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
