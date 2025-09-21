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
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id'); // References your client table (_clientID)
            $table->string('phone_number');
            $table->string('template_type')->nullable(); // e.g., 'lapse-pending', 'recovery-code', etc.
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->text('error_message')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable(); // User who sent the SMS
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['client_id', 'status']);
            $table->index(['template_type', 'status']);
            $table->index(['sent_by', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
