<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_installments', function (Blueprint $table): void {
            $table->dateTime('due_date')->change();
            $table->dateTime('paid_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_installments', function (Blueprint $table): void {
            $table->date('due_date')->change();
            $table->date('paid_date')->nullable()->change();
        });
    }
};
