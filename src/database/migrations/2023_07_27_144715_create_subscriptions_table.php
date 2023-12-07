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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->bigInteger('old_package_id')->nullable();
            $table->mediumInteger('word_balance')->default(0);
            $table->mediumInteger('remaining_word_balance')->default(0);
            $table->mediumInteger('carried_word_balance')->default(0);
            $table->mediumInteger('total_profile')->default(0);
            $table->mediumInteger('carried_profile')->default(0);
            $table->mediumInteger('post_balance')->default(0);
            $table->mediumInteger('carried_post_balance')->default(0);
            $table->mediumInteger('remaining_post_balance')->default(0);
            $table->double('payment_amount',20,5)->nullable();
            $table->text('trx_code')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status',[3,1,2])->default(2)->comment('Expired: 3, Running: 1, Inactive: 2');
            $table->enum('payment_status',[0,1,2])->default(2)->comment('Complete: 1, Pending: 0, Cancel: 2, -1:Initiate');
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
