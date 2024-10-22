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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 100)->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('basic_salary',10,2);
            $table->decimal('net_pay',10,2);
            $table->longText('details')->nullable();
            $table->string('pay_period')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('note')->nullable();
            $table->enum('status',array_values(StatusEnum::toArray()))->default(StatusEnum::false->status())->comment('Paid: 1, Unpaid: 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
