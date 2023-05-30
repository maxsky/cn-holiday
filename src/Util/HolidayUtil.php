<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/9/9
 * Time: 20:11
 */

namespace Holiday\Util;

use Holiday\Util\Traits\HolidayParserTrait;
use Tightenco\Collect\Support\Collection;

class HolidayUtil extends FileUtil {

    use HolidayParserTrait;

    protected $year;
    private $storagePath;

    /** @var Collection */
    private $holidays;

    public function __construct(int $year) {
        parent::__construct();

        $this->year = $year;
    }

    /**
     * @param string|null $storage_path
     *
     * @return HolidayUtil
     */
    public function setStoragePath(?string $storage_path): HolidayUtil {
        $this->storagePath = $storage_path;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getHolidays(): Collection {
        if (!$this->holidays) {
            $this->setHolidays();
        }

        return $this->holidays;
    }

    /**
     * @return Collection
     */
    public function getHolidayDates(): Collection {
        $dates = $this->holidays->pluck('dates');

        $result = [];

        $dates->map(function ($item) use (&$result) {
            $result = array_merge($result, $item);
        });

        return collect($result);
    }

    /**
     * @return Collection
     */
    public function getExtraWorkDayDates(): Collection {
        $dates = $this->holidays->pluck('extraWorkDays');

        $result = [];

        $dates->map(function ($item) use (&$result) {
            if ($item) {
                $result = array_merge($result, $item);
            }
        });

        return collect($result);
    }

    /**
     * @return void
     */
    private function setHolidays(): void {
        if ($this->storagePath) {
            $content = $this->getFileContent($this->storagePath);
        } else {
            $content = $this->httpGetFileContent($this->year);
        }

        $holidays = [];

        foreach (HOLIDAYS as $holiday) {
            $holidayBegin = $this->parseHolidayBegin($holiday, $content);

            $item = [
                'name' => $holiday,
                'year' => $holidayBegin->year,
                'month' => $holidayBegin->month,
                'day' => $holidayBegin->day,
                'length' => $this->parseHolidayLength($holiday, $content)
            ];

            $dates = [];

            for ($i = 0; $i < $item['length']; $i++) {
                $dates[] = [
                    'year' => $holidayBegin->year,
                    'month' => $holidayBegin->month,
                    'day' => $holidayBegin->day
                ];

                $holidayBegin->addDay();
            }

            $item['dates'] = $dates;

            $extraWork = $this->parseHasExtraWork($holiday, $content);

            $item['extraWork'] = $extraWork;

            if ($extraWork) {
                $item['extraWorkDays'] = $this->parseExtraWorkDays($holiday, $content);
            }

            $holidays[] = $item;
        }

        $this->holidays = collect($holidays);
    }
}
