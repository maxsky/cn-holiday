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
use Tightenco\Collect\Support\Collection;

class CNHoliday {

    private $year;
    private $storage_path;

    /** @var Collection */
    private $holidays;

    /** @var Collection */
    private $holidayDates;

    /** @var Collection */
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
     * @return Collection
     */
    public function getHolidays(): Collection {
        return $this->holidays;
    }

    /**
     * @return Collection
     */
    public function getHolidayDates(): Collection {
        return $this->holidayDates;
    }

    /**
     * @return Collection
     */
    public function getExtraWorkDayDates(): Collection {
        return $this->extraWorkDayDates;
    }

    /**
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     *
     * @return string|null
     */
    public function getHolidayName(?int $year = null, ?int $month = null, ?int $day = null): ?string {
        $now = Carbon::today();

        if (!$year) {
            $year = $now->year;
        }

        if (!$month) {
            $month = $now->month;
        }

        if (!$day) {
            $day = $now->day;
        }

        $date = $this->holidayDates->where('year', $year)->where('month', $month)->where('day', $day)->first();

        $holiday = $this->holidays->first(function ($holiday) use ($date) {
            foreach ($holiday['dates'] as $item) {
                if ($item === $date) {
                    return true;
                }
            }

            return false;
        });

        return $holiday['name'] ?? null;
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
