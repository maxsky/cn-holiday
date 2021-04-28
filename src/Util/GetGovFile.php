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

    const QUERY_HOLIDAY_FILE = 'https://sousuo.gov.cn/data';

    /** @var string param id, file num */
    const GET_GOV_HOLIDAY_CONTENT = 'https://xcx-static.www.gov.cn/static/gwymp/h5/index.html';

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
     * @return false|string
     * @throws Exception
     */
    public function getFileContent() {
        if (!$this->year) {
            throw new Exception('');
        }

        $fileNum = $this->getFileNum($this->year);

        return file_get_contents(self::GET_GOV_HOLIDAY_CONTENT . "?id={$fileNum}");
    }

    /**
     * @param int $year
     *
     * @return false|string
     */
    private function getFileNum(int $year) {
        $content = $this->queryFile($year);

        $queryResult = $content['searchVO']['listVO'] ?? null;

        $latestFile = current($queryResult);

        if ($latestFile) {
            return $this->getUrlLastString($latestFile['url']);
        }

        return false;
    }

    /**
     * @param int $year
     *
     * @return array|null
     */
    private function queryFile(int $year): ?array {
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
