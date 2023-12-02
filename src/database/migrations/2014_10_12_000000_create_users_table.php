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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('o_auth_id')->nullable();
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('email')->unique();
            $table->longText('notification_settings')->nullable();
            $table->longText('settings')->nullable();
            $table->longText('address')->nullable();
            $table->double('balance',20,2)->default(0.00);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');
            $table->enum('is_kyc_verified',[0,1])->default(0)->comment('Yes : 1,No : 0');
            $table->string('password')->nullable();
            $table->longText('custom_data')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
