<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register(): void
    {
        $this->renderable(function (ValidationException $exception, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Os dados enviados são inválidos.',
                    'errors' => $exception->errors(),
                ], 422);
            }
        });
    }

    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }
}
