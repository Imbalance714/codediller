<?php
namespace App\Listeners\Visitor;

use App\Events\Visitor\VisitorCreated;
use App\Models\Countries;
use App\Models\Visitors;
use App\Services\VisitorsService;
use App\Services\CountryService;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

/**
 * @const int
 */
const DEFAULT_RETRIES_COUNT = 5;

/**
 * Class SyncProductsWithRemoteSource
 * @package App\Listeners\Products
 */
class VisitorListener implements ShouldQueue
{
    use InteractsWithQueue;
    private $visitorService;
    private $countryService;

    /**
     * @var int
     */
    public $tries = DEFAULT_RETRIES_COUNT;

    public function __construct(VisitorsService $visitorService,
                                CountryService $countryService)
    {
        $this->visitorService = $visitorService;
        $this->countryService = $countryService;
    }

    public function handle(VisitorCreated $event)
    {
        $data = $this->obtainLocationData($event->visitorIp);
        $this->updateVisitorRecord($data, $event->visitorId);
    }

    public function obtainLocationData($visitorIp) {
        $apixuAPIConfig = Config::get('apixu');
        $client = new Client([
            'base_uri'  =>  "https://{$apixuAPIConfig['domain']}",
        ]);

        $response = $client->get('/v1/current.json', [
            'query'  =>  [
                'key'      =>  $apixuAPIConfig['apiKey'],
                'q'        =>  $visitorIp,
            ]
        ])
            ->getBody()
            ->getContents();

        $response = json_decode($response, true);

        return $response;
    }
    public function updateVisitorRecord($data, $visitorId) {
        $country = $this->getCountry($data['location']['country']);
        $weather = $data['current']['condition']['text'] . ', ' . $data['current']['temp_c'] . ' C';
        $visitorData = [
            'country_id' => $country['id'],
             'weather' => $weather
        ];
        $this->visitorService->updateVisitor($visitorId, $visitorData);
    }

    public function getCountry($countryName){
        return $this->countryService->createIfNotExist($countryName);
    }

}