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
        Schema::connection('mysql_Italopieces')->create('clients', function (Blueprint $table) {
            $table->id('IdClient');
            $table->integer('IdFamilleClient');
            $table->integer('RefClt');
            $table->string('NomClient');
            $table->string('PrenomClient');
            $table->string('Description');
            $table->string('NumTele');
            $table->string('NumFax');
            $table->string('EmailClient');
            $table->string('PasswordClient');
            $table->string('SiteWebClient');
            $table->string('ContactClient');
            $table->string('Adresse');
            $table->DATETIME('DateCreation');
            $table->DATETIME('DateModification');
            $table->string('Supprime');
            $table->string('isBloque');
            $table->integer('AddresseFacturation');
            $table->integer('Banque');
            $table->integer('Agence');
            $table->integer('Compte');
            $table->integer('Debit');
            $table->string('Credit');
            $table->string('SoldeMaximum');
            $table->string('Ville');
            $table->string('Progstring');
            $table->integer('NumClient');
            $table->integer('IdRepresentant');
            $table->string('AssuranceGarantie');
            $table->string('Patente');
            $table->string('I_F');
            $table->integer('IdDevise');
            $table->string('IsSousClient');
            $table->integer('IdSecteur');
            $table->integer('IdVille');
            $table->integer('IdTypePrix');
            $table->string('IsEnCompte');
            $table->string('IsRemiseGlobale');
            $table->string('RemiseGlobale');
            $table->string('NbrCopieFacture');
            $table->string('NbrCopieBL');
            $table->string('CodeComptableClient');
            $table->string('IsProspect');
            $table->string('ICE');
            $table->integer('IdTypeReglement');
            $table->string('PrintRemarque');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client__italopieces');
    }
};
