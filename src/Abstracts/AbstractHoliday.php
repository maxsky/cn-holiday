<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 14:05
 */

namespace Holiday\Abstracts;

use Exception;
use ICal\ICal;

abstract class AbstractHoliday {

    const OPTIONS = [
        'defaultSpan' => 2,
        'defaultTimeZone' => 'Asia/Shanghai',
        'defaultWeekStart' => 'MO',
        'disableCharacterReplacement' => false,
        'filterDaysAfter' => null,
        'filterDaysBefore' => null,
        'skipRecurrence' => false,
    ];

    /** @var ICal */
    protected $iCal;

    /**
     * @param string     $file_path
     * @param array|null $options
     *
     * @return $this
     * @throws Exception
     */
    public function setFile(string $file_path, ?array $options = null): AbstractHoliday {
        if (!$options) {
            $options = self::OPTIONS;
        }

        $this->iCal = new ICal($this->readFile($file_path), $options);

        return $this;
    }

    /**
     * @return ICal
     */
    public function getICal(): ICal {
        return $this->iCal;
    }

    /**
     * @param string $file_path An absolute path or URL
     *
     * @return string
     * @throws Exception
     */
    private function readFile(string $file_path): string {
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'cn-holiday-');

        if ($this->downloadFile($file_path, $tmpFilePath)) {
            return $tmpFilePath;
        }

        throw new Exception('Write `ics` file to temp directory failed.');
    }
}
