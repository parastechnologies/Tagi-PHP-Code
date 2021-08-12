<?php 
use PhpSpreadsheet\Reader\Xlsx;

use PhpSpreadsheet\Reader\Exception;
use PhpSpreadsheet\IOFactory;
use PhpSpreadsheet\Helper\Sample;

require_once ('vendor/autoload.php');
//use PhpSpreadsheet\Spreadsheet;
//use PhpSpreadsheet\Writer\Xlsx;



/*$inputFileName = '../productsExcel/addProduct.xls';

try {
   $spreadsheet = \PhpSpreadsheet\IOFactory::load($inputFileName);
} catch(\PhpSpreadsheet\Reader\Exception $e) {
    echo 'Error loading file: '.$e->getMessage();
} */

/*$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');*/



$inputFileName = 'https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/sampleData/example1.xls';

/*$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
$spreadsheet = IOFactory::load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
var_dump($sheetData); */

$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');

try {
    $spreadsheet = IOFactory::load($inputFileName);
} catch (InvalidArgumentException $e) {
    $helper->log('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
}
?>