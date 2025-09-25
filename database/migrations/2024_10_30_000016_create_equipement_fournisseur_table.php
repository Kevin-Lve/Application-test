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
        Schema::create('equipement_fournisseur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fournisseur')->foreign()->references('id')->on('fournisseur');
            $table->foreignId('id_sous_categorie')->foreign()->reference('id')->on('sous_categorie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipement_fournisseur');
    }
};
