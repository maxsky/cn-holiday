<?php

/**
 * Created by IntelliJ IDEA.
 * User: maxsky
 * Date: 2021/9/9
 * Time: 16:01
 *
 * @noinspection HttpUrlsUsage
 */

namespace Holiday\Util\Traits;

trait HttpHandleTrait {

    /**
     * @param int|null $year
     *
     * @return false|string
     */
    private function getFileNumber(?int $year = null) {
        $content = $this->queryFileList($year ?: '');

        if ($content) {
            $latestFile = current($content['searchVO']['listVO']);

            if ($latestFile) {
                $queryString = parse_url($latestFile['url'], PHP_URL_PATH);

                $strArray = explode('/', $queryString);

                preg_match('/[\d]+/', end($strArray), $fileNum);

                return $fileNum[0] ?? false;
            }
        }

        return false;
    }

    /**
     * @param string $year
     *
     * @return array|null
     */
    private function queryFileList(string $year = ''): ?array {
        $result = $this->httpClient->get(QUERY_HOLIDAY_FILE, [
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
    private function queryJsonFileContent(string $file_number): ?string {
        $result = $this->httpClient->get(GET_GOV_HOLIDAY_CONTENT . "/content_$file_number.json")->getBody();

        $result = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result['content'] ?? null;
        }

        return null;
    }
}
