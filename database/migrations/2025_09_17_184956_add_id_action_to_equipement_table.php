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
        Schema::table('equipement', function (Blueprint $table) {
            // Ajoute une colonne id_action qui référence la table action_materiel
            $table->foreignId('id_action')
                ->nullable()                    // Peut être NULL (pas obligatoire)
                ->after('id_vlan')             // Position après la colonne id_vlan
                ->constrained('action_materiel') // Crée automatiquement la clé étrangère vers action_materiel.id
                ->onDelete('set null');        // Si l'action est supprimée, met NULL dans equipement
        });
    }

    public function down(): void
    {
        Schema::table('equipement', function (Blueprint $table) {
            // Pour annuler la migration : supprime d'abord la contrainte puis la colonne
            $table->dropForeign(['id_action']);  // Supprime la clé étrangère
            $table->dropColumn('id_action');     // Supprime la colonne
        });
    }
};
