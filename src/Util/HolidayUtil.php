<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/9/9
 * Time: 20:11
 */

namespace Holiday\Util;

use Holiday\Struct\Holiday;
use Holiday\Util\Traits\HolidayParserTrait;
use Illuminate\Support\Collection;

class HolidayUtil extends FileUtil {

    use HolidayParserTrait;

    private $year;
    private $storagePath;
    private $holidays;

    public function __construct(int $year) {
        parent::__construct();

        $this->year = $year;
    }

    /**
     * @param string $storage_path
     *
     * @return $this
     */
    public function setStoragePath(string $storage_path): HolidayUtil {
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
     * @return void
     */
    private function setHolidays(): void {
        if ($this->storagePath) {
            $content = $this->getFileContent($this->storagePath);
        } else {
            $content = $this->httpGetFileContent();
        }

        $holidays = collect();

        foreach (FESTIVALS as $holiday) {
            $obj = new Holiday();

            $holidayBegin = $this->parseHolidayBegin($holiday, $content);

            $obj->setName($holiday);
            $obj->setYear($this->year);
            $obj->setMonth($holidayBegin->month);
            $obj->setDay($holidayBegin->day);
            $obj->setLength($this->parseHolidayLength($holiday, $content));

            $extraWork = $this->parseHasExtraWork($holiday, $content);

            $obj->setExtraWork($extraWork);

            if ($extraWork) {
                $obj->setExtraWorkDays($this->parseExtraWorkDays($holiday, $content));
            }

            $holidays->add($obj);
        }

        $this->holidays = $holidays;
    }
}
