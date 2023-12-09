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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->integer('serial_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('name',255);
            $table->string('url',255);
            $table->longText('section')->nullable();
            $table->enum('menu_visibility', [0,1,2])->default(2)->comment('Header: 0, Footer: 1, Both: 2');
            $table->enum('status',[0,1])->default(1)->comment('Active: 1,Deactive: 0');   
            $table->enum('is_default',[0,1])->default(0)->comment('Yes: 1,No: 0');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
