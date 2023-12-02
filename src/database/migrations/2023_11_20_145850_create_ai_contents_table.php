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
        Schema::create('ai_contents', function (Blueprint $table) {
            $table->id()->index();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->string("name",154)->unique();
            $table->string("slug",154)->nullable()->unique();
            $table->longText("content")->nullable();
            $table->string('notes',255)->nullable();
            $table->enum('status',[0,1])->comment('Active : 1,Inactive : 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_contents');
    }
};
