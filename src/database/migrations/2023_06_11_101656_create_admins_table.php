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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('username',191)->unique();
            $table->string('name',100)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('email',191)->unique();
            $table->longText('notification_settings')->nullable();
            $table->longText('permissions')->nullable();
            $table->longText('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->enum('status',[0,1])->default(1)->comment('Active: 1, Deactive: 0');
            $table->enum('super_admin',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
