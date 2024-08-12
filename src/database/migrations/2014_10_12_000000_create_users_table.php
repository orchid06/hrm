<?php

use App\Enums\StatusEnum;
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

        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->index()->nullable()->constrained(table: 'admins');
            $table->unsignedBigInteger('updated_by')->index()->nullable()->constrained(table: 'admins');
            $table->unsignedBigInteger('country_id')->index()->nullable()->constrained(table: 'countries');
            $table->string('uid',100)->index()->nullable();
            $table->string('o_auth_id',255)->nullable();
            $table->string('name',255)->index();
            $table->string('username',191)->index()->nullable()->unique();
            $table->string('phone',191)->nullable()->index()->unique();
            $table->string('email',191)->index()->unique();
            $table->longText('notification_settings')->nullable();
            $table->longText('settings')->nullable();
            $table->longText('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status',[array_values(StatusEnum::toArray())])->index()->default(StatusEnum::true->status())->comment('Active: 1, Deactive: 0');
            $table->longText('custom_data')->nullable();
            $table->string('password',255)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('employee_id', 100)->unique()->nullable();
            $table->date('date_of_birth');
            $table->date('date_of_joining');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
