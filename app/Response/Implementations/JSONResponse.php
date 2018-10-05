<?php

namespace App\Response;


/**
 * Class JSONResponse
 * @package App\Response
 */
class JSONResponse implements APIResponseInterface
{
    /**
     * @param int $httpCode
     * @param null $data
     * @param array|null $navigation
     * @return string
     */
    public static function success(int $httpCode = 200, $data = null, array $navigation = null)
    {
        header('Content-type: application/json');

        return json_encode([
            'success'       =>  true,
            'code'          =>  $httpCode,
            'data'          =>  $data,
            'errors'        =>  null,
            'navigation'    =>  $navigation,
        ]);
    }

    /**
     * @param int $httpCode
     * @param array|null $errors
     * @param array|null $navigation
     * @return string
     */
    public static function failure(int $httpCode = 500, array $errors = null, array $navigation = null)
    {
        header('Content-type: application/json');

        return json_encode([
            'success'       =>  false,
            'code'          =>  $httpCode,
            'data'          =>  null,
            'errors'        =>  $errors,
            'navigation'    =>  $navigation,
        ]);
    }
}