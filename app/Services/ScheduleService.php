<?php
/**
 * Created by PhpStorm.
 * User: youser
 * Date: 25.01.22
 * Time: 13:32
 */

namespace App\Services;


use App\Models\ShopSettings;
use Carbon\Carbon;

class ScheduleService
{

    public function isOpened($dateToCheckTimestamp, $timezone)
    {
        $dateToCheck = Carbon::createFromTimestamp($dateToCheckTimestamp, $timezone);

        if (!$this->isWorkingDay($dateToCheck))
        {
            return false;
        }

        if ($this->isNonWorkingHours($dateToCheck, $timezone))
        {
            return false;
        }

        if (!$this->isWorkingHours($dateToCheck, $timezone))
        {
            return false;
        }

        return true;
    }

    private function isWorkingDay(Carbon $dateToCheck)
    {
        $workingDays = ShopSettings::select('data')->where('setting_name', 'working_days')->first()->data;

        return $workingDays[$dateToCheck->dayOfWeek];
    }

    private function isNonWorkingHours(Carbon $dateToCheck, $timezone)
    {
        $nonWorkingHours = ShopSettings::select('data')->where('setting_name', 'non_working_hours')->first()->data;
        $from            = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $nonWorkingHours['from'], $timezone);
        $to              = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $nonWorkingHours['to'], $timezone);

        return ($dateToCheck >= $from && $dateToCheck <= $to->endOfMinute());

    }

    private function isWorkingHours($dateToCheck, $timezone)
    {
        $workingHours = ShopSettings::select('data')->where('setting_name', 'working_hours')->first()->data;
        $from            = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $workingHours['from'], $timezone);
        $to              = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $workingHours['to'], $timezone);

        return ($dateToCheck >= $from && $dateToCheck <= $to->endOfMinute());
    }
}