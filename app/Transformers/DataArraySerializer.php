<?php

namespace App\Transformers;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class DataArraySerializer
 * @package App\Transformers
 */
class DataArraySerializer extends ArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }

        return [ $resourceKey ?: 'data' => $data ];
    }

    /**
     * @return null
     */
    public function null()
    {
        return null;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }

        return [ $resourceKey ?: 'data' => $data ];
    }
}