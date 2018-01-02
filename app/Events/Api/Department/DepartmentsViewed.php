<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Department;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DepartmentsViewed extends ApiRequestEvent
{

    /**
     * DepartmentsViewed constructor.
     * @param array $departmentIds
     */
    public function __construct($departmentIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed departments - ';
        $logContext = [
            'action' => 'view',
            'model' => 'department',
            'department_ids' => $departmentIds,
            'department_id_count' => count($departmentIds),
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Department',
                'viewed ' . count($departmentIds) . ' departments',
                $user->id,
                'cubes',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
