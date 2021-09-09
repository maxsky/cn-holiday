<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:39
 */

use Holiday\CNHoliday;
use Holiday\Struct\Holiday;
use Holiday\Util\FileUtil;
use Holiday\Util\Traits\HolidayParserTrait;

class TestHoliday extends PHPUnit\Framework\TestCase {

    use HolidayParserTrait;

    /**
     * @throws Exception
     */
    protected function setUp() {
        parent::setUp();

        $this->year = 2017;
    }

    public function testIsTodayWorkday() {
        $this->assertTrue(is_bool(CNHoliday::getInstance()->addYear()->addMonth()->addDays()->isWeekend()));
    }

    public function testHolidayObject() {
        $fileContent = json_decode(
            file_get_contents(__DIR__ . '/../Files/2017.json'), true
        )['content'];

        $fileContent = $this->trimHtmlTags($fileContent);

        $holidays = [];

        foreach (FESTIVALS as $holiday) {
            $obj = new Holiday();

            $holidayBegin = $this->parseHolidayBegin($holiday);

            $obj->setName($holiday);
            $obj->setYear($this->year);
            $obj->setMonth($holidayBegin->month);
            $obj->setDay($holidayBegin->day);
            $obj->setLength($this->parseHolidayLength($holiday));

            $extraWork = $this->parseHasExtraWork($holiday);

            $obj->setExtraWork($extraWork);

            if ($extraWork) {
                $obj->setExtraWorkDays($this->parseExtraWorkDays($holiday));
            }

            $holidays[] = $obj;
        }

        $this->assertNotEmpty($holidays);
    }
}
