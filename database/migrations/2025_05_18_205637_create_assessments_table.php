<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->json('answers'); // Store question answers as JSON
            $table->integer('total_yes')->default(0);
            $table->integer('total_no')->default(0);
            $table->integer('total_questions')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->boolean('passed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
