<?php
namespace App\Helpers;


    if (!function_exists('apiResponse')) {
        function apiResponse($status = 'success', $message = '', $data = null, $code = 200)
        {
            return response()->json([
                'status'  => $status,
                'message' => $message,
                'data'    => $data,
            ], $code);
        }
    }

