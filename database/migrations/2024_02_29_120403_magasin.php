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
        Schema::create('magasin', function (Blueprint $table) {
            $table->id('IdMagasin');
            $table->foreignId('IdDepot')
            ->references('IdDepot')->on('depot')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('IdVille')
            ->references('IdVille')->on('ville')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('Reference')->nullable();
            $table->string('NomMagasin');
            $table->string('Adresse');
            $table->string('Tele');
            $table->string('Fax');
            $table->dateTime('DateCreation')->nullable();
            $table->dateTime('DateModification')->nullable();
            $table->boolean('Supprime');
            $table->string('ImageEP')->nullable();
            $table->string('ImagePP')->nullable();
            $table->string('ImageEP_Facture')->nullable();
            $table->string('ImagePP_Facture')->nullable();




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magasin');

    }
};
