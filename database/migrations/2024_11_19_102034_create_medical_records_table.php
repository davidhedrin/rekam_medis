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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_num')->unique();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->bigInteger('patient_id')->nullable();
            $table->string('patient_name')->nullable();
            $table->text('desc')->nullable();
            $table->boolean('status')->nullable()->default(true)->comment('True untuk status sedang aktif');
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
        Schema::dropIfExists('medical_records');
    }
};
