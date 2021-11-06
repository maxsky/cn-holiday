# CN-Holiday

[![996.icu](https://img.shields.io/badge/link-996.icu-red.svg)](https://996.icu)

获取中国法定假日



## 要求

PHP >= 7.1



## 安装

```shell
composer required maxsky/cn-holiday
```



## 使用

```php
<?php

use Holiday\CNHoliday;

// 第一个参数为需要获取的年份，如果忽略默认取当前年份
// 第二个参数存储路径以文件名结尾，如果忽略则每次从政府信息公开平台获取（建议设置）
$holiday = new CNHoliday(2021, '/tmp/cn-holiday/2021.json');

$holiday->isTodayHoliday();             // 当天是否为假期
$holiday->isHoliday(2021, 10, 1);       // 某天是否为假期
$holiday->isTodayOffDay();              // 当天是否为休息日（假期/周末）
$holiday->isOffDay(2021, 10, 7);        // 某天是否为休息日（假期/周末）
$holiday->isTodayExtraWorkDay();        // 当天是否为调休日（假期补班）
$holiday->isExtraWorkDay(2021, 10, 10); // 某天是否为调休日（假期补班）

$holiday->setParams(2022, '/tmp/cn-holiday/2022.json'); // 重设年份及存储路径
$holiday->getHolidays();          // 获取当年所有节假日（完整结构）
$holiday->getHolidayDates();      // 获取当年所有节假日日期
$holiday->getExtraWorkDayDates(); // 获取当年所有调休日日期
```



## 说明

`tests/Files` 中存储的 `json` 文件为 2017 年至 2022 年国务院办公厅发布的节假日安排通知原始文件，本库通过正则解析该 `json` 文件组装而实现，仅供学习参考。如遇政府信息公开平台接口变更导致无法正常请求到相应内容而影响到项目，请自行处理。

