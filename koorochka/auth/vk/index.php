<?
use Bitrix\Main\Loader,
    Bitrix\Main\Web\HttpClient;
/**
 * @global CMain $APPLICATION
 */
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define('NO_AGENT_CHECK', true);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



$url = "https://vk.com/js/api/openapi.js";


$sHost = COption::GetOptionString("main", "update_site", "www.bitrixsoft.com");
$proxyAddr = COption::GetOptionString("main", "update_site_proxy_addr", "");
$proxyPort = COption::GetOptionString("main", "update_site_proxy_port", "");
$proxyUserName = COption::GetOptionString("main", "update_site_proxy_user", "");
$proxyPassword = COption::GetOptionString("main", "update_site_proxy_pass", "");

/*
d($sHost);
d($proxyAddr);
d($proxyPort);
d($proxyUserName);
d($proxyPassword);
*/

$http = new HttpClient();
$http->setProxy($proxyAddr, $proxyPort, $proxyUserName, $proxyPassword);
$http->get($url);

$data = $http->getResult();
echo $data;