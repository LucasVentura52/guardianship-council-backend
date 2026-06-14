<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('sobre-projeto', fn () => $this->info('Plataforma Conselho Tutelar'));
