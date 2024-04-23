<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([

                'message' => 'Validation failed',
                'status' => false,
                'errors' => $exception->errors(),
            ], 200);
        }
        if ($exception instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            $response = [
                'status' => false,
                'message' => 'Unauthenticated',
            ];
    
            return response()->json($response, 401);
        }
    
        if ($exception instanceof MethodNotAllowedHttpException) {
            $response = [
                'message' => 'Unauthenticated',
            ];
    
            return response()->json($response, 401);
        }
        return parent::render($request, $exception);
    }

    
}
