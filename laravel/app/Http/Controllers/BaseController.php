<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function petnetResponse($code, $message, $result = null, $httpCode = 200, $errorType = null, $errorMessage = null) {
        
        if ($httpCode === 200) {
            return response()->json(
                [
                    "code" => $code,
                    "message" => $message,
                    "data" => $result
                ],
                $httpCode
            );
        }

        return response()->json(
            [
                "code" => $code,
                "message" => $message,
                "data" => [
                    "type" => $errorType,
                    "message" => $errorMessage
                ]
            ],
            $httpCode
        );
    }
}
