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
        Schema::connection('mysql_J_cat_Equipement')->create('commercials', function (Blueprint $table) {
            $table->id();
            $table->string('Nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('password');
            $table->string('IdMagasin');
            $table->string('télephone');
            $table->string('cin');
            $table->string('credit');
            $table->string('vente');
            $table->string('annulé');
            $table->string('remboursé');
            $table->string('ville');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial__j_cat__equipements');
    }
};
