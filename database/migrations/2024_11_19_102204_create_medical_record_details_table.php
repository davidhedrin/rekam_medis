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
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('complaint')->nullable();
            $table->string('physical_exam')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('medicine_advice')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('record_id')->references('id')->on('medical_records')->onDelete('cascade')->onUpdate('cascade');
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
