<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sous_categorie_attributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sous_categorie')->constrained('sous_categorie')->cascadeOnDelete();
            $table->string('nom_attribut');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('obligatoire')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sous_categorie_attributs');
    }
};
