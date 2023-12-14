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
        Schema::create('media_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->string("name",155);
            $table->string("slug",155);
            $table->string("description",255)->nullable();
            $table->longText("configuration")->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active: 1, Inactive: 0');
            $table->enum('is_feature',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->enum('is_integrated',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_platforms');
    }
};
