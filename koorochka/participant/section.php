<?

use Bitrix\Main\Loader;

$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define('NO_AGENT_CHECK', true);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule("iblock");
$concourse = 38194;
$concourse = 37847;
$section = CIBlockSection::GetList(
    array(),
    array(
        "UF_CONCURSE" => $concourse,
        "IBLOCK_ID" => "7",
        "IBLOCK_TYPE" => "Diamond"
    ),
    false,
    array("ID", "ID", "NAME",  "IBLOCK_ID", "UF_ACTIVATE"));
d($section->SelectedRowsCount());
if($section = $section->Fetch())
{
    d($section);
}
