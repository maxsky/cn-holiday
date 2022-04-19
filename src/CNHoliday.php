<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/27
 * Time: 21:58
 */

namespace Holiday;

use ArrayAccess;
use Carbon\Carbon;
use Countable;
use Holiday\Util\HolidayUtil;

class CNHoliday {

    private $year;
    private $storage_path;

    /** @var ArrayAccess|Countable */
    private $holidays;

    /** @var ArrayAccess|Countable */
    private $holidayDates;

    /** @var ArrayAccess|Countable */
    private $extraWorkDayDates;

    public function __construct(?int $year = null, ?string $storage_path = null) {
        $this->setParams($year, $storage_path);
    }

    /**
     * @param int|null    $year
     * @param string|null $storage_path
     *
     * @return CNHoliday
     */
    public function setParams(?int $year = null, ?string $storage_path = null): CNHoliday {
        if (!$year) {
            $year = Carbon::now()->year;
        }

        $this->year = $year;
        $this->storage_path = $storage_path;

        $holidayUtil = (new HolidayUtil($year))->setStoragePath($storage_path);
        $this->holidays = $holidayUtil->getHolidays();
        $this->holidayDates = $holidayUtil->getHolidayDates();
        $this->extraWorkDayDates = $holidayUtil->getExtraWorkDayDates();

        return $this;
    }

    /**
     * @return ArrayAccess|Countable
     */
    public function getHolidays() {
        return $this->holidays;
    }

    /**
     * @return ArrayAccess|Countable
     */
    public function getHolidayDates() {
        return $this->holidayDates;
    }

    /**
     * @return ArrayAccess|Countable
     */
    public function getExtraWorkDayDates() {
        return $this->extraWorkDayDates;
    }

    /**
     * @return bool
     */
    public function isTodayHoliday(): bool {
        $now = Carbon::now();

        return $this->holidayDates
            ->where('year', $now->year)
            ->where('month', $now->month)
            ->where('day', $now->day)
            ->count();
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return bool
     */
    public function isHoliday(int $year, int $month, int $day): bool {
        if ($year !== $this->year) {
            $this->setParams($year, $this->storage_path);
        }

        return $this->holidayDates
            ->where('year', $year)
            ->where('month', $month)
            ->where('day', $day)
            ->count();
    }

    /**
     * @return bool
     */
    public function isTodayOffDay(): bool {
        return $this->isTodayHoliday() || Carbon::now()->isWeekend();
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return bool
     */
    public function isOffDay(int $year, int $month, int $day): bool {
        if ($year !== $this->year) {
            $this->setParams($year, $this->storage_path);
        }

        return $this->isHoliday($year, $month, $day) || Carbon::createFromDate($year, $month, $day)->isWeekend();
    }

    /**
     * @return bool
     */
    public function isTodayExtraWorkDay(): bool {
        $now = Carbon::now();

        return $this->extraWorkDayDates
            ->where('year', $now->year)
            ->where('month', $now->month)
            ->where('day', $now->day)
            ->count();
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return bool
     */
    public function isExtraWorkDay(int $year, int $month, int $day): bool {
        if ($year !== $this->year) {
            $this->setParams($year, $this->storage_path);
        }

        return $this->extraWorkDayDates
            ->where('year', $year)
            ->where('month', $month)
            ->where('day', $day)
            ->count();
    }
}
