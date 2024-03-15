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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('_uid')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->unique()->nullable();
            $table->string('phone_no')->unique()->nullable();
            $table->unsignedInteger('policy_type_id');
            $table->string('policy_no');
            $table->date('policy_start_at');
            $table->date('policy_expires_at');
            $table->decimal('policy_amount');
            $table->decimal('policy_balance');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
