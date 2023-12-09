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
            $table->bigInteger('currency_id')->nullable();
            $table->double('amount',20,5)->nullable();
            $table->double('base_amount',20,5)->default(0);
            $table->double('charge',20,5)->nullable();
            $table->double('rate',20,5)->nullable();
            $table->double('final_amount',20,5)->nullable();
            $table->double('base_final_amount',20,5)->default(0);
            $table->string('trx_code',255)->nullable();
            $table->text('custom_data')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status',[-1,1,2,3,4,5])->comment('Paid: 1, Cancel: 2, Pening: 3, Failed: 4, Rejected: 5, Initiate: -1');
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
