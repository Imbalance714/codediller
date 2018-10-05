<?php

namespace App\Response;

/**
 * Interface APIResponseInterface
 * @package App\Response
 */
interface APIResponseInterface
{
    /**
     * @param int $httpCode
     * @param null $data
     * @param array|null $navigation
     * @return mixed
     */
    public static function success(int $httpCode = 200, $data = null, array $navigation = null);

    /**
     * @param int $httpCode
     * @param array|null $errors
     * @param array|null $navigation
     * @return mixed
     */
    public static function failure(int $httpCode = 500, array $errors = null, array $navigation = null);
}