<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
    $statusCode = 500;
    $message = $exception->getMessage() ?: 'An error occurred.';

    if ($exception instanceof ValidationException) {
      $statusCode = 422;
      $errors = $exception->errors();
      return response()->json([
        'status' => $statusCode,
        'errors' => $errors,
        'message' => $message,
      ], $statusCode);
    }

    if ($exception instanceof AuthenticationException) {
      return response()->json([
        'status' => 401,
        'message' => $message,
      ], 401);
    }

    if ($exception instanceof NotFoundHttpException) {
      $statusCode = 404;
      $message = 'API route not found.';
      return response()->json([
        'status' => $statusCode,
        'message' => $message,
      ], $statusCode);
    }

    if ($exception instanceof HttpException) {
      $statusCode = $exception->getStatusCode();
      $message = $message;
    }

    // For other exceptions, return a 500 status code
    return response()->json([
      'status' => $statusCode,
      'message' => $message,
    ], $statusCode);
  }

  /**
   * Determine if the exception should be reported.
   *
   * @param  \Throwable  $exception
   * @return bool
   */
  public function shouldReport(Throwable $exception)
  {
    // You can filter which exceptions should be reported here
    return true;
  }

  /**
   * Render an exception for the console.
   *
   * @param  \Symfony\Component\Console\Output\OutputInterface  $output
   * @param  \Throwable  $exception
   * @return void
   */
  public function renderForConsole($output, Throwable $exception)
  {
    $output->writeln($exception->getMessage());
  }
}
