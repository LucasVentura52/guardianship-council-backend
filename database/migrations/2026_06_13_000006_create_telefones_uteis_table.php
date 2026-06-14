<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('telefones_uteis', function (Blueprint $table) { $table->id(); $table->string('titulo'); $table->string('telefone', 40); $table->text('descricao')->nullable(); $table->enum('status', ['publicado', 'inativo'])->default('publicado'); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('telefones_uteis'); }
};
