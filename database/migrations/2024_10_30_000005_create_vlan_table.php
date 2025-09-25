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
        Schema::create('vlan', function (Blueprint $table) {
            $table->id();
            $table->string('nom',50);
            $table->unsignedSmallInteger('num_vlan');
            $table->ipAddress('ip_debut');
            $table->ipAddress('ip_fin');
            $table->ipAddress('passerelle_defaut');
            $table->string('masque', 45);
            $table->ipAddress('virtual_ip');
            $table->boolean('is_dhcp')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vlan');
    }
};
