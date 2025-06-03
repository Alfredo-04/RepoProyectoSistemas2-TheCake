<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * Lista de excepciones que no se reportan.
     */
    protected $dontReport = [
        //
    ];

    /**
     * Inputs que nunca se deben mostrar en errores de validación.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Renderizar una excepción en una respuesta HTTP.
     */
    public function render($request, Throwable $exception)
    {
        $statusCode = $this->isHttpException($exception) 
                    ? $exception->getStatusCode() 
                    : 500;

        $view = "errors.{$statusCode}";

        // Datos que siempre vamos a enviar a la vista
        $data = [
            'exception' => $exception,
            'code' => $statusCode,
            'title' => $exception->getMessage() ?: 'Error',
            'message' => null,
        ];

        if (view()->exists($view)) {
            return response()->view($view, $data, $statusCode);
        }

        // Vista fallback si no existe la específica
        return response()->view('errors.default', $data, $statusCode);
    }
}
