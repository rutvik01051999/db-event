<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * API Responce
 *
 * @version 1.0
 * @uses    API
 * @param   Request $request
 * @return  JsonResponse
 * @author  Jeetendrasinh Parmar <jeetendrasinh.parmar@bytestechnolab.in>
 */

trait ApiResponceTrait
{
    // Success
    public function success($data = [], $message = 'SUCCESS', $code = 200)
    {
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ]);
    }

    // Error
    public function error($message = "ERROR", $code = 400)
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'code' => $code
        ]);
    }

    // Validation

    public function validateRequest(Request $request, array $rules, array $customMessages = [])
    {
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        return null;
    }
}
