<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/1/2018
 * Time: 9:19 PM
 */

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

/**
 * Class ShopifyService
 * @package App\Services
 */
class ShopifyService
{
    /**
     * @return string
     */
    private function assembleRequestURL(): string
    {
        $shopifyAPIConfig = Config::get('shopify-store');
        return "https://{$shopifyAPIConfig['apiKey']}:{$shopifyAPIConfig['apiPassword']}@{$shopifyAPIConfig['domain']}";
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getCustomersByName(string $name) : ?array
    {
        $client = new Client([
            'base_uri'  =>  $this->assembleRequestURL(),
        ]);

        $response = $client->get('/admin/customers/search.json', [
            'query'  =>  [
                'query'      =>  $this->assembleQueryString($name),
                'fields'     => implode(',', [
                    'first_name',
                    'last_name',
                    'addresses',
                ])
            ]
        ])
            ->getBody()
            ->getContents();
        $response = json_decode($response, true);

        return !empty($response['customers'])
            ? $response['customers']
            : null;
    }

    /**
     * @param string $stringName
     * @return string
     */
    private function assembleQueryString(string $stringName) :string {
        return  "first_name:{$stringName}";
    }
}