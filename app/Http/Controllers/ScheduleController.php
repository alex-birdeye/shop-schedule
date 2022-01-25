<?php

namespace App\Http\Controllers;

use App\Http\Requests\IsShopOpenedRequest;
use App\Services\ScheduleService;

class ScheduleController extends Controller
{
    public function isOpened(IsShopOpenedRequest $request, ScheduleService $scheduleService)
    {
        return response()->json(
            [
                'is_opened' => $scheduleService->isOpened($request->get('date_to_check_timestamp'),
                    $request->get('timezone'))
            ]);
    }
}
