<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->text('contenu');
            $table->string('sujet')->nullable();
            $table->enum('statut', ['non_lu', 'lu', 'repondu'])->default('non_lu');
            $table->text('reponse_admin')->nullable();
            $table->timestamp('repondu_le')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
