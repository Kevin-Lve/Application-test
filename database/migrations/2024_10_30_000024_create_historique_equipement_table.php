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
        Schema::create('historique_equipement', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('id_action')->foreign()->references('id')->on('action_materiel');
            $table->foreignId('id_utilisateur')->foreign()->references('id')->on('users');
            $table->foreignId('id_equipement')->foreign()->references('id')->on('equipement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_equipement');
    }
};
