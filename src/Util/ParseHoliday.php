<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 21:44
 */

namespace Holiday\Util;

use Carbon\Carbon;
use Exception;

class ParseHoliday {

    use RegexUtil;

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

    private $beginDate;
    private $endDate;

    /**
     * ParseHoliday constructor.
     *
     * @throws Exception
     */
    public function __construct(?int $year = null) {
        $getGovFile = new GetGovFile();

        if ($year) {
            $getGovFile->setYear($year);
        }

        $this->fileContent = $getGovFile->getFileContent();
    }

    public function parseNewYear() {
        $keyword = self::FESTIVAL['new'];

        $lineStr = $this->getLineString($keyword);
        var_dump($lineStr);

        $date = $this->getBeginDate($lineStr);

        var_dump(Carbon::rawCreateFromFormat('Y年m月d日', "2021年{$date}"));

        var_dump($this->getDateLength($lineStr));

        preg_match("/(?<={$keyword}：).*?(?=放假)/", $this->fileContent, $holiday);
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
