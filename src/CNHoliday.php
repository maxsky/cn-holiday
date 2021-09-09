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

class CNHoliday extends Carbon {

    /** @var CNHoliday */
    public static $holiday;

    private $holidayUtil;

    public function __construct($time = null, $tz = null) {
        parent::__construct($time, $tz);

        $this->holidayUtil = new HolidayUtil();
    }

    /**
     * @return CNHoliday
     */
    public static function getInstance(): CNHoliday {
        if (!self::$holiday) {
            self::$holiday = new self();
        }

        return self::$holiday;
    }
}
