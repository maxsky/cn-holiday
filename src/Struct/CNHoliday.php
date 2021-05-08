<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/5/6
 * Time: 16:43
 */

namespace Holiday\Struct;

use Holiday\Util\{FileUtil, HolidayParser};

class CNHoliday {

    use HolidayParser;

    const HOLIDAYS = ['元旦', '春节', '清明节', '劳动节', '端午节', '中秋节', '国庆节'];

    const RECESS = '放假';

    private $fileContent;

    /**
     * CNHoliday constructor.
     *
     * @param int|null $year
     */
    public function __construct(?int $year = null) {
        $fileUtil = new FileUtil();

        $this->fileContent = $fileUtil->getFileContent($year);
    }

}
