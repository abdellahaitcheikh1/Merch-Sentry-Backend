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
        Schema::create('depot', function (Blueprint $table) {
            $table->id('IdDepot');
            $table->foreignId('IdVille')
            ->references('IdVille')->on('ville')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->boolean('IsMagasin');
            $table->string('Reference');
            $table->string('NomDepot');
            $table->string('Adresse')->nullable();
            $table->string('Tele')->nullable();
            $table->string('Fax')->nullable();
            $table->dateTime('DateCreation')->nullable();
            $table->dateTime('DateModification')->nullable();
            $table->boolean('Supprime');
            $table->string('Imprimante')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depot');
    }
};
