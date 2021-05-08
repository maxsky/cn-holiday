<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:39
 */

use Holiday\Util\HolidayParser;

class TestHoliday extends PHPUnit\Framework\TestCase {

    use HolidayParser;

    const HOLIDAYS = ['元旦', '春节', '清明节', '劳动节', '端午节', '中秋节', '国庆节'];

    const RECESS = '放假';

    private $fileContent;
    private $year;

    /**
     * @throws Exception
     */
    protected function setUp() {
        parent::setUp();

        $this->year = 2021;
    }

    public function testIsTodayHoliday() {
        $url = 'http://www.gov.cn/zhengce/zhengceku/2020-11/25/content_5564127.htm';
    }

    public function testHolidayObject() {
        $this->fileContent = file_get_contents(__DIR__ . '/../Files/2020.json');

        foreach (self::HOLIDAYS as $holiday) {
            var_dump($this->parseHolidayBegin($holiday)->toDateTimeString());
            var_dump($this->parseHolidayLength($holiday));
        }

    }
}
