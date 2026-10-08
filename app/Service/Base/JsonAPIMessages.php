<?php

namespace App\Service\Base;

use App\Service\Enum\HttpStatusCode;

trait JsonAPIMessages
{
    /**
     * RetrunData
     *
     * @param array $arr
     * @param mixed $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnData(array $arr, $code = HttpStatusCode::OK->value)
    {
        $data = [];

        $newdata = array_merge($data, $arr);

        return response()->json($newdata, $code);
    }
    /**
     * ErrorException
     *
     * @param mixed $code
     *
     * @param mixed $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorException($code, $message)
    {
        $data = ['error' => true, 'message' => $message];

        return response()->json($data, $code);
    }
    /**
     * Return Data With Message
     *
     * @param string $message
     * @param array $arr
     * @param mixed $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnDataWithMessage($message, array $arr, $code = HttpStatusCode::OK->value)
    {
        $data = ['error' => false, 'code' => $code, 'message' => $message, 'data' => $arr];

        return response()->json($data, $code);
    }
    /**
     * Return Data Without Message
     *
     * @param array $arr
     * @param mixed $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnDataWithoutMessage(array $arr, $code = HttpStatusCode::OK->value)
    {
        $data = ['data' => $arr];

        return response()->json($data, $code);
    }
}
