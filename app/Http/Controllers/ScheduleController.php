<?php

namespace App\Http\Controllers;

use App\Http\Requests\IsShopOpenedRequest;
use App\Services\ScheduleService;

class ScheduleController extends Controller
{
    /**
     * @var ScheduleService
     */
    private $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }


    public function isOpened(IsShopOpenedRequest $request)
    {
        $responseData              = [];
        $isOpened                  = $this->scheduleService
            ->isOpened($request->get('date_to_check_timestamp'), $request->get('timezone'));
        $responseData['is_opened'] = $isOpened;

        if (!$isOpened)
        {
            $responseData['will_open'] = $this->scheduleService
                ->willOpen($request->get('date_to_check_timestamp'), $request->get('timezone'));
        }

        return response()->json($responseData);
    }
}
