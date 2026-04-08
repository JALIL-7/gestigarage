<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reparations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained()->onDelete('cascade');
            $table->text('description_panne');
            $table->text('remarque')->nullable();
            $table->decimal('cout_main_oeuvre', 10, 2)->default(0);
            $table->decimal('cout_pieces', 10, 2)->default(0);
            $table->enum('statut', ['en attente', 'en cours', 'terminee'])->default('en attente');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reparations');
    }
};
