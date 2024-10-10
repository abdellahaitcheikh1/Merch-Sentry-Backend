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
        Schema::connection('mysql_Tract_Park')->create('commandes', function (Blueprint $table) {
            $table->id('IdCommande');
            $table->integer('IdDevis');
            $table->integer('IdClient');
            $table->string('RefCommande');
            $table->integer('NumCommande');
            $table->DATETIME('DateCreation');
            $table->DATETIME('DateModification');
            $table->DATETIME('DateCommande');
            $table->integer('Remarque');
            $table->integer('Supprime')->default(0);
            $table->integer('IdMagasin');
            $table->integer('IdUser');
            $table->integer('IdExercice');
            $table->integer('IsReported');
            $table->string('Ville')->nullable();
            $table->string('Adresse');
            $table->string('TotalCommandeHT');
            $table->string('TotalCommandeTTC');
            $table->string('IdRepresentant');
            $table->string('NbreLines');
            $table->string('EsCompte');
            $table->string('MontantAvecEsCompte');
            $table->string('RefCommandeClient');
            $table->integer('IdSousClient');
            $table->integer('IdExpediteur');
            $table->integer('TotalRemise');
            $table->integer('IdModeReglement');
            $table->string('RemiseGlobale');
            $table->integer('RemiseSur');
            $table->string('TypeRemise');
            $table->string('NomClient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande__tract__parks');
    }
};
