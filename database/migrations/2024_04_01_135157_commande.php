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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('IdCommande');
            $table->integer('IdDevis');
            $table->integer('IdClient');
            $table->string('RefCommande');
            $table->string('NumCommande');
            $table->date('DateCreation');
            $table->date('DateModification');
            $table->date('DateCommande');
            $table->string('Remarque');
            $table->string('Supprime');
            $table->string('IdMagasin');
            $table->string('IdUser');
            $table->string('IdExercice');
            $table->string('IsReported');
            $table->string('Ville');
            $table->string('Adresse');
            $table->decimal('TotalCommandeHT');
            $table->decimal('TotalCommandeTTC');
            $table->string('IdRepresentant');
            $table->string('NbreLines');
            $table->string('EsCompte');
            $table->string('MontantAvecEsCompte');
            $table->string('RefCommandeClient');
            $table->integer('IdSousClient');
            $table->integer('IdExpediteur');
            $table->decimal('TotalRemise');
            $table->string('IdModeReglement');
            $table->string('RemiseGlobale');
            $table->string('RemiseSur');
            $table->string('TypeRemise');
            $table->string('NomClient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
        
    }
};
