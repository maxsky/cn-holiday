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

    public $year;

    private $content;

    public function __construct(?int $year = null) {
        parent::__construct();

        $this->year = $year;
    }

    /**
     * @param string|null $storage_path
     *
     * @return Collection
     */
    private function setHolidays(?string $storage_path = null): Collection {
        if ($storage_path) {
            $this->content = $this->getFileContent($storage_path);
        } else {
            $this->content = $this->httpGetFileContent();
        }

        $holidays = collect();

        foreach (FESTIVALS as $holiday) {
            $obj = new Holiday();

            $holidayBegin = $this->parseHolidayBegin($holiday, $this->content);

            $obj->setName($holiday);
            $obj->setYear($this->year);
            $obj->setMonth($holidayBegin->month);
            $obj->setDay($holidayBegin->day);
            $obj->setLength($this->parseHolidayLength($holiday, $this->content));

            $extraWork = $this->parseHasExtraWork($holiday, $this->content);

            $obj->setExtraWork($extraWork);

            if ($extraWork) {
                $obj->setExtraWorkDays($this->parseExtraWorkDays($holiday, $this->content));
            }

            $holidays->add($obj);
        }

        return $holidays;
    }
}
