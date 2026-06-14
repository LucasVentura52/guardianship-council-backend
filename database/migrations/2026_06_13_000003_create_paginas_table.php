<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('conteudo');
            $table->string('status')->default('publicado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paginas');
    }
};
