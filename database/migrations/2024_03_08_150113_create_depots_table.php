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
        Schema::connection('mysql_second')->create('depots', function (Blueprint $table) {
            $table->id('IdDepot');
            $table->integer('IdVille');
            $table->string('IsMagasin')->default(0);
            $table->string('Reference');
            $table->string('NomDepot');
            $table->string('Adresse');	
            $table->string('Tele');
            $table->string('Fax')->nullable();	
            $table->DATETIME('DateCreation');
            $table->DATETIME('DateModification');
            $table->string('Supprime')->default(0);
            $table->string('Imprimante')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depots');
    }
};
