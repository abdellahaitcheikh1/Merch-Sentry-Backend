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
        Schema::create('detail_commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCommande');
            $table->string('RefArticle');
            $table->string('NomArticle');
            $table->integer('quantity');
            $table->string('Statut')->default('en coure...');
            $table->decimal('prix', 10, 2);
            $table->timestamps();

            $table->foreign('idCommande')->references('IdCommande')->on('commandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_commandes');

    }
};
