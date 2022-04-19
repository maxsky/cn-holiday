<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 20:53
 *
 * @noinspection HttpUrlsUsage
 */

namespace Holiday\Util;

use GuzzleHttp\Client;
use Holiday\Util\Traits\HttpHandleTrait;
use Holiday\Util\Traits\RegexUtil;

abstract class FileUtil {

    use HttpHandleTrait, RegexUtil;

    private $httpClient;

    public function __construct() {
        $this->httpClient = new Client(['verify' => false]);
    }

    /**
     * @param string $file_path
     *
     * @return string|null
     */
    protected function getFileContent(string $file_path): ?string {
        if (file_exists($file_path)) {
            $fileContent = file_get_contents($file_path);
            $fileSize = filesize($file_path);

            if ($fileContent && $fileSize && $fileSize / 1024 >= 5) {
                return $fileContent;
            }
        }

        $fileContent = $this->httpGetFileContent();

        $this->putFileContent($file_path, $fileContent);

        return $fileContent;
    }

    /**
     * @param string $file_path
     * @param string $content
     *
     * @return false|int
     */
    protected function putFileContent(string $file_path, string $content) {
        return file_put_contents($file_path, $content);
    }

    /**
     * @param int|null $year if null, default get latest year file content
     *
     * @return string|null
     */
    protected function httpGetFileContent(?int $year = null): ?string {
        $fileNum = $this->getFileNumber($year);

        if ($fileNum) {
            $content = $this->queryJsonFileContent($fileNum);

            if ($content) {
                return $this->trimHtmlTags($content);
            }
        }

        return null;
    }
}
