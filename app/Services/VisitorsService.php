<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/1/2018
 * Time: 9:18 PM
 */

namespace App\Services;

use App\Events\Visitor\VisitorCreated;
use App\Models\Visitors;
use Illuminate\Support\Facades\DB;


/**
 * Class VisitorsService
 * @package App\Services
 */
class VisitorsService
{
    /**
     * @var Visitors
     */
    private $visitor;

    /**
     * VisitorsService constructor.
     */
    public function __construct()
    {
        $this->visitor = new Visitors();
    }

    /**
     * @param array $visitors
     * @param string $visitorIp
     * @throws \Exception
     */
    public function addVisitors(array $visitors, string $visitorIp) {
        try {
            $groupLeader = array_shift($visitors);
            DB::beginTransaction();
            $groupLeaderId = $this->visitor->insertGetId($groupLeader);
            $records = [];
            foreach ($visitors as $visitor) {
                $records[]= [
                    'name' => $visitor['name'],
                    'phone' => $visitor['phone'],
                    'invited_by' => $groupLeaderId
                ];
            }
            $this->visitor->insert($records);
            DB::commit();
            event(new VisitorCreated($groupLeaderId, $visitorIp));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param string $visitorId
     * @param array $data
     *  @option integer "country_id" Country id from countries table
     *  @option string "weather" Weather from request
     */
    public function updateVisitor(string $visitorId, array $data)  {
        //without eloquement::find cause extra query to db
        $this->visitor->query()->where('id', $visitorId)->update($data);
    }
}