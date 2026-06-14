<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('midias', function (Blueprint $table) { $table->id(); $table->string('nome_original'); $table->string('arquivo'); $table->string('mime_type', 100); $table->unsignedBigInteger('tamanho')->default(0); $table->string('alt_text')->nullable(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('midias'); }
};
