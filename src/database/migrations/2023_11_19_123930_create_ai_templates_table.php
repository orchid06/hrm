<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     

// id	
// user_id	
// custom_template_category_id	
// name	
// slug	
// code	
// description	
// fields	
// prompt	
// icon	
// total_words_generated	
// is_active	
// created_by
// admin
// created_at	
// updated_at	
// dele
    public function up(): void
    {
        Schema::create('ai_templates', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name',100)->unique();
            $table->string('slug',100)->unique();
            $table->string('icon',100);
            $table->text('description');
            $table->longText('prompt_fields')->nullable();
            $table->text('custom_prompt')->nullable();
            $table->integer('total_words')->default(0);
            $table->enum('status',[0,1])->comment('Active : 1,Inactive : 0');
            $table->enum('is_deafult',[0,1])->comment('Yes : 1,No : 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_templates');
    }
};
