<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/29
 * Time: 12:24
 */

use Holiday\Util\ParseHoliday;
use PHPUnit\Framework\TestCase;

class TestParseHoliday extends TestCase {

    private $parser;

    protected function setUp() {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->parser = new ParseHoliday();
    }

    public function testParse() {
        $this->parser->parseNewYear();
    }
}