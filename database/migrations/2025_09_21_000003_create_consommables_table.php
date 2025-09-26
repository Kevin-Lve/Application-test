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
        Schema::create('consommables', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('reference')->nullable();
            $table->string('code_barre')->nullable()->index();
            $table->string('numero_serie')->nullable()->index();
            $table->string('immo', 50)->nullable()->index();
            $table->string('adresse_mac', 32)->nullable()->index();
            $table->unsignedInteger('quantite_stock')->default(0);
            $table->unsignedInteger('quantite_minimale')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommables');
    }
};
