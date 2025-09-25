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
        Schema::create('situation_demande', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->foreignId('id_utilisateur')->foreign()->references('id')->on('users');
            $table->foreignId('id_demande')->foreign()->references('id')->on('demande');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situation_demande');
    }
};
