<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/5/6
 * Time: 14:46
 */

namespace Holiday\Util\Traits;

use Carbon\Carbon;

trait HolidayParserTrait {

    use RegexUtil;

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return Carbon|false
     */
    private function parseHolidayBegin(string $keyword, string $content) {
        $lineStr = $this->getLineString($keyword, $content);

        return $this->createDate($keyword, $this->getBeginDate($lineStr));
    }

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return int
     */
    private function parseHolidayLength(string $keyword, string $content): int {
        $lineStr = $this->getLineString($keyword, $content);

        $length = $this->getHolidayLength($lineStr) + substr_count($lineStr, '补休');

        if (strpos($lineStr, JOIN_WEEKEND)) {
            $date = $this->createDate($keyword, $this->getBeginDate($lineStr));

            $dateCopy = $date->copy();

            // sunday
            if ($date->subDay()->isWeekend()) {
                $length++;
            }

            // saturday
            if ($date->subDay()->isWeekend()) {
                $length++;
            }

            // sunday
            if ($dateCopy->addDay()->isWeekend()) {
                $length++;
            }

            // saturday
            if ($dateCopy->addDay()->isWeekend()) {
                $length++;
            }
        }

        return $length;
    }

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return bool
     */
    private function parseHasExtraWork(string $keyword, string $content): bool {
        return strpos($this->getLineString($keyword, $content), '调休') !== false
            && $this->getExtraWorkDays($keyword, $content);
    }

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return array
     */
    private function parseExtraWorkDays(string $keyword, string $content): array {
        $extraWorkDays = $this->getExtraWorkDays($keyword, $content);

        $days = [];

        foreach ($extraWorkDays as $extraWorkDay) {
            $days[] = $this->createDate($keyword, $extraWorkDay);
        }

        return $days;
    }

    /**
     * @param string $keyword
     * @param string $date
     *
     * @return Carbon|false
     */
    private function createDate(string $keyword, string $date) {
        if ($keyword === '元旦' && substr($date, 0, 2) == 12) {
            $dateStr = ($this->year - 1) . "年$date";
        }

        return Carbon::rawCreateFromFormat('Y年m月d日', $dateStr ?? "{$this->year}年$date")
            ->setTime(0, 0);
    }
}
