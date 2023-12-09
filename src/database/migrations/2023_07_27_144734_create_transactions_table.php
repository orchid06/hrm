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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('amount',20,5)->nullable();
            $table->double('post_balance',20,5)->default(0.00000);
            $table->double('charge',20,5)->nullable();
            $table->double('final_amount',20,5)->nullable();
            $table->string('trx_code',255)->nullable();
            $table->enum('trx_type',["+","-"])->nullable()->comment('+ = plus , - = minus');
            $table->text('remarks')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
