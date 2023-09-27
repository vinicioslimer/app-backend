<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {

            if ($request->expectsJson()) {

                if ($e instanceof TokenInvalidException) {
                    return response()->json(['error' => 'Token is invalid'], 401);

                } else if ($e instanceof TokenExpiredException) {
                    return response()->json(['error' => 'Token is expired'], 401);

                } else if ($e instanceof NotFoundHttpException) {
                    return response()->json(['error' => $e->getMessage()], 404);

                } else {
                    return response()->json(['error' => 'Unexpected error: ' . $e->getMessage()], 500);
                }
            }
        });
    }
}
