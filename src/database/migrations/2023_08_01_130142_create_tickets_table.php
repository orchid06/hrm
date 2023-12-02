<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->string('ticket_number',100)->index()->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('ticket_data')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->tinyInteger('status')->default(1)->comment('Open: 1, Pending: 2, Processing: 3, Closed: 4 ,Solved: 5 ,On-Hold: 6');
            $table->tinyInteger('priority')->nullable()->comment('Urgent: 1, High: 2, Low: 3, Medium: 4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
