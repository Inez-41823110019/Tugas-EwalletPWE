<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('balance', 15, 2)->default(0)->change();
        });

        Schema::table('topups', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->change();
        });
    }

    public function down(): void
    {
        // rollback tidak wajib untuk tugas
    }
};
