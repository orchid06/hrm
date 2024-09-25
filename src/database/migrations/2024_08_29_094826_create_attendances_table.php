<?php

use App\Enums\ClockStatusEnum;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->date('date')->index();
            $table->timestamp('clock_in')->nullable();
            $table->enum('clock_in_status',array_values(ClockStatusEnum::toArray()))->nullable()->comment('Pending: 0, Approved: 1 , Declined:2');
            $table->timestamp('clock_out')->nullable();
            $table->enum('clock_out_status',array_values(ClockStatusEnum::toArray()))->nullable()->comment('Pending: 0, Approved: 1 , Declined:2');
            $table->integer('late_time')->nullable(); // Calculated in minutes
            $table->integer('over_time')->nullable(); // Calculated in minutes
            $table->integer('work_hour')->nullable(); // Calculated in minutes
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
