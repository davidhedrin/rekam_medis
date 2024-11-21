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
        Schema::create('medical_record_details', function (Blueprint $table) {
            $table->id();
            $table->string('record_num')->unique();
            $table->bigInteger('record_id')->nullable();
            $table->string('complaint')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('drag')->nullable();
            $table->string('suggestion')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record_details');
    }
};
