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
        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->string('nom',50);
            $table->string('chemin',50);
            $table->string('driver')->nullable();
            $table->foreignId('id_type_document')->foreign()->references('id')->on('type_document');
            $table->foreignId('id_equipement')->foreign()->references('id')->on('equipement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
