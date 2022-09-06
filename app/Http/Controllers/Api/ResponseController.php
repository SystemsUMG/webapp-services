<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function jsonResponse($records, $result, $message, $statusCode)
    {
        $response = [
            'records' => $records,
            'result' => $result,
            'message' => $message,
        ];
        return response()->json($response, $statusCode);
    }
}
