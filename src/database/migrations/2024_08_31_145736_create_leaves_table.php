<?php

use App\Enums\LeaveDurationType;
use App\Enums\LeaveStatus;
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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->enum('leave_duration_type' , array_values(LeaveDurationType::toArray()))->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_days');
            $table->enum('status',array_values(LeaveStatus::toArray()))->default(LeaveStatus::pending->status())->comment('Pending: 0, Approved: 1 , Declined:2');
            $table->text('reason')->nullable();
            $table->text('note')->nullable();
            $table->longText('leave_request_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
