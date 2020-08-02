<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Manejo de errores de API
     * 
     * En caso de que no se trate de un error contemplado, retornará el estándar de Laravel
     */
    public function handleApiExceptions($request, $exception){
        if($exception instanceof ModelNotFoundException){
            return response()->json(['error' => 'Model Not Found'], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($request->expectsJson()){
            // Se trata de una petición a la API (el encabezado debe aceptar application/json)
            return $this->handleApiExceptions($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
