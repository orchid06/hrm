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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('name')->unique();
            $table->integer('duration')->comment('Hours');
            $table->double('minimum_amount',10,5);
            $table->double('maximum_amount',10,5);
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');
            $table->double('fixed_charge',10,5);
            $table->double('percent_charge',10,5);
            $table->text('description')->nullable();
            $table->longText('parameters')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
