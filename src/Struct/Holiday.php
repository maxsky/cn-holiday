<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/9/9
 * Time: 16:09
 */

namespace Holiday\Struct;

class Holiday {

    private $name;
    private $year;
    private $month;
    private $day;
    private $length;

    private $extraWork;
    private $extraWorkDays;

    public function __construct() {

    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getYear(): int {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void {
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

    /**
     * @return  int
     */
    public function getLength(): int {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length) {
        $this->length = $length;
    }

    /**
     * @return bool
     */
    public function getExtraWork(): bool {
        return $this->extraWork;
    }

    /**
     * @param bool $need
     */
    public function setExtraWork(bool $need): void {
        $this->extraWork = $need;
    }

    /**
     * @return array
     */
    public function getExtraWorkDays(): array {
        return $this->extraWorkDays;
    }

    /**
     * @param array $days
     */
    public function setExtraWorkDays(array $days): void {
        $this->extraWorkDays = $days;
    }
}
