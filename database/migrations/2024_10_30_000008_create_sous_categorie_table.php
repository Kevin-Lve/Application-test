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
        Schema::create('sous_categorie', function (Blueprint $table) {
            $table->id();
            $table->string('nom',50);
            $table->string('modele',50);
            $table->string('marque',50);
            $table->string('file_path')->nullable();
            $table->boolean('critique')->nullable();
            $table->foreignId('id_fournisseur')->foreign()->references('id')->on('fournisseur');
            $table->foreignId('id_categorie')->foreign()->references('id')->on('categorie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_categorie');
    }
};
