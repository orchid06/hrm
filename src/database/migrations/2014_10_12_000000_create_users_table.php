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
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->mediumInteger('referral_code')->nullable();
            $table->bigInteger('auto_subscription_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('uid',100)->index()->nullable();
            $table->string('o_auth_id',255)->nullable();
            $table->string('name',255);
            $table->string('username',255)->nullable()->unique();
            $table->string('phone',255)->nullable()->unique();
            $table->double('balance',20,2)->default(0.00);
            $table->string('email',255)->unique();
            $table->longText('notification_settings')->nullable();
            $table->longText('settings')->nullable();
            $table->longText('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active: 1, Deactive: 0');
            $table->enum('auto_subscription', [0,1])->default(0)->comment('Off: 0, On: 1');
            $table->enum('is_kyc_verified',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->longText('custom_data')->nullable();
            $table->string('password',255)->nullable();
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
