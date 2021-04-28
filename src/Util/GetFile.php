<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/27
 * Time: 22:03
 */

namespace Holiday\Util;

trait GetFile {

    /**
     * @param string $url
     * @param string $storage_path
     *
     * @return bool
     */
    public function downloadFile($url, $storage_path) {
        return (bool)file_put_contents($storage_path, file_get_contents($url));
    }
}
