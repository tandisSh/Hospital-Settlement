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
        Schema::create('operation_surgery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operation_id')->constrained();
            $table->foreignId('surgery_id')->constrained();
            $table->bigInteger('amount')->nullable()->comment('مبلغ به تومان');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_surgery');
    }
};
