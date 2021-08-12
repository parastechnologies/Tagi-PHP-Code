<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

/*require_once('../connection.php');
if($_FILES['sheet']['name'] != ""){
$sheetfile=$_FILES['sheet']['name'];
$uploads_dir = 'uploads';
$sheetname = basename($_FILES["sheet"]["name"]);
move_uploaded_file($_FILES['sheet']['tmp_name'], "$uploads_dir/$sheetname");*/

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("RetailerAddProductExcel.xls");
$sheet = $spreadsheet->getActiveSheet();
$data = array(1,$sheet->toArray(null,true,true,true)); 
print_r($data);
die;
/*$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("$uploads_dir/$sheetname");
$sheet  =  $spreadsheet->getActiveSheet()->removeColumn('P');
$data = array(1,$sheet->toArray(null,true,true,true));
$params = "(product_code,product_name,product_brand,description,category,is_fragile,retailer_id,status,productUniqueID,color)"; 
$params2="(product_id, productUniqueID, size, weight, length, height, width, quantity, price, is_dimension)";
$retailer_id = mysqli_real_escape_string($con,$_POST['retailer_id']);
 
$Sql ="insert into productExcel (sheetname,retailer_id) values ('$sheetfile','$retailer_id')";
$sqlresult=mysqli_query($con,$Sql);*/
             
             
for ($i = 0; $i <= count($data[1]); $i ++) {
    foreach($data[$i] as $dd){
        if($dd['B'] != 'No.' && $dd['B'] != ''){
            $product_code = "PRODUCTEX".rand(0,100);
             $product_name = mysqli_real_escape_string($con,$dd['C']);
             $product_brand = mysqli_real_escape_string($con,$dd['D']);
             $description = mysqli_real_escape_string($con,$dd['E']);
             $category = mysqli_real_escape_string($con,$dd['F']);
             $weight = mysqli_real_escape_string($con,$dd['G']);
             $size = mysqli_real_escape_string($con,$dd['H']);
             $length = $dd['I'] ? mysqli_real_escape_string($con,$dd['I']) : 0;
             $width = $dd['J'] ? mysqli_real_escape_string($con,$dd['J']) : 0;
             $height = $dd['K'] ? mysqli_real_escape_string($con,$dd['K']) : 0;
             $product_price = mysqli_real_escape_string($con,$dd['L']);
             $fragile = mysqli_real_escape_string($con,$dd['M']);
             $quantity = mysqli_real_escape_string($con,$dd['N']);
             $productUniqueID = mysqli_real_escape_string($con,$dd['O']);
             $color = mysqli_real_escape_string($con,$dd['p']);
             $retailer_id = mysqli_real_escape_string($con,$_POST['retailer_id']);
             
             
             $category_description = mysqli_real_escape_string($con,' ');
             if($width || $height || $length){
                $is_dimension = 1;
             }
             else {
                 $is_dimension = 0;
             }
             $fragile1 = $fragile == 'Yes' ? 1 : 0;
            // $sql = mysqli_query($con,"select id,name from product_categories where name = '$category'");
             
             /*if(mysqli_num_rows($sql) == 0){
                 mysqli_query($con,"insert  into product_categories (name,description,status) values('$category','$category_description',1)");
                 $catid=mysqli_insert_id($con);
             }
             else {*/
                 // $categoryData = mysqli_fetch_assoc($sql);
                  $catid = $catid=$categoryData['id'];
             /*}*/
           /* $newProductUniqueID = $productUniqueID.'_'.$retailer_id.'_1';
            $sqlCheck="Select product_id from products where productUniqueID='$newProductUniqueID'";
            $sqlResult=mysqli_query($con,$sqlCheck);
            $sqlproduct=mysqli_fetch_array($sqlResult);
            $product_id=$sqlproduct['product_id'];
            $sqlNum=mysqli_num_rows($sqlResult);
            if(empty($product_id))
            {*/
               echo $QUERY = "insert into products $params 
                values ('$product_code','$product_name','$product_brand','$description','$catid','$fragile1','$retailer_id',1,'$newProductUniqueID','$color')";
                echo "<br>";
                //$result=mysqli_query($con,$QUERY);
                //$product_id=mysqli_insert_id($con);
            //}
            
           // $Sqlquery="insert into product_details $params2 values ('$product_id','$newProductUniqueID','$size','$weight','$length','$height','$width','$quantity','$product_price','$is_dimension') ";
            //$sqlres=mysqli_query($con,$Sqlquery);
            
           /*if($sqlres)
            {
                
                $PRODUCTS_QUERY=mysqli_query($con,"select * from products where product_id='".$product_id."'");
                
                while( $PRODUCT_DATA=mysqli_fetch_assoc($PRODUCTS_QUERY))
               {
                   $results[] = $PRODUCT_DATA;
                   
               }
            }*/
        }
    }
}

?>