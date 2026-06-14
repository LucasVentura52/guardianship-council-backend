<?php
use Illuminate\Support\Facades\Route;
Route::get('/', fn () => response()->json(['aplicacao' => 'Conselho Tutelar API', 'status' => 'online']));
