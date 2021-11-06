<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:39
 */

namespace HolidayTest;

use Exception;
use Holiday\CNHoliday;
use Holiday\Util\HolidayUtil;
use Holiday\Util\Traits\HolidayParserTrait;
use PHPUnit\Framework\TestCase;

class TestHoliday extends TestCase {

    use HolidayParserTrait;

    /**
     * @var int
     */
    private $year = 2021;

    /**
     * @throws Exception
     */
    protected function setUp() {
        parent::setUp();
    }

    public function testParser() {
        $content = json_decode(
            file_get_contents(__DIR__ . "/../Files/$this->year.json"), true
        )['content'];

        $content = $this->trimHtmlTags($content);

        try {
            foreach (HOLIDAYS as $holiday) {
                $this->parseHolidayBegin($holiday, $content);
                $this->parseHolidayLength($holiday, $content);

                $extraWork = $this->parseHasExtraWork($holiday, $content);

                if ($extraWork) {
                    $this->parseExtraWorkDays($holiday, $content);
                }
            }
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testHolidayObject() {
        $holidayUtil = new HolidayUtil($this->year);

        $this->assertTrue(in_array(count($holidayUtil->getHolidays()), [6, 7]));
    }

    public function testClass() {
        $holiday = new CNHoliday($this->year);

        $this->assertTrue(is_bool($holiday->isTodayHoliday()));
        $this->assertTrue($holiday->isHoliday(2021, 10, 1));
        $this->assertTrue(is_bool($holiday->isTodayOffDay()));
        $this->assertTrue($holiday->isOffDay(2021, 10, 7));
        $this->assertTrue(is_bool($holiday->isTodayExtraWorkDay()));
        $this->assertTrue($holiday->isExtraWorkDay(2021, 10, 8));

    }
}
