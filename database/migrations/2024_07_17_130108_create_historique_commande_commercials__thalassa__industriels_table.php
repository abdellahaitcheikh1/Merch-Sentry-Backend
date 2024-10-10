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
        Schema::connection('mysql_Thalassa_Industriel')->create('historique_commande_commercials', function (Blueprint $table) {
            $table->id('id');
            $table->integer('IdCommercial');
            $table->string('NomCommercial');
            $table->string('Adresse');
            $table->decimal('Total');
            $table->string('Statut');
            $table->timestamp('Date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_commande_commercials__thalassa__industriels');
    }
};
