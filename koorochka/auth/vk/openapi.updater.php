<?
use Bitrix\Main\Loader,
    Bitrix\Main\Web\HttpClient,
    Bitrix\Main\IO\File,
    Bitrix\Main\Application;
/**
 * @global CMain $APPLICATION
 */
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define('NO_AGENT_CHECK', true);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// get vk api lib
$url = "https://vk.com/js/api/openapi.js";
$http = new HttpClient();
$http->get($url);
$data = $http->getResult();

// put api lib on file
File::putFileContents(Application::getDocumentRoot() . "/export/js/openapi.js", $data, 0);