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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('method_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('trx_code',255)->nullable();
            $table->double('base_amount',20,2)->nullable();
            $table->double('amount',20,2)->nullable();
            $table->double('charge',20,2)->nullable();
            $table->double('rate',20,2)->nullable();
            $table->double('base_final_amount',20,2)->nullable();
            $table->double('final_amount',20,2)->nullable();
            $table->text('custom_data')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status',[0,1,2,-1])->comment('Complete : 1,Pending : 0,Cancel : 2 , -1:Initiate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
