<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipement_attribut_valeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_equipement')->constrained('equipement')->cascadeOnDelete();
            $table->foreignId('id_attribut')->constrained('sous_categorie_attributs')->cascadeOnDelete();
            $table->text('valeur')->nullable();
            $table->timestamps();
            $table->unique(['id_equipement', 'id_attribut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipement_attribut_valeurs');
    }
};
