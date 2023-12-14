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
        Schema::create('social_accounts', function (Blueprint $table) {
            
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('platform_id');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name',155)->nullable();
            $table->text('account_information')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Disconnected: 0, Connected: 1');
            $table->enum('account_type',[0,1,2])->comment('Profile: 0, Page: 1 ,Group:2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
