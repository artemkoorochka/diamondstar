<?
use Bitrix\Main\Loader,
    Bitrix\Iblock\ElementTable;

$arParams = [
    "IBLOCK_ID" => 13,
    "!CODE" => false,
    "IBLOCK_SECTION_ID" => 189
];
$arResult = array();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// Load iblock module
Loader::includeModule("iblock");
Loader::includeModule("catalog");
Loader::includeModule("sale");

$elements = ElementTable::getList([
    "order" => [
        "ID" => "ASC"
    ],
    "filter" => $arParams,
    "select" => [
        "ID",
        "IBLOCK_ID",
        "NAME",
        "CODE",
        "SORT",
        "DETAIL_TEXT",
        "DETAIL_TEXT_TYPE",
        "PREVIEW_TEXT",
        "PREVIEW_TEXT_TYPE",
        "IBLOCK_SECTION_ID"
    ],
    "limit" => 18
]);
$neo = new CIBlockElement();
