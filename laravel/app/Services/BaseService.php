<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BaseService
{
    protected function requestError($code, $message, $error)
    {
        return response()->json(array(
            "code" => $code,
            "message" => $message,
            "error" => $error
        ), $code);
    }

    protected function executeFunction(callable $function)
    {
        DB::beginTransaction();

        try {
            $data = call_user_func($function);
            DB::commit();

            return response()->json(array(
                "code" => 200,
                "message" => "Good",
                "result" => $data
            ), 200);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(array(
                "code" => 500,
                "message" => "Failed",
                "error" => $e->getMessage()
            ), 500);
        }
    }

}
