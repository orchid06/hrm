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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->integer('serial_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('title',200)->nullable();
            $table->string('slug',200)->nullable();
            $table->longText("description");
            $table->string('meta_title',155)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active: 1,Deactive: 0'); 
            $table->enum('show_in_header',[0,1])->default(0)->comment('Yes: 1,No: 0');   
            $table->enum('show_in_footer',[0,1])->default(0)->comment('Yes: 1,No: 0');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
