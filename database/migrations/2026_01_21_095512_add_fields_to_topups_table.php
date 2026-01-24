<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->string('reference')->unique()->after('id');
            $table->string('payment_method')->after('amount');
            $table->string('status')->default('completed')->after('payment_method');
            $table->text('notes')->nullable()->after('status');
            $table->string('user_ip')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn(['reference','payment_method','status','notes','user_ip']);
        });
    }
};
