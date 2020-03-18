<?php

namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
//        if (config('app.debug'))
//            dd($e);

        if ($this->isJWTException($e)) {
            return $this->JWTExceptionResponse($e);
        }

        if ($this->isValidation($e)) {
            return $this->validationResponse($e);
        }
        if ($this->isModel($e)) {
            return $this->modelResponse($e);
        }

        if ($this->isHttp($e)) {
            return $this->httpResponse($e);
        }

        if ($this->isUnAuthorize($e)) {
            return $this->notAuthorize($e);
        }
        if ($this->isQueryException($e)) {
            return $this->queryExceptionResponse($e);
        }
        if ($this->isGenericException($e)) {
            return $this->serverResponse($e);
        }
        return parent::render($request, $e);

    }

    protected function isGenericException($e)
    {
        return $e instanceof Exception;
    }
    protected function isQueryException($e)
    {
        return $e instanceof QueryException;
    }

    protected function isJWTException($e)
    {
        return $e instanceof JWTException;
    }

    protected function isValidation($e)
    {
        return $e instanceof ValidationException;
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isUnAuthorize($e)
    {
        return $e instanceof AuthorizationException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function acceptExceptionResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => $e->getMessage(),
            'error_type' => 'AcceptableException',
            'code' => Response::HTTP_NOT_ACCEPTABLE
        ]], Response::HTTP_NOT_ACCEPTABLE);
    }

    protected function JWTExceptionResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => 'could not create token!',
            'error_type' => 'JWTException',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
        ]], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function serverResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => $e->getMessage(),
            'error_type' => 'InternalServerError',
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR
        ]], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function validationResponse($e)
    {
        $keys = array_keys($e->validator->errors()->getmessages());
        $error_message = $e->validator->errors()->getmessages()[$keys[0]][0];
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => $error_message,
            'error_type' => 'APIInvalidParametersError',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY
        ]], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function modelResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => $e->getMessage(),
            'error_type' => "NotFound",
            'code' => Response::HTTP_NOT_FOUND
        ]], Response::HTTP_NOT_FOUND);
    }

    protected function httpResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => "method not found!",
            'error_type' => "NotFound",
            'code' => Response::HTTP_METHOD_NOT_ALLOWED
        ]], Response::HTTP_METHOD_NOT_ALLOWED);
    }
    protected function notAuthorize($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
            'error_message' => "auth required!",
            'error_type' => "OAuthPermissionsException",
            'code' => Response::HTTP_UNAUTHORIZED
        ]], Response::HTTP_UNAUTHORIZED);
    }
    protected function queryExceptionResponse($e)
    {
        return response()->json([
            'data'=>null,
            'meta' => [
                'error_message' => "could not execute query!",
                'error_type' => "QueryException",
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
