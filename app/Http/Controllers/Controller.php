<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function baseJson(
        array $result,
        String $message,
        Int $code
    ) {
        $response = $result;
        $response['code'] = $code;
        $response['message'] = $message;

        return response()->json($response, $code);
    }

    public function successJson(
        array $result = [],
        String $message = 'Berhasil',
        Int $code = 200
    ) {
        return $this->baseJson(
            $result,
            $message,
            $code
        );
    }

    public function errorJson(
        array $result = [],
        String $message = 'Gagal',
        Int $code = 400
    ) {
        return $this->baseJson(
            $result,
            $message,
            $code
        );
    }

    public function exceptionJson(\Throwable $th)
    {
        $result = [
            'result' => [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'path' => $th->getFile()
            ]
        ];
        return $this->baseJson(
            $result,
            'Terjadi Kesalahan Server',
            500
        );
    }


}
