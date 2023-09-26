<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
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
            if ($request->is('api/*')) {
                $error = '';
                if ($e instanceof TokenInvalidException) {
                    $error = 'Token is invalid';
                } else if ($e instanceof TokenExpiredException) {
                    $error = 'Token is expired';
                } else {
                    $error = 'Authorization Token not found';
                }
                return response()->json(['error' => $error], 401);
            }
        });
    }
}
