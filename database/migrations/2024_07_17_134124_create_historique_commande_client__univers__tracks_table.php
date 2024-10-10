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
        Schema::connection('mysql_Univers_Tracks')->create('historique_commande_clients', function (Blueprint $table) {
            $table->id('id');
            $table->integer('IdClient');
            $table->string('NomClient');
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
        Schema::dropIfExists('historique_commande_client__univers__tracks');
    }
};
