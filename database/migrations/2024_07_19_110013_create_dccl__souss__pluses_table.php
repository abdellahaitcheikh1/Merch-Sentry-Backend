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
        Schema::connection('mysql_Souss_Plus')->create('detail_commande_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdCommande');
            $table->string('RefArticle');
            $table->string('NomArticle');
            $table->integer('quantity');
            $table->string('Statut')->default('en coure...');
            $table->decimal('prix', 10, 2);
            $table->foreign('IdCommande')->references('id')->on('historique_commande_clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dccl__souss__pluses');
    }
};
