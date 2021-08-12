<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
include "phpqrcode/qrlib.php";

require_once('excelVendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        define('HTTP_OK', '200');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Mod_dashboard');
        $this->isLoggedIn();
        $this->load->library("pagination");
    }
    public function index()
	{
	    $data["totalRegisteredUsers"]=$this->Mod_dashboard->totalRegisteredUsers();
	    $data["purchasedTagUsers"]=$this->Mod_dashboard->purchasedTagUsers();
	    $data["notPurchasedTag"]=$this->Mod_dashboard->notPurchasedTag();
	    $data["totalRegisteredTags"]=$this->Mod_dashboard->totalRegisteredTags();
	    $data["TagsAddedByAdmin"]=$this->Mod_dashboard->TagsAddedByAdmin();
	    $data["NotRegisterTags"]=$this->Mod_dashboard->NotRegisterTags();
	    $data["DisableTags"]=$this->Mod_dashboard->DisableTags();
		$this->loadViews('dashboard',$data);
	}
	public function registeredUsers()
	{
	    $search=$_POST['search'];
	    $config = array();
        $config["base_url"] = base_url() . "registeredUsers";
        if(!empty($search))
        {
            $config["total_rows"] = $this->Mod_dashboard->registeredUsersSearchCount($search);
        }
        else
        {
            $config["total_rows"] = $this->Mod_dashboard->registeredUsersCount();
        }
        $config["per_page"] = 100;
        $config["uri_segment"] = 2;
        
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $data["links"] = $this->pagination->create_links();
        if(!empty($search))
        {
            $data['users'] = $this->Mod_dashboard->searchRegisteredUsers($config["per_page"], $page,$search);
        }
        else
        {
            $data['users'] = $this->Mod_dashboard->allRegisteredUsers($config["per_page"], $page);
        }
        
        /*print_r($data);
        die;*/
	    /*$data["numberOfTagi"]=$this->Mod_dashboard->numberOfTagi($user_id);
	       $usertagi=$this->Mod_dashboard->user_tagi($user_id);
            
            $tagi_point=$this->Mod_dashboard->userTagiPoints($user_id);
            //$tagsPoints= array_sum($points);
	        
	       $data["tags_points"]=$tagi_point['points'];
	       $data["peopleLogs"]=$this->Mod_dashboard->peopleLogs($user_id);*/
	  /* $registeredUsers=$this->Mod_dashboard->registeredUsers();
	 
	   foreach($registeredUsers as $dt)
	   {
	       $user_id=$dt["id"];
	       $data["id"]=$dt["id"];
	       $data["first_name"]=$dt["first_name"];
	       $data["last_name"]=$dt["last_name"];
	       $data["user_name"]=$dt["user_name"];
	       $data["email"]=$dt["email"];
	       $data["profile_image"]=$dt["profile_image"];
	       $data["create_date"]=$dt["create_date"];
	       $data["profile_status"]=$dt["profile_status"];
	       $data["country"]=$dt["country"];
	       $data["profile_url"]=$dt["profile_url"];
	       $data["numberOfTagi"]=$this->Mod_dashboard->numberOfTagi($user_id);
	       $usertagi=$this->Mod_dashboard->user_tagi($user_id);
            
            $tagi_point=$this->Mod_dashboard->userTagiPoints($user_id);
            //$tagsPoints= array_sum($points);
	        
	       $data["tags_points"]=$tagi_point['points'];
	       $data["peopleLogs"]=$this->Mod_dashboard->peopleLogs($user_id);
	       $users[]=$data;
	       unset($points);
	   }
	   $data["users"]=$users;*/
	   $this->loadViews("registeredUsers",$data);
	}
	public function registeredWithDevice()
	{
	    $this->loadViews("registeredWithDevice");
	}
	public function productsMngmnt()
	{
	    $data["products"]=$this->Mod_dashboard->productsMngmnt();
	    $this->loadViews("productsMngmnt",$data);
	}
	public function allnfcTagsApi()
	{
	    $start=$_GET['iDisplayStart'];
	    $length=$_GET['iDisplayLength'];
	    $uidData=$this->Mod_dashboard->nfcTags($start,$length);
	    
	    $count=count($uidData);
	    echo json_encode(array("sEcho"=>1,"iTotalRecords"=>$count,"iTotalDisplayRecords"=>$count,"aaData"=>$uidData));
	}
	
	public function nfcTags()
	{
	    $search=$_POST["search"];
	    if(!empty($search))
	    {
	        $data["nfcTags"]=$this->Mod_dashboard->searchnfcTags($search);
	    }
	    //$data["nfcTags"]=$this->Mod_dashboard->nfcTags();
	    $data["nfcFolders"]=$this->Mod_dashboard->nfcFolders();
	    $this->loadViews("nfcTags",$data);
	}
	public function purchasedTags()
	{
	    $this->loadViews("purchasedTags");
	}
	public function updateAccountStatus()
	{
	    $profile_status=$_POST["status"];
	    $user_id=$_POST["user_id"];
	    $result=$this->Mod_dashboard->updtaeAccountStatus($profile_status,$user_id);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function addProducts()
	{
	    $uid=$_POST["uid"];
	    $name=$_POST["name"];
	    $price=$_POST["price"];
	    $product_link=$_POST["product_link"];
	    $product_image=$_FILES["product_img"]['name'];
	    $uidCheck=$this->Mod_dashboard->uidCheck($uid);
        if($uidCheck)
        {
            echo "2";
            die;
        }
	    
	    $sourcePath = $_FILES['product_img']['tmp_name'];
	    $targetPath = "productsImages/".$product_image;
        if(move_uploaded_file($sourcePath, $targetPath))
        {
           /* $code=rand("999","10000");*/
            $fileName = 'qr'.$uid.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$fileName;
            $urlRelativeFilePath = "qrcode/".$fileName;
            $userQr=$uid;
            QRcode::png($userQr,$urlRelativeFilePath);
            $data=array(
	            "uid"=>$uid,
	            "product_image"=>$product_image,
	            "name"=>$name,
	            "price"=>$price,  
	            "link"=>$product_link,
	            "qrimage"=>$fileName
	        );
            $result=$this->Mod_dashboard->addProducts($data);
            if($result)
            {
                echo "1";
            }
            else
            {
                echo "0";
            }
        }
        else
        {
            echo "0";
        }
	    
	}
	public function deleteProduct()
	{
	    $id=$_POST["id"];
	    $result=$this->Mod_dashboard->deleteProduct($id);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function editProduct()
	{
	    $id=$_POST["id"];
	    $uid=$_POST["uid"];
	    $name=$_POST["name"];
	    $price=$_POST["price"];
	    $product_link=$_POST["product_link"];
	    $product_image=$_FILES["product_img"]['name'];
	   
        $qrcheck=$this->Mod_dashboard->oldQRCheck($id);
        $oldqr=$qrcheck["uid"];
        if($uid != $oldqr)
        {
            $uidCheck=$this->Mod_dashboard->uidCheck($uid);
            if($uidCheck)
            {
                echo "2";
                die;
            }
            else
            {
                $fileName = 'qr'.$uid.'.png';
                $tempDir = "qrcode/";
                $pngAbsoluteFilePath = $tempDir.$fileName;
                $urlRelativeFilePath = "qrcode/".$fileName;
                $userQr=$uid;
                QRcode::png($userQr,$urlRelativeFilePath);
                $qrres=$this->Mod_dashboard->updateqrcode($id,$uid,$fileName);
            }
            
        }
        
	    if(!empty($product_image))
	    {
	        $data=array(
	            "product_image"=>$product_image,
	            "name"=>$name,
	            "price"=>$price,
	            "link"=>$product_link
	        );
	        $sourcePath = $_FILES['product_img']['tmp_name'];
	        $targetPath = "productsImages/".$product_image;
            move_uploaded_file($sourcePath, $targetPath);
	    }
	    else
	    {
	        $product_image=$_POST["old_product_img"];
	        $data=array(
	            "product_image"=>$product_image,
	            "name"=>$name,
	            "price"=>$price,
	            "link"=>$product_link
	        );
	    }
	    $result=$this->Mod_dashboard->editProduct($id,$data);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function logout()
    {
        $this->session->sess_destroy();
		redirect ( 'login' );
    }
    public function resetAdminPassword()
    {
        $id=$_POST["id"];
        $password=md5($_POST["password"]);
        $newPassword=md5($_POST["new_password"]);
        $confirmPassword=md5($_POST["confirm_password"]);
        $oldPasswordCheck=$this->Mod_dashboard->oldPasswordCheck($id);
        if($password == $oldPasswordCheck['password'] )
        {
            if($newPassword == $confirmPassword)
            {
                $data=$this->Mod_dashboard->resetAdminPassword($id,$newPassword);
                if($data == 1){
                     
                     echo "1";
                }
                else{
                     echo "2";
                }
            }
            else
            {
                echo "3";
            }
        }
        else
        {
            echo "4";
        }
    }
    public function addTags()
    {
        $tag_name=$_POST["tag_name"];
        $uid=$_POST["serial_id"];
        $uidCheck=$this->Mod_dashboard->uidCheck($uid);
        if($uidCheck)
        {
            echo "2";
            die;
        }
        $tag_image=$_FILES["tag_img"]['name'];
	    $sourcePath = $_FILES['tag_img']['tmp_name'];
	    $targetPath = "tagsImages/".$tag_image;
        if(move_uploaded_file($sourcePath, $targetPath))
        {
            $code=rand("999","10000");
            $fileName = 'qr'.$code.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$fileName;
            $urlRelativeFilePath = "qrcode/".$fileName;
            $userQr="qrcode".$code;
            QRcode::png($userQr,$urlRelativeFilePath) ;
            $data=array(
	            "tag_image"=>$tag_image,
	            "name"=>$tag_name,
	            "uid"=>$uid,
	            "qrimage"=>$urlRelativeFilePath
	        );
            //$updateqr=$this->Mod_home->updateQr($result,$userQr,$urlRelativeFilePath);
            $result=$this->Mod_dashboard->addTags($data);
            if($result)
            {
                echo "1";
            }
            else
            {
                echo "0";
            }
        }
        else
        {
            echo "0";
        }
    }
    public function editTag()
    {
        $id=$_POST["id"];
        $uid=$_POST["uid"];
        $qrcheck=$this->Mod_dashboard->oldtagiQRCheck($id);
        $oldqr=$qrcheck["uid"];
        if($uid==$oldqr)
        {
            echo "1";
        }
        else
        {
            
            $uidCheck=$this->Mod_dashboard->tagiuidCheck($uid);
            if($uidCheck)
            {
                echo "2";
                die;
            }
            else
            {
                $fileName = 'qr'.$uid.'.png';
                $tempDir = "qrcode/";
                $pngAbsoluteFilePath = $tempDir.$fileName;
                $urlRelativeFilePath = "qrcode/".$fileName;
                $userQr=$uid;
                QRcode::png($userQr,$urlRelativeFilePath);
               
                $qrres=$this->Mod_dashboard->updatetagiqrcode($id,$uid,$fileName);
                if($qrres)
                {
                    echo "1";
                }
                else
                {
                    echo "0";
                }
            }
        }
    }
    public function deleteTag()
	{
	    $id=$_POST["id"];
	    $status=$_POST["status"];
	    if($status == 1)
	    {
	        $result=$this->Mod_dashboard->deleteTag($id);
	        $this->Mod_dashboard->deleteActivateTag($id);
	    }
	    else
	    {
	        $result=$this->Mod_dashboard->deleteTag($id);
	    }
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function deleteFolder()
	{
	    $id=$_POST["id"];
	    $result=$this->Mod_dashboard->deleteFolder($id);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	
	public function deleteTagPoint()
	{
	    $id=$_POST["id"];
	    $result=$this->Mod_dashboard->deleteTagPoint($id);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function updateTagStatus()
	{
	    $status=$_POST["status"];
	    $id=$_POST["id"];
	    $result=$this->Mod_dashboard->updateTagStatus($id,$status);
	    if($result)
	    {
	        if($status == "0")
	        {
	            echo "1";
	        }
	        else
	        {
	            echo "2";
	        }
	    }
	    else
	    {
	        echo "0";
	    }
	}
	
	public function uploadExcelSheet()
	{
	    ini_set('max_execution_time', 0);
	    if($_FILES['sheet']['name'] != ""){
        $sheetfile=$_FILES['sheet']['name'];
        $category=$_POST["category"];
        $uploads_dir = 'tagsExcel';
        $sheetname = basename($_FILES["sheet"]["name"]);
        move_uploaded_file($_FILES['sheet']['tmp_name'], "$uploads_dir/$sheetname");
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("$uploads_dir/$sheetname");
        $sheet  =  $spreadsheet->getActiveSheet()->removeColumn('B');
        $data = array(2,$sheet->toArray(null,true,true,true));
              
        for ($i = 1; $i <= count($data[1]); $i ++) {
            foreach($data[$i] as $dd)
            {
                if($dd['A'] != 'UID' && $dd['A'] != '')
                {
                    $uid = str_replace(":","",$dd['A']);
                    $uidCheck=$this->Mod_dashboard->tagiIdCheck($uid);
                    if($uidCheck)
                    {
                    }
                    else
                    {
                        $fileName = 'qr'.$uid.'.png';
                        $tempDir = "qrcode/";
                        $pngAbsoluteFilePath = $tempDir.$fileName;
                        $urlRelativeFilePath = "qrcode/".$fileName;
                        $userQr=$uid;
                        QRcode::png($userQr,$urlRelativeFilePath);
                         $data=array(
            	            "uid"=>$uid,
            	            "qrimage"=>$fileName,
            	            "category"=>$category
            	        );
                        $result[]=$this->Mod_dashboard->addTagiUid($data);
                    }
                }
            }
        }
        if($result){
            echo "1";
        }
        else 
        {
            echo "0";  
        }
        }
	}
	public function tagiPoints()
	{
	    $data["tagiData"]=$this->Mod_dashboard->tagiPointsData();   
	    $this->loadViews("tagiPoints",$data);
	}
	public function addTagiPoints()
	{
	    $rangeFrom=$_POST["rangeFrom"];
	    $rangeTo=$_POST["rangeTo"];
	    $next_gift_card=$_POST["next_gift_card"];
	    $push_notification_text=$_POST["push_notification_text"];
	    $home_screen_english_note=$_POST["home_screen_english_note"];
	    $home_screen_arabic_note=$_POST["home_screen_arabic_note"];
	    $couponCodeCheck=$this->Mod_dashboard->couponCodeCheck($coupon_code);
	    if($couponCodeCheck)
	    {
	        echo "2";
	        die;
	    }
	    $data=array(
	            "point_range_from"=>$rangeFrom,
	            "point_range_to"=>$rangeTo,
	            "next_gift_card"=>$next_gift_card,
	            "push_notification"=>$push_notification_text,
	            "home_note"=>$home_screen_english_note,
	            "arabic_note"=>$home_screen_arabic_note
	        );
        $result=$this->Mod_dashboard->addTagiPoints($data);
        if($result)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
	}
	
	public function editTagiPoints()
	{
	    $id=$_POST["id"];
	    $rangeTo=$_POST["rangeTo"];
	    $rangeFrom=$_POST["rangeFrom"];
	    $next_gift_card=$_POST["next_gift_card"];
	    $push_notification=$_POST["notification_text"];
	    $home_screen_english_note=$_POST["home_screen_english_note"];
	    $home_screen_arabic_note=$_POST["home_screen_arabic_note"];
        $data=array(
            "point_range_from"=>$rangeFrom,
            "point_range_to"=>$rangeTo,
            "next_gift_card"=>$next_gift_card,
            "push_notification"=>$push_notification,
            "home_note"=>$home_screen_english_note,
            "arabic_note"=>$home_screen_arabic_note
        );
	    $result=$this->Mod_dashboard->editCouponCodeData($id,$data);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function userReward()
	{
	    $data["data"]=$this->Mod_dashboard->userRewardsData();
	    $this->loadViews("userReward",$data);
	}
	public function deleteRewardRecord()
	{
	    $id=$_POST['id'];
	    $result=$this->Mod_dashboard->deleteRewardRecord($id);
	    if($result)
	    {
	        echo "1";
	    }
	    else
	    {
	        echo "0";
	    }
	}
	public function deleteSelectedTag()
	{
	    $ids=$_POST["emp_id"];
	    $id=explode(",",$ids);
	    $count=count($id);
	    for($i=0;$i < $count;$i++)
	    {
	        $result=$this->Mod_dashboard->deleteTag($id[$i]);
	        if($result)
    	    {
    	        echo "1";
    	    }
    	    else
    	    {
    	        echo "0";
    	    }
	    }
	}
	public function addNewTag()
	{
	    $uid=$_POST["uid"];
	    $category=$_POST["category"];
	    $uidCheck=$this->Mod_dashboard->tagiIdCheck($uid);
	    if($uidCheck)
	    {
	        echo "2";
	    }
	    else
	    {
	        $fileName = 'qr'.$uid.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$fileName;
            $urlRelativeFilePath = "qrcode/".$fileName;
            $userQr=$uid;
            QRcode::png($userQr,$urlRelativeFilePath);
             $data=array(
	            "uid"=>$uid,
	            "qrimage"=>$fileName,
	            "category"=>$category
	        );
	        $result=$this->Mod_dashboard->addTagiUid($data);
	        if($result)
	        {
	            echo "1";
	        }
	        else
	        {
	            echo "0";
	        }
	    }
	}
	public function addNewFolder()
	{
	    $folder_name=$_POST['folder_name'];
	    $checkFolder=$this->Mod_dashboard->checkFolder($folder_name);
	    if($checkFolder)
	    {
	        echo "2";
	    }
	    else
	    {
	        $data=array(
	                "name"=>$folder_name
	            );
	        $result=$this->Mod_dashboard->addNewFolder($data);
	        if($result)
	        {
                echo "1";	            
	        }
	        else
	        {
	            echo "0";
	        }
	    }
	}
	public function tagsCategory($category)
	{
	    $search=$_POST['search'];
	    
	    $cat=str_replace('%20', ' ', $category);
	    $config = array();
	    $type = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $config["base_url"] = base_url() . "tagsCategory/".$type;
        if(!empty($search))
        {
            $config["total_rows"] = $this->Mod_dashboard->get_search_count($cat,$search);
        }
        else
        {
            $config["total_rows"] = $this->Mod_dashboard->get_count($cat);
        }
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["links"] = $this->pagination->create_links();
        if(!empty($search))
        {
            $data['nfcTags'] = $this->Mod_dashboard->searchnfcTagsbyCategory($cat,$config["per_page"], $page,$search);
        }
        else
        {
            $data['nfcTags'] = $this->Mod_dashboard->nfcTagsbyCategory($cat,$config["per_page"], $page);
        }
        
	    
	    //$data["nfcTags"]=$this->Mod_dashboard->nfcTagsbyCategory($cat);
	    $data["nfcFolders"]=$this->Mod_dashboard->nfcFolders();
	    $this->loadViews("tagsCategory",$data);
	}
}
?>