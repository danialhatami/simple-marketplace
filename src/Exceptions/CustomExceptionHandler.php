<?php

namespace Danial\SimpleMarketplace\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $e): JsonResponse
    {
        return match (true) {
            $e instanceof ValidationException => response()->json(['message' => 'Oops! Validation failed.'], Response::HTTP_UNPROCESSABLE_ENTITY),
            $e instanceof AuthorizationException => response()->json(['message' => 'Hold on! Access Denied'], Response::HTTP_UNAUTHORIZED),
            $e instanceof AuthenticationException => response()->json(['message' => 'Hold on! You must login'], Response::HTTP_UNAUTHORIZED),
            default => response()->json(['message' => 'Uh-oh! Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR),
        };
    }
}
