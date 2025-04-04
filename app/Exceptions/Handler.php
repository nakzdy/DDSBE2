<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $statusCode = 500; // Default status code
        $errorMessage = $exception->getMessage() ?: 'Server Error';

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $errorMessage = $exception->getMessage() ?: 'HTTP Error';
        } elseif ($exception instanceof ValidationException) {
            $statusCode = 422;
            $errorMessage = $exception->validator->errors()->first();
        } elseif ($exception instanceof ModelNotFoundException) {
            $statusCode = 404;
            $errorMessage = 'Resource not found.';
        } elseif ($exception instanceof AuthorizationException) {
            $statusCode = 403;
            $errorMessage = 'Unauthorized action.';
        }

        $response = [
            'error' => $errorMessage,
            'site' => 2, 
            'code' => $statusCode,
        ];

        return response()->json($response, $statusCode);
    }
}