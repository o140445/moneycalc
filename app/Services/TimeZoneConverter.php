<?php

namespace App\Services;

class TimeZoneConverter
{
    public function convert($time, $fromTimezone, $toTimezone)
    {
        $date = new \DateTime($time, new \DateTimeZone($fromTimezone));
        $date->setTimezone(new \DateTimeZone($toTimezone));
        return $date->format('Y-m-d H:i:s');
    }
}