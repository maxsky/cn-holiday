<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/27
 * Time: 21:58
 */

namespace Holiday;

use Carbon\Carbon;
use Holiday\Abstracts\AbstractHoliday;
use Holiday\Util\FileUtil;

class CNHoliday extends AbstractHoliday {

    use FileUtil;

    /** @var CNHoliday */
    public static $holiday;

    /**
     * @return CNHoliday
     */
    public static function getInstance(): CNHoliday {
        if (!self::$holiday) {
            self::$holiday = new self();
        }

        return self::$holiday;
    }

    public function isHolidayToday() {
        $date = Carbon::createFromTimeString('2021-05-01 14:34:42')->format('Ymd');

    }
}
