<?
use Bitrix\Main\Loader;

$arParams = array();
$arResult = array();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Load iblock module
Loader::includeModule("iblock");

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($_SERVER["DOCUMENT_ROOT"] . "/upload/excel/catalog/cappulo.xlsx");

# collect images
$images = [];
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

    foreach ($worksheet->getDrawingCollection() as $drawing) {
        if ($drawing instanceof PHPExcel_Worksheet_Drawing) {
            //copy image
            $images[$drawing->getImageIndex()] = $drawing->getPath();
        }
    }
}

# collect and save data
$ibSection = 0;
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

    foreach ($worksheet->getRowIterator() as $row) {

        if($row->getRowIndex() > 0){

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
            $arFields = [];
            foreach ($cellIterator as $cell) {

                # colect arFields for iblock-elemnt
                if($row->getRowIndex() > 1){

                    switch ($cell->getColumn()){
                        case "B":
                            $arFields["CODE"] = $cell->getValue();
                            break;
                        case "C":
                            $arFields["NAME"] = $cell->getValue();
                            break;
                    }

                    // serialize data
                    if ($cell->getValue()) {
                        $arFields["DETAIL_TEXT"][$cell->getColumn()][] = $cell->getValue();
                    }
                    // set image
                    $file = $images[$row->getRowIndex()];
                    $tmpDir = $_SERVER["DOCUMENT_ROOT"] . '/upload/tmp/diamondstar/catalog/';
                    mkdir($tmpDir, 0755);
                    $type = CFile::GetContentType($file);
                    $type = explode("/", $type);
                    $type = $type[1];
                    $file = copy($file,  $tmpDir . "/new." . $type);
                    if($file){
                        $file = $tmpDir . "/new." . $type;
                        $file = CFile::MakeFileArray($file);
                    }


                    $arFields["DETAIL_PICTURE"] = $file;
                    $arFields["PREVIEW_PICTURE"] = $file;
                    $arFields["SORT"] = $row->getRowIndex();

                }
                # collect arFields for iblock-section
                else{
                    switch ($cell->getColumn()){
                        case "A":
                            $arFields["NAME"] = $cell->getValue();
                            break;
                    }
                }

            }

            // save fields to infoblock
            /*
            if($row->getRowIndex() > 1){
                # save iblock new iblock element
                $arFields["IBLOCK_ID"] = 13;
                $arFields["DETAIL_TEXT"] = serialize($arFields["DETAIL_TEXT"]);
                $arFields["IBLOCK_SECTION_ID"] = $ibSection;

                $neo = new CIBlockElement();
                $neo->Add($arFields);
            }else{
                # save iblock section
                $arFields["FIELDS_TYPE"] = "section";
                $arFields["IBLOCK_ID"] = 13;

                $neo = new CIBlockSection();
                $ibSection = $neo->Add($arFields);
            }
            */


        }
    }
}

?>