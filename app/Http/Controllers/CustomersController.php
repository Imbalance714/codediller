<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\GetCustomerRequest;
use App\Response\JSONResponse;
use Illuminate\Http\Request;
use App\Services\ShopifyService;
use App\Transformers\DataArraySerializer;
use App\Transformers\CustomersTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * Class CustomersController
 * @package App\Http\Controllers
 */
class CustomersController extends Controller
{
    /**
     * @var ShopifyService
     */
    private $shopifyService;
    /**
     * @var Manager
     */
    private $transformManager;
    /**
     * @var DataArraySerializer
     */
    private $serializer;

    /**
     * CustomersController constructor.
     * @param ShopifyService $shopifyService
     * @param Manager $transformManager
     * @param DataArraySerializer $serializer
     */
    public function __construct(ShopifyService $shopifyService,
                                Manager $transformManager,
                                DataArraySerializer $serializer)
    {
        $this->shopifyService = $shopifyService;
        $this->transformManager = $transformManager;
        $this->serializer = $serializer;
        $this->transformManager->setSerializer($serializer);
    }

    /**
     * @param GetCustomerRequest $request
     * @return string
     */
    public function getCustomersBySearchString(GetCustomerRequest $request) {
        $customers = $this->shopifyService->getCustomersByName($request['name']);

        if (empty($customers)) {
            return JSONResponse::failure(404);
        }
        $transformed = $this
            ->transformManager
            ->createData(new Collection($customers, new CustomersTransformer(), false))
            ->toArray();

        return JSONResponse::success(200, $transformed);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('welcome');
    }
}
