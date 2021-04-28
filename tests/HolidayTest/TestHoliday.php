<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:39
 */

use Holiday\CNHoliday;

class TestHoliday extends PHPUnit\Framework\TestCase {

    private $holiday;

    /**
     * @throws Exception
     */
    protected function setUp() {
        parent::setUp();

        $this->holiday = CNHoliday::getInstance()
            ->setFile(__DIR__ . '/../cn-holiday.ics');
    }

    public function testIsTodayHoliday() {
        $url = 'http://www.gov.cn/zhengce/zhengceku/2020-11/25/content_5564127.htm';



        var_dump($fileNum);
        die;
    }
}
