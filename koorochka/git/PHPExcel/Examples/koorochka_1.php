<?
$arParams = array();
$arResult = array();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$arResult[] = date('H:i:s') . " Load from Excel2007 file";
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($_SERVER["DOCUMENT_ROOT"] . "/upload/excel/catalog/cappulo.xlsx");

$arResult[] = date('H:i:s') . " Iterate worksheets by Row";

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $arResult[] = 'Лист - ' . $worksheet->getTitle();

    foreach ($worksheet->getRowIterator() as $row) {

        if($row->getRowIndex() < 2){
            $arResult[] = '    Строка - ' . $row->getRowIndex() . " Не разбираем";
        }
        else{
            $arResult[] = '    Строка - ' . $row->getRowIndex() . " разбираем";

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
            $i = 0;
            foreach ($cellIterator as $cell) {
                $i++;
                if (!is_null($cell) && $i < 31) {
                    $arResult[] =  'Координата ячейки - ' . $cell->getColumn() . ' - ' . $cell->getValue();
                }
            }
        }
    }
}

d($arParams);
d($arResult);
?>