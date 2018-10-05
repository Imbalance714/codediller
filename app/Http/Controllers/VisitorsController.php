<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\AddVisitorsRequest;
use App\Response\JSONResponse;
use App\Services\VisitorsService;

/**
 * Class VisitorsController
 * @package App\Http\Controllers
 */
class VisitorsController extends Controller
{
    /**
     * @var VisitorsService
     */
    private $visitorsService;

    /**
     * VisitorsController constructor.
     * @param VisitorsService $visitorsService
     */
    public function __construct(VisitorsService $visitorsService)
    {
        $this->visitorsService = $visitorsService;
    }

    /**
     * @param AddVisitorsRequest $request
     * @return string
     */
    public function addVisitors(AddVisitorsRequest $request) {
        //for local ip
        $visitorIp = $request->ip();
        if($visitorIp === "127.0.0.1") {
            $visitorIp = "62.221.40.178";
        }
        $this->visitorsService->addVisitors($request->data, $visitorIp);
        return JSONResponse::success();
    }
}
