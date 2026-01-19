<?php

namespace App\Traits;

trait HandleResponseTrait
{

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    public function sendResponse($result = [], $message = '', $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        if (!empty($result)) {
            $response['data'] = $result;
        }
        return response()->json($response, $code);
    }
}
