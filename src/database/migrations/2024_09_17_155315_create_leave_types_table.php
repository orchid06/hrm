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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->string('name');
            $table->integer('days')->nullable();
            $table->enum('is_paid' ,array_values(StatusEnum::toArray()))->default(StatusEnum::true->status())->comment('Paid: 1, Unpaid: 0');
            $table->enum('status',array_values(StatusEnum::toArray()))->default(StatusEnum::true->status())->comment('Active: 1, Inactive: 0');
            $table->string('description')->nullable();
            $table->longText('custom_inputs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
