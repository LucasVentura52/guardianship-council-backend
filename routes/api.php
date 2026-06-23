<?php

use App\Http\Controllers\Api\CampanhaController;
use App\Http\Controllers\Api\NoticiaController;
use App\Http\Controllers\Api\PaginaController;
use App\Http\Controllers\Api\SugestaoController;
use App\Http\Controllers\Api\ContatoController;
use App\Http\Controllers\Api\TelefoneUtilController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ConfiguracaoController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\VisitaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CampanhaAdminController;
use App\Http\Controllers\Admin\NoticiaAdminController;
use App\Http\Controllers\Admin\PaginaAdminController;
use App\Http\Controllers\Admin\TelefoneUtilAdminController;
use App\Http\Controllers\Admin\SugestaoAdminController;
use App\Http\Controllers\Admin\MensagemAdminController;
use App\Http\Controllers\Admin\MidiaAdminController;
use App\Http\Controllers\Admin\ConfiguracaoAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('home', [HomeController::class, 'index']);
Route::get('configuracoes', [ConfiguracaoController::class, 'index']);
Route::get('arquivos/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }

    $disk = Storage::disk('public');

    if (! $disk->exists($path)) {
        abort(404);
    }

    return $disk->response($path, null, [
        'Cache-Control' => 'public, max-age=31536000, immutable',
    ]);
})->where('path', '.*');
Route::get('campanhas', [CampanhaController::class, 'index']);
Route::get('campanhas/{slug}', [CampanhaController::class, 'show']);
Route::get('noticias', [NoticiaController::class, 'index']);
Route::get('noticias/{slug}', [NoticiaController::class, 'show']);
Route::get('paginas/{slug}', [PaginaController::class, 'show']);
Route::get('telefones-uteis', [TelefoneUtilController::class, 'index']);
Route::get('sugestoes-aprovadas', [SugestaoController::class, 'aprovadas']);
Route::post('sugestoes', [SugestaoController::class, 'store'])->middleware('throttle:sugestoes');
Route::post('contato', [ContatoController::class, 'store'])->middleware('throttle:contato');
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('esqueci-senha', [PasswordController::class, 'forgot'])->middleware('throttle:esqueci-senha');
Route::post('redefinir-senha', [PasswordController::class, 'reset'])->middleware('throttle:redefinir-senha');
Route::post('visitas', [VisitaController::class, 'store'])->middleware('throttle:visitas');

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('usuario', [AuthController::class, 'usuario']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::apiResource('campanhas', CampanhaAdminController::class);
    Route::apiResource('noticias', NoticiaAdminController::class);
    Route::apiResource('paginas', PaginaAdminController::class);
    Route::apiResource('telefones-uteis', TelefoneUtilAdminController::class)
        ->parameters(['telefones-uteis' => 'telefoneUtil']);
    Route::get('sugestoes', [SugestaoAdminController::class, 'index']);
    Route::put('sugestoes/{id}/aprovar', [SugestaoAdminController::class, 'aprovar']);
    Route::put('sugestoes/{id}/reprovar', [SugestaoAdminController::class, 'reprovar']);
    Route::get('mensagens', [MensagemAdminController::class, 'index']);
    Route::put('mensagens/{id}/marcar-como-lida', [MensagemAdminController::class, 'marcarComoLida']);
    Route::delete('mensagens/{id}', [MensagemAdminController::class, 'destroy']);
    Route::get('midias', [MidiaAdminController::class, 'index']);
    Route::post('midias', [MidiaAdminController::class, 'store']);
    Route::delete('midias/{midia}', [MidiaAdminController::class, 'destroy']);
    Route::get('configuracoes', [ConfiguracaoAdminController::class, 'index']);
    Route::put('configuracoes', [ConfiguracaoAdminController::class, 'update']);
    Route::put('senha', [PasswordController::class, 'change'])->middleware('throttle:alterar-senha');
    Route::post('logout', [AuthController::class, 'logout']);
});
