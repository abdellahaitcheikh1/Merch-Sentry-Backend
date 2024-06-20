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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('IdUser');
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Fonction');
            $table->dateTime('DateCreation')->nullable();
            $table->dateTime('DateModification')->nullable();
            $table->boolean('supprime');
            $table->foreignId('IDRole')
            ->references('IdRole')->on('role')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('Username');
            $table->string('Password');
            $table->string('CompteEmail');
            $table->string('PasswordEmail');
            $table->boolean('logout');
            
            // $table->string('telephone')->nullable();
                // $table->string('solde')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');

    }
};
