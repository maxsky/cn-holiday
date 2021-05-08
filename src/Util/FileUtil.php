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

class FileUtil {

    private $httpClient;

    public function __construct() {
        $this->httpClient = new Client();
    }

    const QUERY_HOLIDAY_FILE = 'http://sousuo.gov.cn/data';

    /**
     * param id, file number
     *
     * @url https://xcx-static.www.gov.cn/static/gwymp/h5/index.html?id=5564127
     */
    const GET_GOV_HOLIDAY_CONTENT = 'https://xcx-static.www.gov.cn/xhrb/json_file';

    /**
     * @param int|null $year if null, default get latest year file content
     *
     * @return string|null
     */
    public function getFileContent(?int $year = null): ?string {
        $fileNum = $this->getFileNumber($year);

        if ($fileNum) {
            return $this->queryFileContent($fileNum);
        }

        return null;
    }

    /**
     * @param string $url
     * @param string $storage_path
     *
     * @return bool
     */
    public function downloadFile(string $url, string $storage_path): bool {
        return (bool)file_put_contents($storage_path, file_get_contents($url));
    }

    /**
     * @param int|null $year
     *
     * @return false|string
     */
    private function getFileNumber(?int $year = null) {
        $content = $this->queryFileList($year ?: '');

        $queryResult = $content['searchVO']['listVO'] ?? null;

        $latestFile = current($queryResult);

        if ($latestFile) {
            return $this->getUrlLastNumber($latestFile['url']);
        }

        return false;
    }

    /**
     * @param string $url
     *
     * @return false|string
     */
    private function getUrlLastNumber(string $url) {
        $queryString = parse_url($url, PHP_URL_PATH);

        $strArray = explode('/', $queryString);

        preg_match('/[\d]+/', end($strArray), $fileNum);

        return $fileNum[0] ?? false;
    }

    /**
     * @param string $year
     *
     * @return array|null
     */
    private function queryFileList(string $year = ''): ?array {
        $result = $this->httpClient->get(self::QUERY_HOLIDAY_FILE, [
            'headers' => [
                'Referer' => 'http://sousuo.gov.cn/a.htm?t=zhengcelibrary'
            ],
            'query' => [
                't' => 'zhengcelibrary_gw',
                'q' => "{$year}节假日",
                'timetype' => 'timezd',
                'searchfield' => 'title',
                'pcodeJiguan' => '国办发:国办函:国办发明电', // 国办发明电
                'puborg' => '国务院办公厅',
                'n' => 1,
                'sort' => 'pubtime'
            ]
        ])->getBody();

        $result = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        return null;
    }

    /**
     * @param string $file_number
     *
     * @return string|null
     */
    private function queryFileContent(string $file_number): ?string {
        $result = $this->httpClient->get(self::GET_GOV_HOLIDAY_CONTENT . "/content_{$file_number}.json")
            ->getBody();

        $result = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result['content'] ?? null;
        }

        return null;
    }
}
