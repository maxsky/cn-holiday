<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/29
 * Time: 12:42
 */

namespace Holiday\Util;

trait RegexUtil {

    /**
     * @param string $keyword
     *
     * @return string|null
     */
    public function getLineString(string $keyword): ?string {
        preg_match("/{$keyword}：.*?。/", $this->fileContent, $lineString);

        $lineString = $lineString[0] ?? null;

        if ($lineString) {
            // trim html tag
            return preg_replace('/<[^>]+>/', '', $lineString);
        }

        return null;
    }

    /**
     * @param string $line_string
     *
     * @return string|null
     */
    public function getBeginDate(string $line_string): ?string {
        preg_match('/[\d]+月[\d]+日/', $line_string, $date);

        return $date[0] ?? null;
    }

    /**
     * @param string $line_string
     *
     * @return int
     */
    public function getHolidayLength(string $line_string): int {
        preg_match('/(?<=共)[\d]+(?=天)/', $line_string, $length);

        return ($length[0] ?? 0);
    }

    /**
     * @param string $line_string
     *
     * @return bool
     */
    public function isWorkdayNeedChange(string $line_string): bool {
        return strpos($line_string, '调休') !== false;
    }
}
