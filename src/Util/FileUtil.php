<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/27
 * Time: 22:03
 */

namespace Holiday\Util;

trait FileUtil {

    /**
     * @param string $url
     * @param string $storage_path
     *
     * @return bool
     */
    public function downloadFile($url, $storage_path): bool {
        return (bool)file_put_contents($storage_path, file_get_contents($url));
    }

    /**
     * @param string $content
     *
     * @return string|null
     */
    public function trimHtml(string $content): ?string {
        return preg_replace('/<[^>]+>/', '', $content);
    }
}
