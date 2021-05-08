<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/5/6
 * Time: 16:39
 */

namespace Holiday\Util;

use Carbon\Carbon;

trait DateUtil {

    /**
     * @param string $date_string
     *
     * @return Carbon|false
     */
    public function createDateFormat(string $date_string) {
        return Carbon::rawCreateFromFormat('Y年m月d日', $date_string)->setTime(0, 0);
    }
}
