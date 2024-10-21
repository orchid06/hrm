<?php

use App\Enums\PayslipCycle;
use App\Enums\RankEnum;
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
        Schema::create('user_designations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_designation_id')->nullable();
            $table->string('uid', 100)->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('designation_id');
            $table->decimal('basic_salary');
            $table->longText('salary')->nullable();
            $table->decimal('net_salary')->nullable();
            $table->enum('payslip_cycle', [array_values(PayslipCycle::toArray())])->index()->default(PayslipCycle::MONTHLY)->comment('Weekly : 1, Bi_weekly : 2, Monthly : 3');
            $table->enum('rank',[array_values(RankEnum::toArray())])->index()->default(RankEnum::up->status())->comment('Up: 1, Down: 0');
            $table->enum('status',array_values(StatusEnum::toArray()))->default(StatusEnum::true->status())->comment('Active: 1, Inactive: 0');
            $table->string('note',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_designations');
    }
};
