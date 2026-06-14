<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paginas', function (Blueprint $table) {
            $table->string('chamada')->nullable()->after('slug');
            $table->text('resumo')->nullable()->after('chamada');
            $table->string('icone', 30)->default('document')->after('resumo');
        });
    }

    public function down(): void
    {
        Schema::table('paginas', function (Blueprint $table) {
            $table->dropColumn(['chamada', 'resumo', 'icone']);
        });
    }
};
