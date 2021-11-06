<?php

/**
 * Created by IntelliJ IDEA.
 * User: Max Sky
 * Date: 11/7/2021
 * Time: 4:15 AM
 */

namespace Holiday\Struct;

class Date {

    private $year;
    private $month;
    private $day;

    /**
     * @return int
     */
    public function getYear(): int {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getMonth(): int {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth(int $month): void {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getDay(): int {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay(int $day): void {
        $this->day = $day;
    }
}
