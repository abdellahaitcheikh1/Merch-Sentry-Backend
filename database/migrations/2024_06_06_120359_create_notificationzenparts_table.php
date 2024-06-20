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
        Schema::connection('mysql_second')->create('notification', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('IdRole');
            $table->string('Notification_Title');
            $table->string('Notification_Content');
            $table->string('Statut')->default('not readable');
            $table->timestamp('Date');
            $table->foreign('IdRole')->references('id')->on('role')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_second')->dropIfExists('notification');
    }
};
