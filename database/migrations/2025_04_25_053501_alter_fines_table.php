<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fines', function (Blueprint $table) {
            $table->dropColumn('days_not_attended');
            $table->dropColumn('fine_amount_paid');
            $table->integer('amount')->after('user_id')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fines', function (Blueprint $table) {
            $table->integer('days_not_attended')->after('user_id')->nullable();
            $table->integer('fine_amount_paid')->after('days_not_attended')->nullable();
            $table->dropColumn('amount')->nullable();
            $table->dropColumn('status')->nullable();
        });
    }
};
