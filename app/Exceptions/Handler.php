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
                $errors = collect($exception->errors())
                    ->map(function (array $messages, string $field) {
                        return array_map(function (string $message) use ($field) {
                            if ($message === 'validation.uploaded') {
                                if ($field === 'imagem') {
                                    return 'A imagem não pôde ser enviada. Verifique o tamanho do arquivo e tente novamente.';
                                }

                                return 'O arquivo não pôde ser enviado. Verifique o tamanho do arquivo e tente novamente.';
                            }

                            return $message;
                        }, $messages);
                    })
                    ->all();

                return response()->json([
                    'message' => 'Os dados enviados são inválidos.',
                    'errors' => $errors,
                ], 422);
            }
        });
    }

    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }
}
