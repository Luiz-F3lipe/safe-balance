<?php

declare(strict_types = 1);

use App\Models\Transaction;
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
        Schema::create('transaction_installments', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Transaction::class, 'transaction_id')->constrained()->cascadeOnDelete();
            $table->integer('installment');
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_installments');
    }
};
