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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('title',200)->nullable();
            $table->string('icon',100)->nullable();
            $table->string('slug',200)->nullable();
            $table->string('description',255)->nullable();
            $table->string('meta_title',255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');
            $table->enum('is_feature',[0,1])->default(1)->comment('Yes : 1,No : 0');
            $table->enum('display_in',[0,1,2])->nullable()->comment('0:Article , 1:Template 2:Both');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
