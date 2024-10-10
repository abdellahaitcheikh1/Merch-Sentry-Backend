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
        Schema::connection('mysql_Mondial_Engins')->create('magasins', function (Blueprint $table) {
            $table->id();
            $table->string('NomMagasin');
            $table->string('Nom_complet_propriétaire');
            $table->string('email');
            $table->string('password');
            $table->string('adresse de siège');
            $table->string('rc');
            $table->string('patente');
            $table->string('ice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magasins__mondial__engins');
    }
};
