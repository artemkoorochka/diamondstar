<?
use Bitrix\Main\Loader;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Loader::includeModule("sale");
Loader::includeModule("catalog");
die;
$PRODUCT  = array(
    "PRODUCT_ID" => 20535,
    "PRODUCT_PRICE_ID" => 1,
    "PRICE" => 59,
    "CURRENCY" => "RUB",
    "QUANTITY" => 10,
    "LID" => SITE_ID,
    "NAME" => "Брилиант",
    "MODULE" => "sale",
    "DETAIL_PAGE_URL" => "",
    "FUSER_ID" => CSaleBasket::GetBasketUserID()
);

# удалить этот товар, если есть в корзине
$db_res = CSaleBasket::GetList(
    array("ID" => "ASC"),
    array(
        "PRODUCT_ID" => $PRODUCT["PRODUCT_ID"],
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    false,
    false
    //array("PRODUCT_ID", "PRICE", "BASE_PRICE")
);
while ($arBasketItem = $db_res->Fetch())
{
    d($arBasketItem);
    if (
    !( intval($arBasketItem["SET_PARENT_ID"]) > 0 && empty($arBasketItem["TYPE"] ) )
    )
    {
        CSaleBasket::Delete($arBasketItem["ID"]);
    }
}

$ID = CSaleBasket::Add(array(
    "PRODUCT_ID" => $PRODUCT["PRODUCT_ID"],
    "PRODUCT_PRICE_ID" => $PRODUCT["PRODUCT_PRICE_ID"],
    "PRICE" => 118,
    "BASE_PRICE" => 118,
    "CURRENCY" => "RUB",
    "QUANTITY" => 2,
    "WEIGHT" => 456,
    "LID" => SITE_ID,
    "NAME" => $PRODUCT["NAME"],
    "MODULE" => "catalog",
    "PRODUCT_PROVIDER_CLASS" => "",
    "CALLBACK_FUNC" => "",
    "ORDER_CALLBACK_FUNC" => "",
    "CANCEL_CALLBACK_FUNC" => "",
    "PAY_CALLBACK_FUNC" => "",
    "DETAIL_PAGE_URL" => "",
    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
    'IGNORE_CALLBACK_FUNC' => 'Y',
    'CUSTOM_PRICE' => 'Y'
));
d($ID);
?>