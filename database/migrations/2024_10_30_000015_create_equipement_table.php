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
        Schema::create('equipement', function (Blueprint $table) {
            $table->id();
            $table->date('date_achat')->nullable();
            $table->date('date_livraison')->nullable();
            $table->date('date_obsolescence')->nullable();
            $table->decimal('prix', 10, 2)->nullable(); // Précision pour le prix
            $table->ipAddress('adresse_ip')->nullable();
            $table->ipAddress('adresse_ip_wifi')->nullable();
            $table->string('adresse_mac', 20)->nullable();
            $table->string('adresse_mac_bt', 20)->nullable();
            $table->string('adresse_mac_2', 20)->nullable();
            $table->string('adresse_mac_3', 20)->nullable();
            $table->string('numero_serie', 50)->nullable();
            $table->string('numero_sku', 50)->nullable();
            $table->string('numero_tel', 30)->nullable();
            $table->string('bon_livraison', 30)->nullable();
            $table->string('version', 20)->nullable();
            $table->string('immo', 20)->nullable();
            $table->date('date_fin_garantie')->nullable();
            $table->boolean('garantie')->default(false)->nullable(); // Par défaut sur false
            $table->text('description')->nullable();

            // Champs polymorphiques
            $table->unsignedBigInteger('id_attribution')->nullable();
            $table->string('type_attribution', 50)->nullable();

            // Relations avec d'autres tables
            $table->foreignId('id_emplacement')
                ->nullable()
                ->constrained('emplacement')
                ->onDelete('set null');
            $table->foreignId('id_sous_categorie')
                ->nullable()
                ->constrained('sous_categorie')
                ->onDelete('set null');
            $table->foreignId('id_vlan')
                ->nullable()
                ->constrained('vlan')
                ->onDelete('set null');

            $table->timestamps();

            // Index combiné pour les champs polymorphiques
            $table->index(['id_attribution', 'type_attribution'], 'equipement_attribution_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipement');
    }
};
