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

        if ($dateToCheck->dayOfWeek === 6 && $workingDays[$dateToCheck->dayOfWeek])
        {
            return boolval($dateToCheck->weekOfYear%2);
        }

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
        return ($this->isWorkingHoursStarted($dateToCheck, $timezone) &&
                !$this->isWorkingHoursEnded($dateToCheck, $timezone));
    }

    public function willOpen($dateToCheckTimestamp, $timezone)
    {
        $dateToCheck = Carbon::createFromTimestamp($dateToCheckTimestamp, $timezone);
        $nearestDate = null;

        if (!$this->isWorkingDay($dateToCheck) || $this->isWorkingHoursEnded($dateToCheck, $timezone))
        {
            $nearestDate = $this->findNearestWorkingDay($dateToCheck);
        }

        if ($this->isNonWorkingHours($dateToCheck, $timezone) || !$this->isWorkingHoursStarted($dateToCheck, $timezone))
        {
            $nearestDate = $this->findNearestWorkingHour($dateToCheck);
        }

        return $dateToCheck->diffForHumans($nearestDate, true, false, 2);
    }

    private function findNearestWorkingDay(Carbon $dateToCheck)
    {
        $nearest = $dateToCheck->copy();
        $nearest->addDay();

        while (!$this->isWorkingDay($nearest))
        {
            $nearest->addDay();
        }

        $workingHoursFrom = ShopSettings::select('data')->where('setting_name', 'working_hours')->first()->data['from'];
        $from             = explode(':', $workingHoursFrom);

        return $nearest->setTime($from[0], $from[1]);
    }

    private function findNearestWorkingHour($dateToCheck)
    {
        $nonWorkingToCarbon = $dateToCheck->copy();
        $workingFromCarbon  = $dateToCheck->copy();

        $nonWorkingHoursTo = ShopSettings::select('data')
                                         ->where('setting_name', 'non_working_hours')->first()->data['to'];
        $nonWorkingTo      = explode(':', $nonWorkingHoursTo);
        $nonWorkingToCarbon->setTime($nonWorkingTo[0], $nonWorkingTo[1]);

        $workingHoursFrom = ShopSettings::select('data')
                                        ->where('setting_name', 'working_hours')->first()->data['from'];
        $workingFrom      = explode(':', $workingHoursFrom);
        $workingFromCarbon->setTime($workingFrom[0], $workingFrom[1]);

        if ($dateToCheck < $workingFromCarbon )
        {
            return $workingFromCarbon;
        }

        return $nonWorkingToCarbon;
    }

    private function isWorkingHoursEnded($dateToCheck, $timezone)
    {
        $workingHours = ShopSettings::select('data')->where('setting_name', 'working_hours')->first()->data;
        $to           = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $workingHours['to'], $timezone);

        return $dateToCheck >= $to->endOfMinute();
    }

    private function isWorkingHoursStarted($dateToCheck, $timezone)
    {
        $workingHours = ShopSettings::select('data')->where('setting_name', 'working_hours')->first()->data;
        $from         = Carbon::parse($dateToCheck->format('Y-m-d') . ' ' . $workingHours['from'], $timezone);

        return $dateToCheck >= $from;
    }
}