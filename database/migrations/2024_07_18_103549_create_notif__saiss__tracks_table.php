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
        Schema::connection('mysql_Elyoubi')->create('notifications', function (Blueprint $table) {
            $table->id('id');
            $table->string('IdRole');
            $table->string('Notification_Title');
            $table->string('Notification_Content');
            $table->string('Statut')->default('not readable');
            $table->timestamp('Date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notif__saiss__tracks');
    }
};
