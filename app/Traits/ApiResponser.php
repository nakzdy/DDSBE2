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
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build error response
     *
     * @param string|array $message
     * @param int $code
     * @param int|null $site   // Add the $site parameter here
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code, $site = null)
    {
        $responseData = ['error' => $message, 'code' => $code];

        // Add the 'site' key to the response data if $site is provided
        if ($site !== null) {
            $responseData['site'] = $site;
        }

        return response()->json($responseData, $code);
    }
}