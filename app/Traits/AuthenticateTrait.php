<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

/**
 * Authenticate 
 *
 * @version 1.0
 * @uses    API
 * @param   Request $request
 * @return  JsonResponse
 * @author  Jeetendrasinh Parmar <jeetendrasinh.parmar@bytestechnolab.in>
 */

trait AuthenticateTrait
{
    public function authenticateWithHono($username, $password): bool
    {
        $postRequest = [
            'uname' => base64_encode($username),
            'pass'  => base64_encode($password)
        ];
        try {
            $response = Http::withHeaders(['Authorization' => env("HONO_HR_AUTH_TOKEN")])->asForm()->post(config('project.HONO_HR_AUTH_URL'), $postRequest);

            $status = isset($response->object()->status) && $response->object()->status == 1 ? true : false;
            return $status;
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
