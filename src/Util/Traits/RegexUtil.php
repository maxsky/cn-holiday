<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/29
 * Time: 12:42
 */

namespace Holiday\Util\Traits;

trait RegexUtil {

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return string|null
     */
    private function getLineString(string $keyword, string $content): ?string {
        preg_match("/{$keyword}：.*?。/", $content, $lineString);

        $lineString = $lineString[0] ?? null;

        if (!$lineString) {
            preg_match("/{$keyword}、.*?。/", $content, $lineString);

            $lineString = $lineString[0] ?? null;
        }

        return $lineString;
    }

    /**
     * @param string $line_string
     *
     * @return string|null
     */
    private function getBeginDate(string $line_string): ?string {
        preg_match('/[\d]+月[\d]+日/', $line_string, $date);

        return $date[0] ?? null;
    }

    /**
     * @param string $line_string
     *
     * @return int
     */
    private function getHolidayLength(string $line_string): int {
        preg_match('/(?<=共)[\d]+(?=天)/', $line_string, $length);

        return $length[0] ?? 1;
    }

    /**
     * @param string $keyword
     * @param string $content
     *
     * @return string[]|null
     */
    private function getExtraWorkDays(string $keyword, string $content): ?array {
        $lineStr = $this->getLineString($keyword, $content);

        preg_match("/(?<=$lineStr).*(?=上班。)/", $content, $days);

        $days = $days[0] ?? null;

        if ($days) {
            $days = preg_replace('/（星期.*?）/', '', $days);

            $days = explode('、', $days);
        }

        return $days;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function trimHtmlTags(string $content): string {
        return preg_replace('/<[^>]+>/', '', $content);
    }
}
