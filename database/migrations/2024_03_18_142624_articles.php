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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('IdArticle');
            $table->integer('IdTVA')->nullable();
            $table->integer('IdFamilleArticle')->nullable();
            $table->string('RefArticle');
            $table->integer('NumArticle')->nullable();
            $table->string('Designation');
            $table->string('Description');
            $table->string('image');
            $table->date('DateCreation')->nullable();
            $table->date('DateModification')->nullable();
            $table->integer('PrixVenteArticleHT')->nullable();
            $table->string('Supprime')->default(0);
            $table->string('Unite');
            $table->integer('IdFournisseur')->nullable();
            $table->integer('PrixAchat')->nullable()->default(0);
            $table->date('DateDebut')->nullable();
            $table->date('DateFin')->nullable();
            $table->integer('StockMin')->nullable();
            $table->integer('StockMax')->nullable();
            $table->integer('PMP')->nullable();
            $table->integer('PrixMin')->nullable();
            $table->integer('PrixVenteArticleTTC')->nullable();
            $table->integer('PrixMinTTC')->nullable();
            $table->integer('PrixAchatTTC')->nullable();
            $table->string('CodeABarre')->nullable();
            $table->string('EncodageType')->nullable();
            $table->integer('NbreParColis')->nullable();
            $table->integer('QteParColis')->nullable();
            $table->string('CodeFrs')->nullable();
            $table->string('CodeF')->nullable();
            $table->string('CodeSF')->nullable();
            $table->integer('Colis')->nullable();
            $table->integer('QteParClois')->nullable();
            $table->integer('IsPlinthe')->nullable();
            $table->integer('stock');
            $table->integer('PrixHamria')->nullable();
            $table->integer('PrixZitoune')->nullable();
            $table->integer('DernierPrixAchat')->nullable();
            $table->integer('DernierPrixVente')->nullable();
            $table->integer('PMPAchat')->nullable();
            $table->integer('PMPVente')->nullable();
            $table->integer('IsMouvemente')->nullable();
            $table->integer('PrixAchatHamria')->nullable();
            $table->integer('PrixAchatZitoune')->nullable();
            $table->integer('Marge')->nullable();
            $table->integer('IsTTC')->nullable();
            $table->integer('RemiseMax')->nullable();
            $table->integer('RemiseFrs')->nullable();
            $table->integer('DatePeremption')->nullable();
            $table->integer('IdMarque')->nullable();
            $table->string('AlertPeremption')->default(false);
            $table->string('CodeABarre2')->nullable();
            $table->string('CodeABarreTitle')->nullable();
            $table->integer('PoidsNet')->nullable();
            $table->integer('PrixVente2')->nullable();
            $table->integer('PrixVente2TTC')->nullable();
            $table->integer('PrixVente3')->nullable();
            $table->integer('PrixVente3TTC')->nullable();
            $table->integer('IdFamille')->nullable();
            $table->string('IsActive')->nullable();
            $table->string('Emplacement')->nullable();
            $table->string('CodeCamoflage')->nullable();
            $table->string('CodeDouane')->nullable();
            $table->integer('DimensionInterieure')->nullable();
            $table->integer('DimensionExterieure')->nullable();
            $table->integer('EpaisseurExterieure')->nullable();
            $table->integer('EpaisseurInterieure')->nullable();
            $table->integer('LongueurExterieure')->nullable();
            $table->integer('LongueurInterieure')->nullable();
            $table->integer('LargeurExterieure')->nullable();
            $table->integer('LargeurInterieure')->nullable();
            $table->integer('HauteurExterieure')->nullable();
            $table->integer('HauteurInterieure')->nullable();
            $table->integer('NombreDentExterieure')->nullable();
            $table->integer('NombreDentInterieure')->nullable();
            $table->integer('DiametreLateralExterieure')->nullable();
            $table->integer('DiametreLateralInterieure')->nullable();
            $table->integer('DistanceEntreTrous')->nullable();
            $table->string('Pas')->nullable();
            $table->string('NombreTrousInterieure')->nullable();
            $table->string('NombreTrousExterieure')->nullable();
            $table->integer('IdMarqueFournisseur')->nullable();
            $table->string('DesignationAr')->nullable();
            $table->integer('IdTypeArticle')->nullable();
            $table->integer('StockOptimal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
