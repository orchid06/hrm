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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->integer('serial_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string("name")->unique();
            $table->string("code")->unique();
            $table->longText("parameters")->nullable();
            $table->longText("extra_parameters")->nullable();
            $table->double("convention_rate",15, 2)->default(0.00000000);
            $table->double("percentage_charge",15, 2)->default(0.0000);
            $table->double("fixed_charge",15, 2)->default(0.00000000);
            $table->double("minimum_amount",15, 2)->default(0.00000000);
            $table->double("maximum_amount",15, 2)->default(0.00000000);
            $table->text('payment_notes')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');   
            $table->enum('type',[0,1])->default(1)->comment('Automatic : 1,Manual : 0');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
