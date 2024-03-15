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
        Schema::create('policypayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('_uid')->unique();
            $table->unsignedBigInteger('client_id');
            $table->decimal('amount_paid');
            $table->dateTime('paid_at');
            $table->dateTime('next_payment_date_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policypayments');
    }
};
