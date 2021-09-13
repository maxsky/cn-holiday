<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/9/13
 * Time: 13:45
 */

use Holiday\Util\Traits\HolidayParserTrait;
use PHPUnit\Framework\TestCase;

class TestHolidayParser extends TestCase {

    use HolidayParserTrait;

    private $year = 2021;

    public function testParser() {
        $content = json_decode(
            file_get_contents(__DIR__ . "/../Files/$this->year.json"), true
        )['content'];

        $content = $this->trimHtmlTags($content);

        try {
            foreach (FESTIVALS as $holiday) {
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
}
