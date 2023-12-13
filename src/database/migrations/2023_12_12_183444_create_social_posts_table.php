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
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id()->index();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('title',155)->unique();
            $table->longText('content')->nullable();
            $table->longText('platform_response')->nullable();
            $table->enum('is_scheduled',[0,1])->default(0)->comment('No: 0, Yes: 1');
            $table->enum('is_draft',[0,1])->default(0)->comment('No: 0, Yes: 1');
            
            $table->enum('status',[0,1])->default(0)->comment('No: 0, Yes: 1');
            
            $table->timestamp('schedule_time')->nullable();

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
