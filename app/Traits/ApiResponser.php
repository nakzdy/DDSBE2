<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response
     *
     * @param string|array $data
     * @param int $code
     * @param int|null $site   // Add the $site parameter here
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK, $site = 2)
    {
        return response()->json([
            'data' => $data,
            'site' => $site,
        ], $code);
    }

    /**
     * Build error response
     *
     * @param string|array $message
     * @param int $code
     * @param int|null $site   // Add the $site parameter here
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code, $site = 2)
    {
        $responseData = ['error' => $message, 'code' => $code, 'site' => $site];

        return response()->json($responseData, $code);
    }
}