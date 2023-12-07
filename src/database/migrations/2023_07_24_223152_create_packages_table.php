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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('title',255)->unique()->nullable();
            $table->string('slug',255)->unique()->nullable();
            $table->enum('duration',[1,2,-1])->comment('MONTHLY = 1; YEARLY = 2; UNLIMITED = -1');
            $table->double('price',20, 2)->default(0.00);
            $table->double('discount_price',20, 2)->default(0.00);
            $table->double('total_subscription_income', 20,5)->nullable()->default(0.00000);
            $table->longText('social_access')->nullable();
            $table->longText('ai_configuration')->nullable();
            $table->longText('template_access')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active: 1, Inactive: 0');
            $table->enum('is_recommended',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->enum('is_feature',[0,1])->default(0)->comment('Yes: 1,No: 0');
            $table->enum('is_free',[0,1])->default(0)->comment('Yes: 1, No: 0');
            $table->mediumInteger('affiliate_commission')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
