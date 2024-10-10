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
        Schema::connection('mysql_Elyoubi')->create('stocks', function (Blueprint $table) {
            $table->id('idStock');
            $table->integer('IdArticle');
            $table->integer('prix_ht_1_magasin');
            $table->integer('prix_ht_2_magasin');
            $table->integer('prix_ht_3_magasin');
            $table->integer('prix_ttc_magasin');
            $table->string('quantité')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock__saiss__tracks');
    }
};
