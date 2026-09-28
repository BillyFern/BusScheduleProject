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
        Schema::create('kedatangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onUpdate('cascade')->onDelete('cascade');
            $table->time('waktu_kedatangan');
            $table->tinyInteger('status')->default('0');
            $table->foreignId('asal_id')->constrained('lokasis')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kedatangans');
    }
};
