<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/4/28
 * Time: 20:53
 */

namespace Holiday\Util;

use Exception;
use GuzzleHttp\Client;

class GetGovFile {

    private $httpClient;
    private $year;

    public function __construct() {
        $this->httpClient = new Client();
    }

    const QUERY_HOLIDAY_FILE = 'http://sousuo.gov.cn/data';

    /**
     * param id, file num
     *
     * @url https://xcx-static.www.gov.cn/static/gwymp/h5/index.html?id=5564127
     *
     * @var string
     */
    const GET_GOV_HOLIDAY_CONTENT = 'https://xcx-static.www.gov.cn/xhrb/json_file';

    /**
     * @return int|null
     */
    public function getYear(): ?int {
        return $this->year;
    }

    /**
     * @param int $year
     *
     * @return GetGovFile
     */
    public function setYear(int $year): GetGovFile {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public function getFileContent(): ?string {
        $fileNum = $this->getFileNum($this->year);

        $result = $this->httpClient->get(self::GET_GOV_HOLIDAY_CONTENT . "/content_{$fileNum}.json")
            ->getBody();

        $result = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result['content'] ?? null;
        }

        return null;
    }

    /**
     * @param int|null $year
     *
     * @return false|string
     */
    private function getFileNum(?int $year = null) {
        $content = $this->queryFile($year ?: '');

        $queryResult = $content['searchVO']['listVO'] ?? null;

        $latestFile = current($queryResult);

        if ($latestFile) {
            return $this->getUrlLastString($latestFile['url']);
        }

        return false;
    }

    /**
     * @param string $year
     *
     * @return array|null
     */
    private function queryFile(string $year = ''): ?array {
        $result = $this->httpClient->get(self::QUERY_HOLIDAY_FILE, [
            'query' => [
                't' => 'zhengcelibrary_gw',
                'q' => "{$year}节假日",
                'timetype' => 'timezd',
                'searchfield' => 'title',
                'pcodeJiguan' => '国办发明电',
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
     * @param string $url
     *
     * @return false|string
     */
    private function getUrlLastString(string $url) {
        $queryString = parse_url($url, PHP_URL_PATH);

        $strArray = explode('/', $queryString);

        preg_match('/[\d]+/', end($strArray), $fileNum);

        return $fileNum[0] ?? false;
    }
}
