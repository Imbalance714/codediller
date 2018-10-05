<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/1/2018
 * Time: 10:14 PM
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

/**
 * Class CustomersTransformer
 * @package App\Transformers
 */
class CustomersTransformer extends TransformerAbstract
{
    /**
     * @param array $customer
     * @return array
     */
    public function transform(array $customer)
    {
        return [
            'name'    =>  ($customer['first_name'] && $customer['last_name']) ?  $customer['first_name'] .' '. $customer['last_name'] : null,
            'phone'   =>  $customer['addresses'] ? preg_filter('/[^0-9]/', '', $customer['addresses'][0]['phone']) : null,
        ];
    }
}