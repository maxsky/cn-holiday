<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/5/6
 * Time: 14:46
 */

namespace Holiday\Util;

use Carbon\Carbon;

trait HolidayParser {

    use DateUtil, RegexUtil;

    /**
     * @param string $keyword
     *
     * @return Carbon|false
     */
    public function parseHolidayBegin(string $keyword) {
        $lineStr = $this->getLineString($keyword);

        if (!$lineStr) {
            $lineStr = $this->getLineString("{$keyword}、");
        }

        $date = $this->getBeginDate($lineStr);

        return $this->createDateFormat("{$this->year}年{$date}");
    }

    /**
     * @param string $keyword
     *
     * @return int
     */
    public function parseHolidayLength(string $keyword): int {
        return $this->getHolidayLength($this->getLineString($keyword));
    }
}
