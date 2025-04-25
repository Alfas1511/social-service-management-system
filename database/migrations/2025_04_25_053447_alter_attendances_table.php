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
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('days_attended');
            $table->dropColumn('total_days');
            $table->date('date')->after('user_id')->nullable();
            $table->enum('status', ['attended', 'unattended'])->default('unattended')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('days_attended')->after('user_id')->nullable();
            $table->integer('total_days')->after('days_attended')->nullable();
            $table->dropColumn('date');
            $table->dropColumn('status');
        });
    }
};
