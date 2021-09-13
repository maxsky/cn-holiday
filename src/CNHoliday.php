<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/27
 * Time: 21:58
 */

namespace Holiday;

use Carbon\Carbon;
use Holiday\Util\HolidayUtil;

class CNHoliday {

    private $holidayUtil;

    public function __construct(?int $year = null) {
        if (!$year) {
            $year = Carbon::now()->year;
        }

        $this->holidayUtil = new HolidayUtil($year);
    }

    public function isTodayHoliday() {
        $holidays = $this->holidayUtil->getHolidays();

        $now = Carbon::now();

        $month = $now->month;
        $day = $now->day;

        var_dump($holidays->where('month', $month)->where('day', $day)->first());
    }
}
