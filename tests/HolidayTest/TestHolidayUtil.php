<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:39
 */

use Holiday\Util\HolidayUtil;
use PHPUnit\Framework\TestCase;

class TestHolidayUtil extends TestCase {

    /**
     * @var int
     */
    private $year = 2022;

    /**
     * @throws Exception
     */
    protected function setUp() {
        parent::setUp();
    }

    public function testHolidayObject() {
        $holidayUtil = new HolidayUtil($this->year);

        $this->assertTrue(in_array(count($holidayUtil->getHolidays()), [6, 7]));
    }
}
