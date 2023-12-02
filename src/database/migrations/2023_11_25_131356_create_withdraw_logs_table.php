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
        Schema::create('withdraw_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('method_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('trx_code',255)->nullable();
            $table->double('base_amount',25,2)->default(0);
            $table->double('amount',25,2)->default(0);
            $table->double('base_charge',25,2)->default(0);
            $table->double('charge',25,2)->default(0);
            $table->double('base_final_amount',25,2)->default(0);
            $table->double('final_amount',25,2)->default(0);
            $table->longText('custom_data')->nullable();
            $table->enum('status',[0,1,2])->default(0)->comment('Pending : 0,Approved : 1 ,Rejected:2');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_logs');
    }
};
