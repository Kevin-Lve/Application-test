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
            // Champs SIM
            $table->string('imei', 20)->nullable();
            $table->string('numero_ligne', 15)->nullable(); 
            $table->string('code_pin', 10)->nullable();
            $table->string('code_puk', 15)->nullable();
            $table->string('forfait', 50)->nullable();
            $table->string('type_sim', 20)->nullable();
            $table->boolean('esim')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipement', function (Blueprint $table) {
            $table->dropColumn([
                'imei', 'numero_ligne', 'code_pin', 'code_puk', 
                'forfait', 'type_sim', 'esim'
            ]);
        });
    }
};