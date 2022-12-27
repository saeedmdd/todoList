<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    const API_VERSION = '1.0.0';

    /**
     * Main structure of json response
     * @param null $message
     * @param null $data
     * @param bool $success
     * @param null $error
     * @return array
     */
    private static function setApiStructure($message = null, $data = null, bool $success = true, $error = null): array
    {
        return [
            "success" => $success,
            "message" => $message,
            "apiVersion" => self::API_VERSION,
            "error" => $error,
            "result" => $data
        ];
    }

    /**
     * @param $message
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public static function success($message = null, $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data), $code);
    }


    /**
     * @param $message
     * @param $data
     * @param $code
     * @param $error
     * @return JsonResponse
     */
    public static function error(
        $message = null,
        $data = null,
        int $code = Response::HTTP_BAD_REQUEST,
        $error = null
    ): JsonResponse
    {
        return response()->json(self::setApiStructure($message, $data, false, $error), $code);
    }
}
