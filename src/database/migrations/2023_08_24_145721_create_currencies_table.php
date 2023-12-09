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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('symbol');
            $table->double('exchange_rate');
            $table->enum('status',[0,1])->default(1)->comment('Active: 1, Deactive: 0');
            $table->enum('default',[0,1])->nullable()->comment('Yes: 1, No: 0');
            $table->enum('base',[0,1])->nullable()->comment('Active: 1, Deactive: 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
