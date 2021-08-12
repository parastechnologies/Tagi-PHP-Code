<?php
require_once('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


require_once('../connection.php');




   /* $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];*/

  
     //  $targetPath = "my_excel_file.xlsx";
       // $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

      // $spreadSheet = $Reader->load($targetPath);
       
      /*$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      $spreadsheet = $reader->load("test.xlsx");
       $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry); */

    /*    for ($i = 0; $i <= $sheetCount; $i ++) {
            $name = "";
            if (isset($spreadSheetAry[$i][0])) {
                $name = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
            }
            $description = "";
            if (isset($spreadSheetAry[$i][1])) {
                $description = mysqli_real_escape_string($conn, $spreadSheetAry[$i][1]);
            }


        }  */


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('my_excel_file.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$data = array(1,$sheet->toArray(null,true,true,true)); 
print_r($data);

/*$params = "(product_code,product_name,product_brand,description,product_price,product_image,category,size,weight,quantity,retailer_id,status)"; 
$sheetCount = count($data[1]);
 for ($i = 0; $i <= $sheetCount; $i++) {
     foreach($data[$i] as $dd){
         if($dd['A'] != 'name'){
         $product_code = "PRODUCT".rand(0,100);
         $product_name = mysqli_real_escape_string($con,$dd['A']);
         $product_brand = mysqli_real_escape_string($con,$dd['B']);
         $description = mysqli_real_escape_string($con,$dd['C']);
         $product_price = mysqli_real_escape_string($con,$dd['D']);
         $category = mysqli_real_escape_string($con,'test1');
         $size = mysqli_real_escape_string($con,$dd['E']);
         $weight = mysqli_real_escape_string($con,$dd['F']);
         $quantity = mysqli_real_escape_string($con,$dd['G']);
         $retailer_id = '12';
         $sql = mysqli_query($con,"select id,name from product_categories where name = '$category'");
         if(mysqli_num_rows($sql) == 0){
             mysqli_query($con,"insert  into product_categories (name,status) values('$category',1)");
             $catid=mysqli_insert_id($con);
         }
         else {
              $categoryData = mysqli_fetch_assoc($sql);
              $catid = $catid=$categoryData['id'];
         }
        $QUERY = "insert into products $params 
        values ('$product_code','$product_name','$product_brand','$description','$product_price','','$catid','$size','$weight','$quantity','$retailer_id',1)";
       if(mysqli_query($con,$QUERY))
        {
            $lastInsertId=mysqli_insert_id($con);
            $PRODUCTS_QUERY=mysqli_query($con,"select * from products where product_id='".$lastInsertId."'");
            while( $PRODUCT_DATA=mysqli_fetch_assoc($PRODUCTS_QUERY))
           {
               $results[] = $PRODUCT_DATA;
           }
        }
     }
     }
    

} 
if($results){
    $response=array('success' => 1,'msg' => 'Product Created','data' => $results);
}
else 
{
    $response=array('success' => 0,'msg' => 'Product Not Created','data' => NULL);  
}
	echo json_encode($response);
*/
//$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
//$spreadsheet111 = $reader->load("test.xlsx");

//$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
//$writer->save("05featuredemo.xlsx");

//$reader = IOFactory::createReader("Xlsx");
//$spreadsheet = $reader->load("https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/templates/27template.xls?raw=true");
//$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/templates/27template.xls?raw=true');
/*
$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
    ->setTitle('PHP Download Example')
    ->setSubject('A PHPExcel example')
    ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
    ->setCreator('php-download.com')
    ->setLastModifiedBy('php-download.com');

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'This')
    ->setCellValue('A2', 'is')
    ->setCellValue('A3', 'only')
    ->setCellValue('A4', 'an')
    ->setCellValue('A5', 'example');

$spreadsheet->getActiveSheet()
    ->setCellValue('B1', "You")
    ->setCellValue('B2', "can")
    ->setCellValue('B3', "download")
    ->setCellValue('B4', "this")
    ->setCellValue('B5', "library")
    ->setCellValue('B6', "on")
    ->setCellValue('B7', "https://php-download.com/package/phpoffice/phpspreadsheet");


$spreadsheet->getActiveSheet()
    ->setCellValue('C1', 1)
    ->setCellValue('C2', 0.5)
    ->setCellValue('C3', 0.25)
    ->setCellValue('C4', 0.125)
    ->setCellValue('C5', 0.0625);

$spreadsheet->getActiveSheet()
    ->setCellValue('C6', '=SUM(C1:C5)');
$spreadsheet->getActiveSheet()
    ->getStyle("C6")->getFont()
    ->setBold(true);


$writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
$writer->save("test.xlsx");  */

?>