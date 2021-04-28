<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 21:44
 */

namespace Holiday\Util;

class ParseHoliday {

    const FESTIVAL = [
        'new' => '元旦',
        'spring' => '春节',
        'tomb' => '清明节',
        'worker' => '劳动节',
        'dragon' => '端午节',
        'autumn' => '中秋节',
        'national' => '国庆节'
    ];

    const RECESS = '放假';

    private $fileContent;

    public function parse() {
        $this->fileContent = (new GetGovFile())->setYear(2021)->getFileContent();
    }

    private function parseNewYear() {
        $kw = self::FESTIVAL['new'];

        $this->getFestivalLine($kw);


        preg_match("/(?<={$kw}：).*?(?=放假)/", $this->fileContent, $holiday);
    }

    /**
     * @param string $keyword
     *
     * @return string|null
     */
    private function getFestivalLine(string $keyword): ?string {
        preg_match("/^{$keyword}：.*?。/", $this->fileContent, $festival);

        return $festival[0] ?? null;
    }

    private function parseSpringFestival() {
        preg_match('/(?<=春节：).*?(?=放假)/', $this->fileContent, $holiday);
        preg_match('/(?<=春节：).*?(?=放假)/', $this->fileContent, $holiday);

    }

    private function parseTombSweepingDay() {

    }

    private function parseWorkerDay() {

    }

    private function parseDragonBoatFestival() {

    }

    // maybe merge to national day
    private function parseMidAutumnFestival() {

    }

    // maybe merge to mid-autumn festival
    private function parseNationalDay() {

    }
}
