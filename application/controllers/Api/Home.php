<?php 
error_reporting(0);
define("API_ACCESS_KEY", "AAAANq9yX0g:APA91bEm2MBhcMiiuxgqMHJc-L158xALUdIMXmWJ93ICI56e_iVkDmsPdn1wNVU5jJdSMvUACha8Ng5x6eg6kyioaz3PDkxJH_g9Xswg71kTTrDIXZJeypj9dhD8Y-Iq2wuMG4Cegqpd");
define("SERVER_KEY", "AAAANR5KPG8:APA91bGRjKtk-2RLo69zSeymU6-N2in4IqRQcRJ-QpbjSCpSBlLi948B_eWaPcSVpDOoR8-WAPDJOkeczLvAyWjZPk08phw77gzgnys4u6PCIIV2qfpkH0XB0CkV6YGnt2_RijSVMC9H");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
//include("twilio_sms.php");
include("phpqrcode/qrlib.php");
use PKPass\PKPass;

class Home extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->helper('url');
        $this->load->model('Mod_home');
        $this->load->helper(['jwt', 'authorization']);
        
        $string="4fFiV8kRTvm5MPNDcyO1dg7lr20Qtn3X6pKLZUqaEsxCwubGYIzhSWJojHeA9B";
        $this->nums = str_split($string);
        $this->chars = array_flip($this->nums);
        if(count($this->nums) != count($this->chars))
        {
          throw new Exception("$string !important each char can be present only once.", 371);
        }
        $this->numeral = count($this->nums);
    }
    
    /**
   * Encodes a number to a string
   * @param int $int
   * @return string
   */
  public function encode($int)
  {
    if(!is_int($int))
    {
      throw new Exception("$int is not integer.", 372);
    }
    return $this->convension($int, $this->numeral);
  }

  /**
   * Decodes a string to a number
   * @param string $string
   * @return number
   */
  public function decode($string)
  {
    $num = 0;
    $m = 1;
    $parts = str_split($string);
    $parts = array_reverse($parts);
    foreach($parts as $part)
    {
      if(!isset($this->chars[$part]))
      {
        throw new Exception("$part is not defined.", 373);
      }
      $num =  $num + $this->chars[$part] * $m;
      $m = $m * $this->numeral;
    }
    return $num;
  }

  /**
   * @see http://www.cut-the-knot.org/recurrence/conversion.shtml
   */
  private function convension($M,$N)
  {
    if($M  < $N)
    {
      return $this->nums[$M];
    }
    else
    {
      return $this->convension($M / $N, $N) . $this->nums[bcmod($M , $N)];
    }
  }
    
    public function messages($filename,$language)
    {
        $this->lang->load($filename, $language);
        
    }
    public function language_messages($type)
    {
        $language=$_POST['language'];
        if($language ==  'en')
        {
            $this->messages('messages_lang','english');
            $msg=$this->lang->line($type);
        }
        elseif($language ==  'ar')
        {
            $this->messages('messages_lang','arabic');
            $msg=$this->lang->line($type);
        }
        return $msg;
    }
    public function ProfileUrlEncode($id,$type)
    {
        $prifileId=base64_encode($id);
        $business_type=str_rot13($type);
        $profile_url=$prifileId.$business_type;
        $seed = 1234567890;
        mt_srand($seed);
        $url = str_shuffle($profile_url);
        return $url;
    }
    public function directStatusEncode($status)
    {
        $statuss=base64_encode($status);
        $direct_status=str_rot13($statuss);
        $seed = 1234567890;
        mt_srand($seed);
        $url = str_shuffle($direct_status);
        return $url;
    }
    public function directStatusDecode($str, $seed){
        $unique = implode(array_map('chr',range(0,254)));
        $none   = chr(255);
        $slen   = strlen($str);
        $c      = intval(ceil($slen/255));
        $r      = '';
        for($i=0; $i<$c; $i++){
            $aaa = str_repeat($none, $i*255);
            $bbb = (($i+1)<$c) ? $unique : substr($unique, 0, $slen%255);
            $ccc = (($i+1)<$c) ? str_repeat($none, strlen($str)-($i+1)*255) : "";
            $tmp = $aaa.$bbb.$ccc;
            mt_srand($seed);
            $sh  = str_shuffle($tmp);
            for($j=0; $j<strlen($bbb); $j++){
                $r .= $str{strpos($sh, $unique{$j})};
            }
        }
        return $r;
    }
    public function ProfileUrlDecode($str, $seed){
        $unique = implode(array_map('chr',range(0,254)));
        $none   = chr(255);
        $slen   = strlen($str);
        $c      = intval(ceil($slen/255));
        $r      = '';
        for($i=0; $i<$c; $i++){
            $aaa = str_repeat($none, $i*255);
            $bbb = (($i+1)<$c) ? $unique : substr($unique, 0, $slen%255);
            $ccc = (($i+1)<$c) ? str_repeat($none, strlen($str)-($i+1)*255) : "";
            $tmp = $aaa.$bbb.$ccc;
            mt_srand($seed);
            $sh  = str_shuffle($tmp);
            for($j=0; $j<strlen($bbb); $j++){
                $r .= $str{strpos($sh, $unique{$j})};
            }
        }
        return $r;
    }
    public function signUp()
    {
        $first_name=$_POST["first_name"];
        $last_name=$_POST["last_name"];
        $email=$_POST["email"];
        $password=md5($_POST["password"]);
        $country=$_POST["country"];
        $devicetoken=$_POST['devicetoken'];
        $devicetype=$_POST['devicetype'];
        $emailCheck=$this->Mod_home->emailCheck($email);
        if(!empty($emailCheck))
        {
            $message=$this->language_messages('error_email_registered');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
        else
        {
            $data=array(
                    "first_name"=>$first_name,
                    "last_name"=>$last_name,
                    "email"=>$email,
                    "password"=>$password,
                    "country"=>$country,
                    "devicetoken"=>$devicetoken,
                    "devicetype"=>$devicetype
                );
            $result=$this->Mod_home->signUp($data);
            if($result)
            {
                $name=$first_name;
                $insert_id=$result;
                $id=base64_encode($insert_id);
                $url_email=explode("@",$email);
                $url=$id."/".$url_email[0];
                $this->Mod_home->profileUrl($insert_id,$url);
                $date=date("dmYhis");
                //Public Qr Code
                $public_code=rand("999","10000").$date;
                $fileName = 'qr'.$public_code.'.png';
                $tempDir = "qrcode/";
                $pngAbsoluteFilePath = $tempDir.$fileName;
                $urlRelativeFilePath = "qrcode/".$fileName;
                $userQr="qrcode".$public_code;
                /*$type=base64_encode('Public');*/
                $profileLink=$this->ProfileUrlEncode($insert_id,'UDP');
                /*$status=1;
                $encode_status=$this->directStatusEncode($status);*/
                $data="https://tagmoi.co/read/qrcode/qrcode".$public_code."/".$profileLink;
                /*QRcode::png($userQrUrl,$urlRelativeFilePath) ;*/
                $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
                $logo = 'assets/img/qr_logo.png';
                $filepath = 'qrcode/qr'.$public_code.'.png';
                //header('Content-type: image/png');
                // Get QR Code image from Google Chart API
                // http://code.google.com/apis/chart/infographics/docs/qr_codes.html
                $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
                if($logo !== FALSE){
                	$logo = imagecreatefromstring(file_get_contents($logo));
                
                	$QR_width = imagesx($QR);
                	$QR_height = imagesy($QR);
                	
                	$logo_width = imagesx($logo);
                	$logo_height = imagesy($logo);
                	
                	// Scale logo to fit in the QR Code
                	$logo_qr_width = $QR_width/5;
                	$scale = $logo_width/$logo_qr_width;
                	$logo_qr_height = $logo_height/$scale;
                	
                	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
                /*imagepng($QR);*/
                imagepng($QR,$filepath);
                imagedestroy($QR);
                //Business Qr Code
                $business_code=rand("999","10000").$date;
                $businessfileName = 'qr'.$business_code.'.png';
                $tempDir = "qrcode/";
                $pngAbsoluteFilePath = $tempDir.$businessfileName;
                $urlRelativeFilePath = "$business_code/".$businessfileName;
                 $businessuserQr="qrcode".$business_code;
                /*$type=base64_encode('Business');*/
                $businessLink=$this->ProfileUrlEncode($insert_id,'UBP');
                 /*$status=1;
                $encode_status=$this->directStatusEncode($status);*/
                 $businessdata="https://tagmoi.co/read/qrcode/qrcode".$business_code."/".$businessLink;
                $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
                $logo = 'assets/img/qr_logo.png';
                 $businessfilepath = 'qrcode/qr'.$business_code.'.png';
                $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($businessdata));
                if($logo !== FALSE){
                	$logo = imagecreatefromstring(file_get_contents($logo));
                
                	$QR_width = imagesx($QR);
                	$QR_height = imagesy($QR);
                	
                	$logo_width = imagesx($logo);
                	$logo_height = imagesy($logo);
                	
                	// Scale logo to fit in the QR Code
                	$logo_qr_width = $QR_width/5;
                	$scale = $logo_width/$logo_qr_width;
                	$logo_qr_height = $logo_height/$scale;
                	
                	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
                /*imagepng($QR);*/
                imagepng($QR,$businessfilepath);
                imagedestroy($QR);
                //Private Qr Code
                $private_code=rand("111","10000").$date;
                $privatefileName = 'qr'.$private_code.'.png';
                $tempDir = "qrcode/";
                $pngAbsoluteFilePath = $tempDir.$privatefileName;
                $urlRelativeFilePath = "qrcode/".$privatefileName;
                 $privateuserQr="qrcode".$private_code;
                /*$type=base64_encode('Private');*/
                $profileLink=$this->ProfileUrlEncode($insert_id,'UPP');
                /*$status=1;
                $encode_status=$this->directStatusEncode($status);*/
                 $data="https://tagmoi.co/read/qrcode/qrcode".$private_code."/".$profileLink;
                $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
                $logo = 'assets/img/qr_logo.png';
                 $privatefilepath = 'qrcode/qr'.$private_code.'.png';
                $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
                if($logo !== FALSE){
                	$logo = imagecreatefromstring(file_get_contents($logo));
                
                	$QR_width = imagesx($QR);
                	$QR_height = imagesy($QR);
                	
                	$logo_width = imagesx($logo);
                	$logo_height = imagesy($logo);
                	
                	// Scale logo to fit in the QR Code
                	$logo_qr_width = $QR_width/5;
                	$scale = $logo_width/$logo_qr_width;
                	$logo_qr_height = $logo_height/$scale;
                	
                	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
                /*imagepng($QR);*/
                imagepng($QR,$privatefilepath);
                imagedestroy($QR);
                $updateqr=$this->Mod_home->updateQr($result,$userQr,$filepath,$businessuserQr,$businessfilepath,$privateuserQr,$privatefilepath);
                if($updateqr)
                {
                    $userData=$this->Mod_home->getUserProfile($result);
                    unset($userData['password']);
                    $url["public_url"]=$this->ProfileUrlEncode($insert_id,'UDP');
                    $url["business_url"]=$this->ProfileUrlEncode($insert_id,'UBP');
                    $url["private_url"]=$this->ProfileUrlEncode($id,'UPP');
                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                    $message=$this->language_messages('successfully_register');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$userData,"token"=>$token,"profile_url"=>$url));    
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message)); 
                }
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
    }
    public function addProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded = JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecoded->id;
            $userName=$_POST["name"];
            $description=$_POST["description"];
            $addprofile_status=1;
            if(!empty($_FILES["profile_image"]["name"]))
            {
                $profileImages=$_FILES["profile_image"]["name"];
                $data=array(
                    "profile_image"=>$profileImages,
                    "user_name"=>$userName,
                    "description"=>$description,
                    "addprofile_status"=>$addprofile_status
                );
                $pictures=$_FILES['profile_image']['name'];
                $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                $profileImages = $_FILES['profile_image']['name']; 
                $sourcePath = $_FILES['profile_image']['tmp_name'];  
                $targetPath = "profileImages/".$profileImages;  
                if(move_uploaded_file($sourcePath, $targetPath)) 
                {
                    
                    $this->Mod_home->updateProfile($user_id,$data);
                    $userData=$this->Mod_home->getUserProfile($user_id);
                    $id=base64_encode($user_id);
                    $url_email=explode("@",$userData["email"]);
                    $url=$id."/".$url_email[0];
                    $publicDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Public",
                            "status"=>1
                        );
                    $privateDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Private",
                            "status"=>0
                        );
                    $businessDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Business",
                            "status"=>0
                        );
                    $publicUserDetail=$this->Mod_home->publicUserDetail($publicDetails);
                    $privateUserDetail=$this->Mod_home->privateUserDetail($privateDetails);
                    $businessUserDetail=$this->Mod_home->businessUserDetail($businessDetails);
                    $message=$this->language_messages('profile_updated');
                    echo json_encode(array("status"=>"200","message"=>"Profile updated successfully","data"=>$userData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $data=array(
                        "user_name"=>$userName,
                        "description"=>$description,
                        "addprofile_status"=>$addprofile_status
                    );
                $result=$this->Mod_home->updateProfile($user_id,$data);
                $userData=$this->Mod_home->getUserProfile($user_id);
                $id=base64_encode($user_id);
                    $url_email=explode("@",$userData["email"]);
                    $url=$id."/".$url_email[0];
                    $profileImages="";
                    $publicDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Public",
                            "status"=>1
                        );
                    $privateDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Private",
                            "status"=>0
                        );
                    $businessDetails=array(
                            "user_id"=>$user_id,
                            "name"=>$userName,
                            "image"=>$profileImages,
                            "description"=>$description,
                            "profile_url"=>$url,
                            "type"=>"Business",
                            "status"=>0
                        );
                    $publicUserDetail=$this->Mod_home->publicUserDetail($publicDetails);
                    $privateUserDetail=$this->Mod_home->privateUserDetail($privateDetails);
                    $businessUserDetail=$this->Mod_home->businessUserDetail($businessDetails);
                if($result)
                {
                    $userData=$this->Mod_home->getUserProfile($user_id);
                    $message=$this->language_messages('profile_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$userData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    //UDP -- User Default Profile.
    //UBP -- User Business Profile.
    //UPP -- User Private Profile.
    public function login()
    {
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $devicetoken=$_POST['devicetoken'];
        $devicetype=$_POST['devicetype'];
        $islogin=1;
        $loginCheck=$this->Mod_home->login($email,$password);
        if($loginCheck)
        {   
            $id=$loginCheck['id'];
            $login_data=array(
                "devicetoken"=>$devicetoken,
                "devicetype"=>$devicetype,
                "islogin"=>$islogin
            );
            $totalPoints=$this->Mod_home->userTotalPoints($id);
            if(!empty($totalPoints["points"]))
            {
                $totalPoint=$totalPoints["points"];
            }
            else
            {
                $totalPoint="0";
            }
            $update_login_data=$this->Mod_home->updateLoginData($id,$login_data);
            $medicalDetails=$this->Mod_home->medicalStatus($id);
            $login_user_data=$this->Mod_home->getLoginData($id);
            unset($login_user_data['password']);
            $medical["user_medical_status"]=["profile_status"];
            $data["id"]=$login_user_data["id"];
            $data["first_name"]=$login_user_data["first_name"];
            $data["last_name"]=$login_user_data["last_name"];
            $data["user_name"]=$login_user_data["user_name"];
            $data["email"]=$login_user_data["email"];
            $data["protected_password"]=$login_user_data["protected_password"];
            $data["country"]=$login_user_data["country"];
            $data["profile_image"]=$login_user_data["profile_image"];
            $data["description"]=$login_user_data["description"];
            $data["devicetoken"]=$login_user_data["devicetoken"];
            $data["devicetype"]=$login_user_data["devicetype"];
            $data["latitude"]=$login_user_data["latitude"];
            $data["longitude"]=$login_user_data["longitude"];
            $data["qrcode"]=$login_user_data["qrcode"];
            $data["qrimage"]=$login_user_data["qrimage"];
            $data["business_qrcode"]=$login_user_data["business_qrcode"];
            $data["business_qrimage"]=$login_user_data["business_qrimage"];
            $data["private_qrcode"]=$login_user_data["private_qrcode"];
            $data["private_qrimage"]=$login_user_data["private_qrimage"];
            $data["public_url"]=$this->ProfileUrlEncode($id,'UDP');
            $data["business_url"]=$this->ProfileUrlEncode($id,'UBP');
            $data["private_url"]=$this->ProfileUrlEncode($id,'UPP');
            $data["islogin"]=$login_user_data["islogin"];
            $data["profile_status"]=$login_user_data["profile_status"];
            $data["default_public_status"]=$login_user_data["default_public_status"];
            $data["default_private_status"]=$login_user_data["default_private_status"];
            $data["default_business_status"]=$login_user_data["default_business_status"];
            $data["medical_status"]=$login_user_data["medical_status"];
            $data["profile_url"]=$login_user_data["profile_url"];
            $data["addprofile_status"]=$login_user_data["addprofile_status"];
            $data["purchased_tag_status"]=$login_user_data["purchased_tag_status"];
            $data["user_medical_status"]=$medicalDetails["profile_status"];
            $data["points"]=$totalPoint;
            $data["create_date"]=$login_user_data["create_date"];
            $token=JWT::encode($login_user_data, $this->config->item('jwt_key'));
            $message=$this->language_messages('login_successfully');
            echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data,"token"=>$token));
        }
        else
        {
            $message=$this->language_messages('invalid_credentials');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function editProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $type="Public";
            $userName=$_POST["name"];
            $description=$_POST["description"];
            $profileStatus=$_POST["profile_status"];
            if(!empty($_FILES["profile_image"]["name"]))
            {
                $profileImages=$_FILES["profile_image"]["name"];
                $data=array(
                    "profile_image"=>$profileImages,
                    "user_name"=>$userName,
                    "description"=>$description
                    /*"profile_status"=>$profileStatus*/
                );
                $publicData=array(
                    "image"=>$profileImages,
                    "name"=>$userName,
                    "description"=>$description
                );
                $pictures=$_FILES['profile_image']['name'];
                $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                $profileImages = $_FILES['profile_image']['name']; 
                $sourcePath = $_FILES['profile_image']['tmp_name'];  
                $targetPath = "profileImages/".$profileImages;  
                if(move_uploaded_file($sourcePath, $targetPath)) 
                {  
                    $this->Mod_home->editProfile($user_id,$data);
                    $this->Mod_home->editPublicProfile($user_id,$type,$publicData);
                    $businessData=$this->Mod_home->getAllProfileImage($user_id,'Business');
                    if(empty($businessData['image']))
                    {
                        $this->Mod_home->updateAllProfileimage($user_id,$profileImages,'Business');
                    }
                    $privateData=$this->Mod_home->getAllProfileImage($user_id,'Private');
                    if(empty($privateData['image']))
                    {
                        $this->Mod_home->updateAllProfileimage($user_id,$profileImages,'Private');
                    }
                    $userData=$this->Mod_home->getUserProfile($user_id);
                    $message=$this->language_messages('profile_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$userData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $data=array(
                    "user_name"=>$userName,
                    "description"=>$description
                );
                $publicData=array(
                    "name"=>$userName,
                    "description"=>$description
                );
                $result=$this->Mod_home->editProfile($user_id,$data);
                if($result)
                {
                    $this->Mod_home->editPublicProfile($user_id,$type,$publicData);
                    $userData=$this->Mod_home->getUserProfile($user_id);
                    $message=$this->language_messages('profile_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$userData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function changeEmailId()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $email=$_POST["email"];
            $emailCheck=$this->Mod_home->emailCheck($email);
            if(!empty($emailCheck))
            {
                $message=$this->language_messages('error_email_registered');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
            else
            {
                $userData=$this->Mod_home->tagiUserDetails($user_id);
                $name=$userData['first_name']." ".$userData['last_name'];
                $oldEmail=$userData['email'];
                $result=$this->Mod_home->changeEmail($user_id,$email);
                if($result)
                {
                    $code=rand("999999","100000");
                    $language=$_POST['language'];
                    
                    if($language == 'en')
                    {
                        $type="Change Email";
                        $body='We have received a request to reset your TagMoi Email.';
                        $this->sendChangePasswordMail($oldEmail,$type,$name,$code,$body);
                    }
                    elseif($language == 'ar')
                    {
                        $body=".لقد تلقينا طلبًا لتغير البريد الالكتروني لتاغ موا  الخاصة بك";
                        $type="تغير البريد الإلكتروني";
                        $this->sendArabicChangePasswordMail($oldEmail,$type,$name,$code,$body);
                    }
                    $updatedEmail=$this->Mod_home->updatedEmail($user_id);
                    $this->Mod_home->updateOldEmailOtp($user_id,$code);
                    $message=$this->language_messages('email_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$updatedEmail));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function otpVerification()
    {
        $token=$_POST['token'];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $otp=$_POST['otp'];
            $type=$_POST["type"];
            if($type == "old_email")
            {
                $status=1;
                $emailOtp=$this->Mod_home->getChangeEmailOtp($user_id);
                if($emailOtp['oldEmail_otp'] == $otp)
                {
                    $emailStatus=$this->Mod_home->updatechangeEmailStatus($user_id,$type,$status);
                    if($emailStatus)
                    {
                        $userData=$this->Mod_home->tagiUserDetails($user_id);
                        $name=$userData['first_name']." ".$userData['last_name'];
                        $email=$userData['changeEmail_request'];
                        $code=rand("999999","100000");
                        $language=$_POST['language'];
                        if($language == 'en')
                        {
                            $type="Change Email";
                            $body='We have received a request to reset your TagMoi Email.';
                            $this->sendChangePasswordMail($email,$type,$name,$code,$body);
                        }
                        elseif($language == 'ar')
                        {
                            $body=".لقد تلقينا طلبًا لتغير البريد الالكتروني لتاغ موا  الخاصة بك";
                            $type="تغير البريد الإلكتروني";
                            $this->sendArabicChangePasswordMail($email,$type,$name,$code,$body);
                        }
                        $this->Mod_home->updatechangeEmailOtp($user_id,$code);
                        $message=$this->language_messages('oldEmail_otp_updated');
                        echo json_encode(array("status"=>"200","message"=>$message,'data'=>$email));
                        
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));   
                    }
                }
                else
                {
                    $message=$this->language_messages('error_email_otp_updated');
                    echo json_encode(array("status"=>"400","message"=>$message));   
                }
            }
            elseif($type == "change_email")
            {
                $status=1;
                $emailOtp=$this->Mod_home->getChangeEmailOtp($user_id);
                if($emailOtp['changeEmail_otp'] == $otp)
                {
                    $emailStatus=$this->Mod_home->updatechangeEmailStatus($user_id,$type,$status);
                    if($emailStatus)
                    {
                        $requestData=$this->Mod_home->getRequestEmail($user_id);
                        $email=$requestData["changeEmail_request"];
                        $this->Mod_home->updateChangeEmailRequest($email,$user_id);
                        $message=$this->language_messages('email_otp_updated');
                        echo json_encode(array("status"=>"200","message"=>$message,'data'=>$email)); 
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));   
                    }
                }
                else
                {
                    $message=$this->language_messages('error_email_otp_updated');
                    echo json_encode(array("status"=>"400","message"=>$message));   
                }
            }
            elseif($type == "forgot_password")
            {
                $status=1;
                $emailOtp=$this->Mod_home->getChangeEmailOtp($user_id);
                if($emailOtp['forgotEmail_otp'] == $otp)
                {
                    $emailStatus=$this->Mod_home->updatechangeEmailStatus($user_id,$type,$status);
                    if($emailStatus)
                    {
                        $message=$this->language_messages('email_otp_updated');
                        echo json_encode(array("status"=>"200","message"=>$message)); 
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));   
                    }
                }
                else
                {
                    $message=$this->language_messages('error_email_otp_updated');
                    echo json_encode(array("status"=>"400","message"=>$message));   
                }
            }
            elseif($type == "private_password")
            {
                $status=1;
                $emailOtp=$this->Mod_home->getChangeEmailOtp($user_id);
                if($emailOtp['privatePassword_otp'] == $otp)
                {
                    $emailStatus=$this->Mod_home->updatechangeEmailStatus($user_id,$type,$status);
                    if($emailStatus)
                    {
                        $message=$this->language_messages('email_otp_updated');
                        echo json_encode(array("status"=>"200","message"=>$message)); 
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));   
                    }
                }
                else
                {
                    $message=$this->language_messages('error_email_otp_updated');
                    echo json_encode(array("status"=>"400","message"=>$message));   
                }
            }
        }
    }
    public function changePassword()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $password=md5($_POST["password"]);
            $newPassword=md5($_POST["new_password"]);
            $confirmPassword=md5($_POST["confirm_password"]);
            $passwordCheck=$this->Mod_home->passwordCheck($user_id);
            $userPassword=$passwordCheck["password"];
            if($password == $userPassword)
            {
                if($newPassword == $confirmPassword)
                {
                    $result=$this->Mod_home->updateNewPassword($user_id,$newPassword);
                    if($result)
                    {
                        $message=$this->language_messages('profile_updated');
                        echo json_encode(array("status"=>"200","message"=>$message));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
                else
                {
                    $message=$this->language_messages('error_confirm_password_not_match');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_password_not_match');
                echo json_encode(array("status"=>"400","message"=>"Password does not match so please try again"));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function changeCountry()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $country=$_POST["country"];
            $result=$this->Mod_home->updateCountry($user_id,$country);
            if($result)
            {
                $message=$this->language_messages('country_updated');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));    
        }
    }
    public function rateUs()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecoded->id;
            $rating=$_POST["rating"];
            $comment=$_POST["comment"];
            $data=array(
                    "user_id"=>$user_id,
                    "rating"=>$rating,
                    "comment"=>$comment
                );
            $result=$this->Mod_home->rateUs($data);
            if($result)
            {
                $message=$this->language_messages('added_successfully');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function medicalDetails()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $first_name=$_POST["first_name"];
            $last_name=$_POST["last_name"];
            $dob=$_POST["dob"];
            $city=$_POST["city"];
            $state=$_POST["state"];
            $country=$_POST["country"];
            $medical_condition=$_POST["medical_condition"];
            $allergies_reactions=$_POST["allergies_reactions"];
            $medications=$_POST["medications"];
            $blood_type=$_POST["blood_type"];
            $weight=$_POST["weight"];
            $height=$_POST["height"];
            $name=$_POST["name"];
            $mobile_number=$_POST["mobile_number"];
            $relation_type=$_POST["relation_type"];
            $profile_status=$_POST["profile_status"];
            if(!empty($_FILES["profile_image"]["name"]))
            {
                $profileImages=$_FILES["profile_image"]["name"];
                $pictures=$_FILES['profile_image']['name'];
                $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                $profileImages = $_FILES['profile_image']['name']; 
                $sourcePath = $_FILES['profile_image']['tmp_name'];  
                $targetPath = "profileImages/".$profileImages;  
                if(move_uploaded_file($sourcePath, $targetPath)) 
                {  
                    $data=array(
                        "profile_image"=>$profileImages,
                        "user_id"=>$user_id,
                        "first_name"=>$first_name,
                        "last_name"=>$last_name,
                        "dob"=>$dob,
                        "city"=>$city,
                        "state"=>$state,
                        "country"=>$country,
                        "medical_condition"=>$medical_condition,
                        "allergies_reactions"=>$allergies_reactions,
                        "medications"=>$medications,
                        "blood_type"=>$blood_type,
                        "weight"=>$weight,
                        "height"=>$height,
                        "name"=>$name,
                        "mobile_number"=>$mobile_number,
                        "relation_type"=>$relation_type,
                        "profile_status"=>$profile_status
                        );
                    $result=$this->Mod_home->medicalDetails($data);
                    if($result)
                    {
                        $status=1;
                        $this->Mod_home->updateMedicalDetailStatus($user_id,$status);
                        $medicalData=$this->Mod_home->userMedicalDetails($result);
                        $message=$this->language_messages('added_successfully');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$medicalData));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
            else
            {
                $data=array(
                    "user_id"=>$user_id,
                    "first_name"=>$first_name,
                    "last_name"=>$last_name,
                    "dob"=>$dob,
                    "city"=>$city,
                    "state"=>$state,
                    "country"=>$country,
                    "medical_condition"=>$medical_condition,
                    "allergies_reactions"=>$allergies_reactions,
                    "medications"=>$medications,
                    "blood_type"=>$blood_type,
                    "weight"=>$weight,
                    "height"=>$height,
                    "name"=>$name,
                    "mobile_number"=>$mobile_number,
                    "relation_type"=>$relation_type,
                    "profile_status"=>$profile_status
                    );
                $result=$this->Mod_home->medicalDetails($data);
                if($result)
                {
                    $status=1;
                    $this->Mod_home->updateMedicalDetailStatus($user_id,$status);
                    $medicalData=$this->Mod_home->userMedicalDetails($result);
                    $message=$this->language_messages('added_successfully');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$medicalData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function getMedicalDetails()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode=JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            
            $result=$this->Mod_home->getMedicalDetails($user_id);
            if($result)
            {
                $message=$this->language_messages('medical_detail');
                echo json_encode(array("status"=>"200","message"=>$message,"data"=>$result));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function editMedicalDetails()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $id=$_POST["id"];
            $first_name=$_POST["first_name"];
            $last_name=$_POST["last_name"];
            $dob=$_POST["dob"];
            $city=$_POST["city"];
            $state=$_POST["state"];
            $country=$_POST["country"];
            $medical_condition=$_POST["medical_condition"];
            $allergies_reactions=$_POST["allergies_reactions"];
            $medications=$_POST["medications"];
            $blood_type=$_POST["blood_type"];
            $weight=$_POST["weight"];
            $height=$_POST["height"];
            $name=$_POST["name"];
            $mobile_number=$_POST["mobile_number"];
            $relation_type=$_POST["relation_type"];
            $profile_status=$_POST["profile_status"];
            if(!empty($_FILES["profile_image"]["name"]))
            {
                $profileImages=$_FILES["profile_image"]["name"];
                $pictures=$_FILES['profile_image']['name'];
                $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                $profileImages = $_FILES['profile_image']['name']; 
                $sourcePath = $_FILES['profile_image']['tmp_name'];  
                $targetPath = "profileImages/".$profileImages;  
                if(move_uploaded_file($sourcePath, $targetPath)) 
                {
                    $data=array(
                            "profile_image"=>$profileImages,
                            "first_name"=>$first_name,
                            "last_name"=>$last_name,
                            "dob"=>$dob,
                            "city"=>$city,
                            "state"=>$state,
                            "country"=>$country,
                            "medical_condition"=>$medical_condition,
                            "allergies_reactions"=>$allergies_reactions,
                            "medications"=>$medications,
                            "blood_type"=>$blood_type,
                            "weight"=>$weight,
                            "height"=>$height,
                            "name"=>$name,
                            "mobile_number"=>$mobile_number,
                            "relation_type"=>$relation_type,
                            "profile_status"=>$profile_status
                        );
                    $result=$this->Mod_home->updateMedicalDetails($id,$data);
                    if($result)
                    {
                        $medicalData=$this->Mod_home->userMedicalDetails($id);
                        $message=$this->language_messages('details_updated_successfully');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$medicalData));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
            else
            {
                $data=array(
                        "first_name"=>$first_name,
                        "last_name"=>$last_name,
                        "dob"=>$dob,
                        "city"=>$city,
                        "state"=>$state,
                        "country"=>$country,
                        "medical_condition"=>$medical_condition,
                        "allergies_reactions"=>$allergies_reactions,
                        "medications"=>$medications,
                        "blood_type"=>$blood_type,
                        "weight"=>$weight,
                        "height"=>$height,
                        "name"=>$name,
                        "mobile_number"=>$mobile_number,
                        "relation_type"=>$relation_type,
                        "profile_status"=>$profile_status
                    );
                $result=$this->Mod_home->updateMedicalDetails($id,$data);
                if($result)
                {
                    $medicalData=$this->Mod_home->userMedicalDetails($id);
                    $message=$this->language_messages('details_updated_successfully');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$medicalData));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    
    public function tagsList()
    {
        $result=$this->Mod_home->tagsList();
        if($result)
        {
            echo json_encode(array("status"=>"200","message"=>"Tags List","data"=>$result));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function activateTagi()
    {
        $token=$_POST["token"];
        $language=$_POST['language'];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecode->id;
            $tagi=$_POST["tagi_id"];
            $status=$_POST['status'];
/*            $tagi_id=str_replace(":"," ","$tagi");
            echo $tagi_id;
            die;*/
            
            $res=$this->Mod_home->checkActiveTagi($tagi);
            
            if($status == 1)
            {
                if($res)
                {
                    if($res["status"] == 0)
                    {
                        if($res["user_id"] == $user_id)
                        {
                            $updateUserTagi=$this->Mod_home->updateUserTagi($user_id,$tagi);
                            $idd=$res["tagi_id"];
                            if($updateUserTagi)
                            {
                                echo json_encode(array("status"=>"201","message"=>"TagMoi Activated","tagi_id"=>$idd));
                            }
                            die;
                        }
                        else
                        {
                            $message=$this->language_messages('error_already_used');
                            echo json_encode(array("status"=>"400","message"=>$message));
                            die;
                        }
                    }
                    else
                    {
                        $message=$this->language_messages('error_already_used');
                        echo json_encode(array("status"=>"400","message"=>$message));
                        die;
                    }
                }
                $tagiCount=$this->Mod_home->tagiCount($user_id);
               // $totalTagi=$tagiCount+1;
                if($language == "en")
                {
                    $name="GroTag";
                }
                else
                {
                    $name="قروتاق";
                }
                $result=$this->Mod_home->tagiCheck($tagi);
                if($result)
                {
                    if($result["status"] == 1)
                    {
                        $status=1;
                        $tag_id=$result["id"];
                        $tag_image=$result["qrimage"];
                        $data=array(
                            "user_id"=>$user_id,
                            "uid"=>$tagi,
                            "name"=>$name,
                            "tagi_id"=>$tag_id,
                            "tagi_image"=>$tag_image
                        );
                        $activeTagi=$this->Mod_home->activateTagi($data);
                        if($activeTagi)
                        {
                            $purchased_tag_status=1;
                            $this->Mod_home->updateUserTagStatus($user_id,$purchased_tag_status);
                            $this->Mod_home->updatesTagistatus($tag_id,$status);
                            $userData=$this->Mod_home->tagiUserDetails($user_id);
                            $first_name=$userData["first_name"];
                            $last_name=$userData["last_name"];
                            $name=$first_name.$lats_name;
                            $tagi_id=base64_encode($tag_id);
                            //$url=base_url()."profile/$name/$id";
                            $url="https://tagmoi.co/read/profile/".$tagi_id;
                            //$url="http://saurabh.parastechnologies.in/tagi/Api/Home/testlinking";
                            //echo json_encode(array("status"=>"200","message"=>"TagMoi Activated","Url"=>$url,"tagi_id"=>$tag_id));
                            echo json_encode(array("status"=>"200","message"=>"TagMoi Activated","Url"=>$url,"tagi_id"=>$tag_id));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $message=$this->language_messages('error_deactivated');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
                else
                {
                    $message=$this->language_messages('error_valid_tagmoi');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $result=$this->Mod_home->tagiCheck($tagi);
                if($result)
                {
                    if($res["user_id"] == $user_id)
                    {
                        if($res['status'] == 0)
                        {
                            $updateUserTagi=$this->Mod_home->updateUserTagi($user_id,$tagi);
                            $idd=$res["tagi_id"];
                            if($updateUserTagi)
                            {
                                echo json_encode(array("status"=>"201","message"=>"TagMoi Activated","tagi_id"=>$idd));
                            }
                            die;
                        }
                        else
                        {
                            $message=$this->language_messages('error_already_used');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        if($result["active_status"] ==0)
                        {
                            $tag_id=$result["id"];
                            $tagi_id=base64_encode($tag_id);
                            $url="https://tagmoi.co/read/profile/".$tagi_id;
                            echo json_encode(array("status"=>"200","message"=>"TagMoi Url","Url"=>$url,"tagi_id"=>$tag_id));
                        }
                        else
                        {
                            $message=$this->language_messages('error_already_used');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                }
                else
                {
                    $message=$this->language_messages('error_valid_tagmoi');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function myTagi()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecode->id;
            $result=$this->Mod_home->myTagi($user_id);
            if($result)
            {
                echo json_encode(array("status"=>"200","message"=>"My TagMoi","data"=>$result));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function tagiDeactivate()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecode->id;
            $tagi_id=$_POST["tagi_id"];
            $tagiCheck=$this->Mod_home->tagiUidCheck($tagi_id);
            if($tagiCheck)
            {
                $result=$this->Mod_home->tagi_deactivate($tagi_id,$user_id);
                if($result)
                {
                    echo json_encode(array("status"=>"200","message"=>"TagMoi Deactivate","tagi_id"=>$tagi_id));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_valid_tagmoi');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function tagiActivate()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecode->id;
            $tagi_id=$_POST["tagi_id"];
            $tagiCheck=$this->Mod_home->tagiUidCheck($tagi_id);
            if($tagiCheck)
            {
                $result=$this->Mod_home->tagi_activate($tagi_id,$user_id);
                if($result)
                {
                    echo json_encode(array("status"=>"200","message"=>"TagMoi Activate","tagi_id"=>$tagi_id));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_valid_tagmoi');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function peopleLog()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_token'), array('HS256'));
            $user_id=$tokenDecode->id;
            $name=$_POST["name"];
            if(!empty($name))
            {
                $result=$this->Mod_home->peopleLog($name);
                if($result)
                {
                    echo json_encode(array("status"=>"200","message"=>"People Logs","data"=>$result));
                }
                else
                {
                    $message=$this->language_messages('error_not_found');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function addPeopleLog()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $id=$_POST["profile_id"];
            $date=date('Y-m-d h:i:s');
            $resultCheck=$this->Mod_home->peopleLogCheck($user_id,$id);
            if($resultCheck)
            {
                /*$result=$this->Mod_home->addpeopleLog($user_id,$profile_id);
                if($result)
                {
                    echo json_encode(array("status"=>"200","message"=>"Add successfully"));
                }
                else
                {
                    echo json_encode(array("status"=>"400","message"=>"Something is wrong please try again"));
                }*/
                $totalPoints=$this->Mod_home->userTotalPoints($id);
                if(!empty($totalPoints["points"]))
                {
                    $totalPoint=$totalPoints["points"];
                }
                else
                {
                    $totalPoint="0";
                }
                $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                $medicalDetails=$this->Mod_home->medicalStatus($id);
                $data=$this->Mod_home->userTagiDetails($id);
                if($data)
                {
                    $udata=$this->Mod_home->userTagiDetails($user_id);
                    $default_public_status=$data["default_public_status"];
                    $default_private_status=$data["default_private_status"];
                    $default_business_status=$data["default_business_status"];
                    
                    $user_default_public_status=$udata["default_public_status"];
                    $user_default_private_status=$udata["default_private_status"];
                    $user_default_business_status=$udata["default_business_status"];
                    
                    if($user_default_public_status == 1)
                    {
                       $user_type="Public";
                    }
                    if($user_default_private_status == 1)
                    {
                       $user_type="Private";
                    }
                    if($user_default_business_status == 1)
                    {
                        $user_type="Business";
                    }
                    if($default_public_status == 1)
                    {
                        $type="Public";
                        $publicData=$this->Mod_home->tagiDataList($id,$type);
                        $direct_status=$publicData["direct_status"];
                        $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                        $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$publicData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$publicData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$publicData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$publicData["type"];
                        $user_data["profile_image"]=$publicData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                    }
                    if($default_private_status == 1)
                    {
                        $type="Private";
                        $privateData=$this->Mod_home->privateTagiList($id,$type);
                        $direct_status=$privateData["direct_status"];
                        $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                        $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$privateData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$privateData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$privateData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$privateData["type"];
                        $user_data["profile_image"]=$privateData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                    }
                    if($default_business_status == 1)
                    {
                        $type="Business";
                        $businessData=$this->Mod_home->businessTagiList($id,$type);
                        $direct_status=$businessData["direct_status"];
                        $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                        $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$businessData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$businessData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$businessData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$businessData["type"];
                        $user_data["profile_image"]=$businessData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                    }
                    if($user_data)
                    {
                        $userData=$this->Mod_home->getUserProfile($id);
                        unset($userData['password']);
                        $token=JWT::encode($userData, $this->config->item('jwt_key'));
                        echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
                else
                {
                    $log_data=$this->Mod_home->logPointData($id);
                    if($log_data)
                    {
                        $points=$log_data["points"];
                        $addpoint=$points+1;
                        $update_points=$this->Mod_home->updateLogPoints($id,$addpoint);
                        if($update_points)
                        {
                            $totalPoints=$this->Mod_home->userTotalPoints($id);
                            if(!empty($totalPoints["points"]))
                            {
                                $totalPoint=$totalPoints["points"];
                            }
                            else
                            {
                                $totalPoint="0";
                            }
                            $giftCard=$this->Mod_home->getAllGiftCards();
                            foreach($giftCard as $gc)
                            {
                                $userDetails=$this->Mod_home->tagiUserDetails($id);
                                $checkGiftCard=$this->Mod_home->checkGiftCardData($id,$gc['id']);
                                if(empty($checkGiftCard))
                                {
                                    if($gc['point_range_to'] <= $totalPoint)
                                    {
                                        $insertGiftCardData=$this->Mod_home->addGiftCardUserRecord($id,$gc['id']);
                                        $deviceType=$userDetails['devicetype'];
                                        $firebasetoken=$userDetails['devicetoken'];
                                        $message=$gc['push_notification'];
                                        $date= date("Y-m-d H:i:s");
                                        if($insertGiftCardData)
                                        {
                                            if($deviceType == 'Android') 
                                            {
                                                $message1 = array('body' => $message,'title' => $message);
                                                $field=array("message" => $message,"id" => $id,"date"=>$date);
                                                
                                                $fields = array('to'=> $firebasetoken,
                                                                'notification'=> $field,
                                                                "delay_while_idle"=> false ,
                                                                "content_available"=>true,
                                                                "priority"=>"high",
                                                                'data' => $field           
                                                                );
                                                $headers = array
                                                (
                                                    'Authorization: key=' . SERVER_KEY,
                                                    'Content-Type: application/json'
                                                );
                                                $ch = curl_init();
                                                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                                                curl_setopt( $ch,CURLOPT_POST, true );
                                                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                                                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                                                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                                                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );
                                                $results=curl_exec($ch );           
                                                $resultsArray=json_decode($results);
                                                //print_r($resultsArray);
                                                 $success=$resultsArray->success;
                                            }
                                            else{
                                                $notification=array("title" => $message,"id" => $user_id,"date"=>$date,'sound' => 'default', 'badge' => '1'); 
                                                $arrayToSend = array('to' => $firebasetoken, 'notification' => $notification,'priority'=>'high');
                                                $json = json_encode($arrayToSend);
                                                $headers = array();
                                                $headers[] = 'Content-Type: application/json';
                                                $headers[] = 'Authorization: key=' . SERVER_KEY;
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL,'https://fcm.googleapis.com/fcm/send');
                                
                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                                                $results=curl_exec($ch);
                                                $resultsArray=json_decode($results);
                                                //print_r($resultsArray);
                                                $success=$resultsArray->success;
                                                curl_close($ch);
                                            }
                                        }
                                    }
                                }
                            }
                            $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                            $medicalDetails=$this->Mod_home->medicalStatus($id);
                            $data=$this->Mod_home->userTagiDetails($id);
                            if($data)
                            {
                                $udata=$this->Mod_home->userTagiDetails($user_id);
                                $default_public_status=$data["default_public_status"];
                                $default_private_status=$data["default_private_status"];
                                $default_business_status=$data["default_business_status"];
                                
                                $user_default_public_status=$udata["default_public_status"];
                                $user_default_private_status=$udata["default_private_status"];
                                $user_default_business_status=$udata["default_business_status"];
                                
                                if($user_default_public_status == 1)
                                {
                                    $user_type="Public";
                                }
                                if($user_default_private_status == 1)
                                {
                                    $user_type="Private";
                                }
                                if($user_default_business_status == 1)
                                {
                                    $user_type="Business";
                                }
                                if($default_public_status == 1)
                                {
                                    $type="Public";
                                    $publicData=$this->Mod_home->tagiDataList($id,$type);
                                    $direct_status=$publicData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$publicData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$publicData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$publicData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$publicData["type"];
                                    $user_data["profile_image"]=$publicData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                                }
                                if($default_private_status == 1)
                                {
                                    $type="Private";
                                    $privateData=$this->Mod_home->privateTagiList($id,$type);
                                    $direct_status=$privateData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$privateData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$privateData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$privateData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$privateData["type"];
                                    $user_data["profile_image"]=$privateData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                                }
                                if($default_business_status == 1)
                                {
                                    $type="Business";
                                    $businessData=$this->Mod_home->businessTagiList($id,$type);
                                    $direct_status=$businessData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$businessData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$businessData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$businessData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$businessData["type"];
                                    $user_data["profile_image"]=$businessData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                                }
                                if($user_data)
                                {
                                    $userData=$this->Mod_home->getUserProfile($id);
                                    unset($userData['password']);
                                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                    echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                                }
                                else
                                {
                                    $message=$this->language_messages('error_something_wrong');
                                    echo json_encode(array("status"=>"400","message"=>$message));
                                }
                            }
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $points=1;
                      /*  $add_points=$this->Mod_home->addLogPoints($user_id,$points);
                        if($add_points)
                        {
                            echo json_encode(array("status"=>"200","message"=>"Add tagi successfully"));
                        }
                        else
                        {
                            echo json_encode(array("status"=>"400","message"=>"Something is wrong please try again"));
                        }*/
                        $add_points=$this->Mod_home->addLogPoints($id,$points);
                        $totalPoints=$this->Mod_home->userTotalPoints($id);
                        if(!empty($totalPoints["points"]))
                        {
                            $totalPoint=$totalPoints["points"];
                        }
                        else
                        {
                            $totalPoint="0";
                        }
                        $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                        $medicalDetails=$this->Mod_home->medicalStatus($id);
                        $data=$this->Mod_home->userTagiDetails($id);
                        if($data)
                        {
                            $udata=$this->Mod_home->userTagiDetails($user_id);
                            $default_public_status=$data["default_public_status"];
                            $default_private_status=$data["default_private_status"];
                            $default_business_status=$data["default_business_status"];
                            
                            $user_default_public_status=$udata["default_public_status"];
                            $user_default_private_status=$udata["default_private_status"];
                            $user_default_business_status=$udata["default_business_status"];
                            
                            if($user_default_public_status == 1)
                            {
                                $user_type="Public";
                            }
                            if($user_default_private_status == 1)
                            {
                                $user_type="Private";
                            }
                            if($user_default_business_status == 1)
                            {
                                $user_type="Business";
                            }
                            if($default_public_status == 1)
                            {
                                $type="Public";
                                $publicData=$this->Mod_home->tagiDataList($id,$type);
                                $direct_status=$publicData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$publicData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$publicData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$publicData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$publicData["type"];
                                $user_data["profile_image"]=$publicData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                            }
                            if($default_private_status == 1)
                            {
                                $type="Private";
                                $privateData=$this->Mod_home->privateTagiList($id,$type);
                                $direct_status=$privateData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$privateData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$privateData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$privateData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$privateData["type"];
                                $user_data["profile_image"]=$privateData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                            }
                            if($default_business_status == 1)
                            {
                                $type="Business";
                                $businessData=$this->Mod_home->businessTagiList($id,$type);
                                $direct_status=$businessData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$businessData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$businessData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$businessData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$businessData["type"];
                                $user_data["profile_image"]=$businessData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                            }
                            if($user_data)
                            {
                                $userData=$this->Mod_home->getUserProfile($id);
                                unset($userData['password']);
                                $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                            }
                            else
                            {
                                $message=$this->language_messages('error_something_wrong');
                                echo json_encode(array("status"=>"400","message"=>$message));
                            }
                        }
                    }
                }
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
    
    public function userPeopleLog()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $result=$this->Mod_home->userPeopleLog($user_id);
            foreach($result as $res)
            {
               
                if(!empty($res))
                {
                    $profile_id=$res["profile_id"];
                    $totalTagiCount=$this->Mod_home->totalUserTagiCount($profile_id);
                    $medicalDetails=$this->Mod_home->medicalStatus($profile_id);
                    $data=$this->Mod_home->userTagiDetails($profile_id);
                    if($data)
                    {
                        /*$default_public_status=$data["default_public_status"];
                        $default_private_status=$data["default_private_status"];
                        $default_business_status=$data["default_business_status"];*/
                        $type=$res['type'];
                        if($type == "Public")
                        {
                            $type="Public";
                            $publicData=$this->Mod_home->tagiDataList($profile_id,$type);
                            $user_data["id"]=$res["id"];
                            $user_data["user_id"]=$res["profile_id"];
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$publicData["name"];
                            $user_data["log_status"]=$res["status"];
                            $user_data["direct_status"]=$res["direct_status"];
                            $user_data["type"]=$type;
                            $user_data["profile_image"]=$publicData["image"];
                            $user_data["date"]=$res["created_date"];
                            
                        }
                        if($type == "Private")
                        {
                            $type="Private";
                            $privateData=$this->Mod_home->privateTagiList($profile_id,$type);
                            $user_data["id"]=$res["id"];
                            $user_data["user_id"]=$res["profile_id"];
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$privateData["name"];
                            $user_data["log_status"]=$res["status"];
                            $user_data["direct_status"]=$res["direct_status"];
                            $user_data["type"]=$type;
                            $user_data["profile_image"]=$privateData["image"];
                            $user_data["date"]=$res["created_date"];
                        }
                        if($type == "Business")
                        {
                            $type="Business";
                            $businessData=$this->Mod_home->businessTagiList($profile_id,$type);
                            $user_data["id"]=$res["id"];
                            $user_data["user_id"]=$res["profile_id"];
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$businessData["name"];
                            $user_data["log_status"]=$res["status"];
                            $user_data["direct_status"]=$res["direct_status"];
                            $user_data["type"]=$type;
                            $user_data["profile_image"]=$businessData["image"];
                            $user_data["date"]=$res["created_date"];
                        }
                        
                    }
                    $data2[]=$user_data;
                    
                }
            }
            $maindata=$data2;
            if($maindata)
            {
                echo json_encode(array("status"=>"200","message"=>"Tagi List","data"=>$maindata));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function addLink()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            //$tagi_id=$_POST["tagi_id"];
            $type=$_POST["type"];
            $link=$_POST["link"];
            $category=$_POST['category'];  
            $linkCheck=$this->Mod_home->linkCheck($user_id,$type,$category);
            if($linkCheck)
            {
                $message=$this->language_messages('error_already_exist');
                echo json_encode(array("status"=>"400","message"=>$message));
                die;
            }
            else
            {
                if(!empty($_FILES["image"]))
                {
                    /*$type=$_POST["type"];
                    $link=$_POST["link"];*/
                    if(strpos($link, "http://") !== false || strpos($link, "https://") !== false)
                    {
                        $profileUrl=$link;
                    }
                    else
                    {
                        $getProfileUrl=$this->Mod_home->getProfileUrl($type);
                        $profileUrl=$getProfileUrl['base_url'].$link;
                    }
                    $link2=@$_POST["link2"];
                    $category=$_POST["category"];
                    $tagiOrder=$this->Mod_home->tagiOrderCount($user_id,$category);
                    $Images=$_FILES["image"]["name"];
                    $data=array(
                            "type"=>$type,
                            "link"=>$link,
                            "profile_url"=>$profileUrl,
                            "link2"=>$link2,
                            "user_id"=>$user_id,
                            "category"=>$category,
                            "image"=>$Images,
                            "row_order"=>$tagiOrder
                        );
                    $temp_pictures=$_FILES['image']['tmp_name']; 
                    $Images = $_FILES['image']['name']; 
                    $sourcePath = $_FILES['image']['tmp_name'];  
                    $targetPath = "linkImages/".$Images;  
                    if(move_uploaded_file($sourcePath, $targetPath)) 
                    {
                        $result=$this->Mod_home->addLink($data);
                        if($result)
                        {
                            $getLink=$this->Mod_home->getLastLink($result);
                            $data["id"]=$getLink["id"];
                            $data["user_id"]=$getLink["user_id"];
                            $data["type"]=$getLink["type"];
                            $data["link"]=$getLink["link"];
                            $data["link2"]=$getLink["link2"];
                            $data["image"]=$getLink["image"];
                            $data["category"]=$getLink["category"];
                            $data["created_date"]=$getLink["created_date"];
                            $type=$getLink["type"];
                            /*$icon=$this->Mod_home->socialIcon($type);
                            $data["icon"]=$icon["image"];*/
                            $message=$this->language_messages('link_added_successfully');
                            echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data));
                        }
                    }
                }
                else
                {
                    $type=$_POST["type"];
                    $link=$_POST["link"];
                    if(strpos($link, "http://") !== false || strpos($link, "https://") !== false)
                    {
                        $profileUrl=$link;
                    }
                    else
                    {
                        $getProfileUrl=$this->Mod_home->getProfileUrl($type);
                        $profileUrl=$getProfileUrl['base_url'].$link;
                    }
                    $link2=@$_POST["link2"];
                    $category=$_POST["category"];
                    $tagiOrder=$this->Mod_home->tagiOrderCount($user_id,$category);
                    $data=array(
                            "type"=>$type,
                            "link"=>$link,
                            "profile_url"=>$profileUrl,
                            "link2"=>$link2,
                            "user_id"=>$user_id,
                            "category"=>$category,
                            "row_order"=>$tagiOrder
                        );
                    $result=$this->Mod_home->addLink($data);
                    if($result)
                    {
                        $getLink=$this->Mod_home->getLastLink($result);
                        $data["id"]=$getLink["id"];
                        $data["user_id"]=$getLink["user_id"];
                        $data["type"]=$getLink["type"];
                        $data["link"]=$getLink["link"];
                        $data["link2"]=$getLink["link2"];
                        $data["image"]=$getLink["image"];
                        $data["category"]=$getLink["category"];
                        $data["created_date"]=$getLink["created_date"];
                        $type=$getLink["type"];
                        /*$icon=$this->Mod_home->socialIcon($type);
                        $data["icon"]=$icon["image"];*/
                        $message=$this->language_messages('link_added_successfully');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function editLink()
    {
        $id=$_POST["id"];
        $link=$_POST["link"];
        $link2=$_POST["link2"];
        if(strpos($link, "http://") !== false || strpos($link, "https://") !== false)
        {
            $profileUrl=$link;
        }
        else
        {
            $getLinkType=$this->Mod_home->getLinkType($id);
            $type=$getLinkType["type"];
            $getProfileUrl=$this->Mod_home->getProfileUrl($type);
            $profileUrl=$getProfileUrl['base_url'].$link;
        }
        $data=array(
                "link"=>$link,
                "link2"=>$link2,
                "profile_url"=>$profileUrl
            );
        $result=$this->Mod_home->editLink($id,$data);
        if($result)
        {
            $getLink=$this->Mod_home->getEditLink($id);
            $data["id"]=$getLink["id"];
            $data["user_id"]=$getLink["user_id"];
            $data["type"]=$getLink["type"];
            $data["link"]=$getLink["link"];
            $data["category"]=$getLink["category"];
            $data["created_date"]=$getLink["created_date"];
            $type=$getLink["type"];
            /*$icon=$this->Mod_home->socialIcon($type);
            $data["icon"]=$icon["image"];*/
            $message=$this->language_messages('link_added_successfully');
            echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
        
    }
    public function tagiDetails()
    {
        $uid=$_POST["tagi_id"];
        $result=$this->Mod_home->tagiDetails($uid);
 
        if($result)
        {
            $user_id=$result["user_id"];
            $data=$this->Mod_home->tagiUserDetails($user_id);
            if($data)
            {
                $first_name=$data["first_name"];
                $last_name=$data["last_name"];
                $devicetype=$data["devicetype"];
                $name=$first_name.$lats_name;
                $id=base64_encode($user_id);
                $url=base_url()."profile/$name/$id";
                
                ?>
                <script>
                    window.location.href="<?php echo $url; ?>";
                </script>
                <?php
                if($devicetype == "Android")
                {
                    ?>
                    <script>
                    function changeLink(applink,) 
                    {
                        window.location.href=applink;
                    }
                    
                    changeLink("tagi://details?user_id=+<?php echo $id;?>+");
                	setInterval(function () {
                              window.location.replace("<?php echo $url; ?>");
                      }, 2000);
                    </script>
                    <?php
                }
                else
                {
                    ?>
                    <script>
                    function changeLink(applink,) 
                    {
                        window.location.href=applink;
                    }
                     changeLink("tagi://controlpanel.tagmoi.co//tagi?user_id=<?php echo $id;?>");
                	setInterval(function () {
                              window.location.replace("<?php echo $url; ?>");
                      }, 6000);
                    </script>
                    <?php
                }
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_tagmoi');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function forgotPassword()
    {
        $email=$_POST["email"];
        $email_check=$this->Mod_home->checkforgotPasswordEmail($email);
        if($email_check)
        {
            $code=rand("999999","100000");
            $language=$_POST['language'];
            $user_id=$email_check['id'];
            $name=$email_check['first_name']." ".$email_check['last_name'];
            if($language == 'en')
            {
                $type="Change Password";
                $body="We received a request to reset your TagMoi password.";
                $this->sendChangePasswordMail($email,$type,$name,$code,$body);
            }
            elseif($language == 'ar')
            {
                $body=".لقد تلقينا طلبًا لإعادة تعيين كلمة مرور تاغ موا الخاصة بك";
                $type="تغير الرقم السري";
                $this->sendArabicChangePasswordMail($email,$type,$name,$code,$body);
            }
            $this->Mod_home->updateForgotPasswordOtp($user_id,$code);
            $userData=$this->Mod_home->getUserProfile($user_id);
            unset($userData['password']);
            $token=JWT::encode($userData, $this->config->item('jwt_key'));
            $message=$this->language_messages('password_reset_message');
            echo json_encode(array("status"=>"200","message"=>$message,"token"=>$token));
        }
        else
        {
            $message=$this->language_messages('error_register_email');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function resetPassword($email)
    {
        $email= base64_decode($email);
        $emailData=$this->Mod_home->checkforgotPasswordEmail($email);
        if($emailData)
        {
            $devicetype=$emailData["devicetype"];
            if($devicetype == "Android")
            {
                ?>
                <script>
                function changeLink(applink,) 
                {
                    window.location.href=applink;
                }
                
                changeLink("tagi://details?email_id=+<?php echo $email;?>+");
            	setInterval(function () {
                          window.location.replace("http://play.google.com/store/apps/details?id=com.tagi");
                  }, 2000);
                </script>
                <?php
            }
            else
            {
                ?>
                <script>
                function changeLink(applink,) 
                {
                    window.location.href=applink;
                }
                 changeLink("tagi://controlpanel.tagmoi.co//tagi?email_id=<?php echo $email;?>");
            	setInterval(function () {
                          window.location.replace("https://apps.apple.com/us/app/tagi");
                  }, 6000);
                </script>
                <?php
            }
        }
        else
        {
            $message=$this->language_messages('error_valid_email');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    
    public function updateResetPassword()
    {
        $email=$_POST["email"];
        $password=md5($_POST["password"]);
        $confirm_password=md5($_POST["confirm_password"]);
        if($password == $confirm_password)
        {
            $result=$this->Mod_home->updateResetPassword($email,$password);
            if($result)
            {
                $message=$this->language_messages('password_updated');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));   
            }
        }
        else
        {
            $message=$this->language_messages('error_password_match');
            echo json_encode(array("status"=>"400","message"=>"Password and confirm password doesn't match"));
        }
    }
    public function getSocialLink()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode= JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecode->id;
            $category=$_POST["category"];
            $result=$this->Mod_home->getSocialLink($user_id,$category);
        
            if($result)
            {
                foreach($result as $rt)
                {
                    $data["id"]=$rt["id"];
                    $data["user_id"]=$rt["user_id"];
                    $data["type"]=$rt["type"];
                    $data["link"]=$rt["link"];
                    $data["category"]=$rt["category"];
                    $data["order"]=$rt["row_order"];
                    $data["created_date"]=$rt["created_date"];
                    /*$type=$rt["type"];
                    $icon=$this->Mod_home->socialIcon($type);
                    $data["icon"]=$icon["image"];*/
                    $maindt[]=$data;
                }
                $main=$maindt;
                echo json_encode(array("status"=>"200","message"=>"Social Links","data"=>$main));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function deleteSocialLink()
    {
        $id=$_POST["id"];
        $result=$this->Mod_home->deleteSocialLink($id);
        if($result)
        {
            $message=$this->language_messages('delete_successfully');
            echo json_encode(array("status"=>"200","message"=>$message));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function renameTagi()
    {
        $id=$_POST["id"];
        $name=$_POST["name"];
        $result=$this->Mod_home->renameTagi($id,$name);
        if($result)
        {
            $message=$this->language_messages('updated_successfully');
            echo json_encode(array("status"=>"200","message"=>"Updated successfully"));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function defaultProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecoded->id;
            $category=$_POST["category"];
            $status=$_POST["status"];
            if($status == 0)
            {
                $defultProfileStatusCheck=$this->Mod_home->defultProfileStatusCheck($user_id);
                
                if($category == "Public")
                {
                    if($defultProfileStatusCheck["default_private_status"] == 0 && $defultProfileStatusCheck["default_business_status"] == 0 )
                    {
                        $message=$this->language_messages('error_default_category');
                        echo json_encode(array("status"=>"201","message"=>$message));
                        die;
                    }
                }
                if($category == "Private")
                {
                    if($defultProfileStatusCheck["default_public_status"] == 0 && $defultProfileStatusCheck["default_business_status"] == 0 )
                    {
                        $message=$this->language_messages('error_default_category');
                        echo json_encode(array("status"=>"201","message"=>$message));
                        die;
                    }
                }
                if($category == "Business")
                {
                    if($defultProfileStatusCheck["default_public_status"] == 0 && $defultProfileStatusCheck["default_private_status"] == 0 )
                    {
                        $message=$this->language_messages('error_default_category');
                        echo json_encode(array("status"=>"201","message"=>$message));
                        die;
                    }
                }
                
            }
            else
            {
                if($category == "Public")
                {
                    $data=array(
                        "default_public_status"=>1,
                        "default_private_status"=>0,
                        "default_business_status"=>0
                    );    
                }
                if($category == "Private")
                {
                    $data=array(
                            "default_public_status"=>0,
                            "default_private_status"=>1,
                            "default_business_status"=>0
                    );
                }
                if($category == "Business")
                {
                    $data=array(
                        "default_public_status"=>0,
                        "default_private_status"=>0,
                        "default_business_status"=>1
                    );
                }
                $result=$this->Mod_home->defaultProfile($user_id,$data);
                if($result)
                {
                    $message=$this->language_messages('profile_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    
    public function directStatus()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token, $this->config->item('jwt_key'), array('HS256'));
            $user_id=$tokenDecoded->id;
            $type=$_POST["type"];
            $status=$_POST["status"];
            
            $result=$this->Mod_home->directStatus($user_id,$type,$status);
            $public_status=$this->Mod_home->getPublicStatus($user_id);
            $public_direct_status=$public_status['direct_status'];
            $business_status=$this->Mod_home->getBusinessStatus($user_id);
            $business_direct_status=$business_status['direct_status'];
            $private_status=$this->Mod_home->getPrivateStatus($user_id);
            $private_direct_status=$private_status['direct_status'];
            $data=array(
                "public_status"=>$public_direct_status,
                "business_status"=>$business_direct_status,
                "private_status"=>$private_direct_status
            );
            if($result)
            {
                $message=$this->language_messages('profile_updated');
                echo json_encode(array("status"=>"200","message"=>$message,"data"=>$data));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function addTagiType()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $tagi_id=$_POST["tagi_id"];
            $type=$_POST["type"];
            $result=$this->Mod_home->addTagiType($tagi_id,$type);
            if($result)
            {
                $message=$this->language_messages('tagmoi_added_successfully');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userPublicProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode=JWT::decode($token,$this->config->item('jwt_key'),array("HS256"));
            $user_id=$tokenDecode->id;
            $type="Public";
            $medicalDetails=$this->Mod_home->medicalStatus($user_id);
            $userDetails=$this->Mod_home->userTagiDetails($user_id);
            $result=$this->Mod_home->tagiDataList($user_id,$type);
            if($result)
            {
                $data["id"]=$result["id"];
                $data["user_id"]=$result["user_id"];
                $data["name"]=$result["name"];
                $data["image"]=$result["image"];
                $data["description"]=$result["description"];
                $data["profile_url"]=$result["profile_url"];
                $data["type"]=$result["type"];
                $data["status"]=$result["status"];
                $data["direct_status"]=$result["direct_status"];
                $data["medical_status"]=$userDetails["medical_status"];
                $data["user_medical_status"]=$medicalDetails["profile_status"];
                $data["links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);
                echo json_encode(array("status"=>"200","message"=>"TagMoi data","data"=>$data));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userBusinessProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $type="Business";
            $medicalDetails=$this->Mod_home->medicalStatus($user_id);
            $userDetails=$this->Mod_home->userTagiDetails($user_id);
            $result=$this->Mod_home->businessTagiList($user_id,$type);
            if($result)
            {
                $data["id"]=$result["id"];
                $data["user_id"]=$result["user_id"];
                $data["name"]=$result["name"];
                $data["image"]=$result["image"];
                $data["description"]=$result["description"];
                $data["profile_url"]=$result["profile_url"];
                $data["type"]=$result["type"];
                $data["status"]=$result["status"];
                $data["direct_status"]=$result["direct_status"];
                $data["medical_status"]=$userDetails["medical_status"];
                $data["user_medical_status"]=$medicalDetails["profile_status"];
                $data["links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);
                echo json_encode(array("status"=>"200","message"=>"TagMoi data","data"=>$data));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userPrivateProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode=JWT::decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $type="Private";
            $medicalDetails=$this->Mod_home->medicalStatus($user_id);
            $userDetails=$this->Mod_home->userTagiDetails($user_id);
            $result=$this->Mod_home->privateTagiList($user_id,$type);
            if($result)
            {
                $data["id"]=$result["id"];
                $data["user_id"]=$result["user_id"];
                $data["name"]=$result["name"];
                $data["image"]=$result["image"];
                $data["description"]=$result["description"];
                $data["profile_url"]=$result["profile_url"];
                $data["type"]=$result["type"];
                $data["status"]=$result["status"];
                $data["direct_status"]=$result["direct_status"];
                $data["medical_status"]=$userDetails["medical_status"];
                $data["user_medical_status"]=$medicalDetails["profile_status"];
                $data["links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);
                echo json_encode(array("status"=>"200","message"=>"Tagi data","data"=>$data));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userTagiDetails()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode=JWT::decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $tagi_id=$_POST["tagi_id"];
            $result=$this->Mod_home->userTagiDetails($user_id);
            if($result)
            {
                /*$tagi=$this->Mod_home->tagiID($tagi_id);
                $tagiid=$tagi['id'];*/
                $links["social_links"]=$this->Mod_home->tagiSocialLinks($user_id);
                if($links)
                {
                    $data=array_merge($result,$links);
                }
                else
                {
                    $data=$result;
                }
                echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$data));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function getTagiUserDetails()
    {
        $tagi_id=base64_decode($_POST["tagi_id"]);
        $result=$this->Mod_home->getTagiData($tagi_id);
        if($result)
        {
            $user_id=$result["user_id"];
            $totalTagiCount=$this->Mod_home->totalUserTagiCount($user_id);
            $medicalDetails=$this->Mod_home->medicalStatus($user_id);
            $data=$this->Mod_home->userTagiDetails($user_id);
            if($data)
            {
                $default_public_status=$data["default_public_status"];
                $default_private_status=$data["default_private_status"];
                $default_business_status=$data["default_business_status"];
                if($default_public_status == 1)
                {
                    $type="Public";
                    $publicData=$this->Mod_home->tagiDataList($user_id,$type);
                    $user_data["first_name"]=$data["first_name"];
                    $user_data["last_name"]=$data["last_name"];
                    $user_data["user_name"]=$publicData["name"];
                    $user_data["email"]=$data["email"];
                    $user_data["description"]=$publicData["description"];
                    $user_data["status"]=$result["status"];
                    $user_data["direct_status"]=$publicData["direct_status"];
                    $user_data["medical_status"]=$data["medical_status"];
                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                    $user_data["type"]=$publicData["type"];
                    $user_data["profile_image"]=$publicData["image"];
                    $user_data["profile_status"]=$data["profile_status"];
                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                    $user_data["total_tagi"]=$totalTagiCount;
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);    
                }
                if($default_private_status == 1)
                {
                    $type="Private";
                    $privateData=$this->Mod_home->privateTagiList($user_id,$type);
                    $user_data["first_name"]=$data["first_name"];
                    $user_data["last_name"]=$data["last_name"];
                    $user_data["user_name"]=$privateData["name"];
                    $user_data["email"]=$data["email"];
                    $user_data["description"]=$privateData["description"];
                    $user_data["status"]=$result["status"];
                    $user_data["direct_status"]=$privateData["direct_status"];
                    $user_data["medical_status"]=$data["medical_status"];
                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                    $user_data["type"]=$privateData["type"];
                    $user_data["profile_image"]=$privateData["image"];
                    $user_data["profile_status"]=$data["profile_status"];
                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                    $user_data["total_tagi"]=$totalTagiCount;
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);
                }
                if($default_business_status == 1)
                {
                    $type="Business";
                    $businessData=$this->Mod_home->businessTagiList($user_id,$type);
                    $user_data["first_name"]=$data["first_name"];
                    $user_data["last_name"]=$data["last_name"];
                    $user_data["user_name"]=$businessData["name"];
                    $user_data["email"]=$data["email"];
                    $user_data["description"]=$businessData["description"];
                    $user_data["status"]=$result["status"];
                    $user_data["direct_status"]=$businessData["direct_status"];
                    $user_data["medical_status"]=$data["medical_status"];
                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                    $user_data["type"]=$businessData["type"];
                    $user_data["profile_image"]=$businessData["image"];
                    $user_data["profile_status"]=$data["profile_status"];
                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                    $user_data["total_tagi"]=$totalTagiCount;
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($user_id,$type);
                }
                if($user_data)
                {
                    $userData=$this->Mod_home->getUserProfile($user_id);
                    unset($userData['password']);
                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                    echo json_encode(array("status"=>"200","message"=>"Tagi details","data"=>$user_data,"token"=>$token));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function editTypeProfile()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $id=$_POST["id"];
            $type=$_POST["type"];
            $name=$_POST["name"];
            $status=$_POST["status"];
            $description=$_POST["description"];
            $url=$_POST["profile_url"];
            
            if($type == "Public")
            {
                if(!empty($_FILES["profile_image"]["name"]))
                {
                    $pictures=$_FILES['profile_image']['name'];
                    $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                    $profileImages = $_FILES['profile_image']['name']; 
                    $sourcePath = $_FILES['profile_image']['tmp_name'];  
                    $targetPath = "profileImages/".$profileImages;  
                    if(move_uploaded_file($sourcePath, $targetPath)) 
                    {
                        $data=array(
                                "name"=>$name,
                                "image"=>$profileImages,
                                "description"=>$description,
                                "profile_url"=>$url,
                                "status"=>$status
                            );
                        $userData=array(
                            "profile_image"=>$profileImages,
                            "user_name"=>$name,
                            "description"=>$description
                        );
                        $result=$this->Mod_home->updateTypeProfile($id,$data);
                        if($result)
                        {
                            $this->Mod_home->editProfile($user_id,$userData);
                            $typeProfileData=$this->Mod_home->typeProfileData($user_id,$type);
                            echo json_encode(array("status"=>"200","message"=>"Profile update successfully","data"=>$typeProfileData));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
                else
                {
                    $data=array(
                                "name"=>$name,
                                "description"=>$description,
                                "profile_url"=>$url,
                                "status"=>$status
                            );
                     $userData=array(
                            "user_name"=>$name,
                            "description"=>$description
                        );
                    $result=$this->Mod_home->updateTypeProfile($id,$data);
                    if($result)
                    {
                        $this->Mod_home->editProfile($user_id,$userData);
                        $typeProfileData=$this->Mod_home->typeProfileData($user_id,$type);
                        $message=$this->language_messages('profile_updated');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$typeProfileData));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
            else
            {
                if(!empty($_FILES["profile_image"]["name"]))
                {
                    $pictures=$_FILES['profile_image']['name'];
                    $temp_pictures=$_FILES['profile_image']['tmp_name']; 
                    $profileImages = $_FILES['profile_image']['name']; 
                    $sourcePath = $_FILES['profile_image']['tmp_name'];  
                    $targetPath = "profileImages/".$profileImages;  
                    if(move_uploaded_file($sourcePath, $targetPath)) 
                    {
                        $data=array(
                                "name"=>$name,
                                "image"=>$profileImages,
                                "description"=>$description,
                                "profile_url"=>$url,
                                "status"=>$status
                            );
                        $result=$this->Mod_home->updateTypeProfile($id,$data);
                        if($result)
                        {
                            $typeProfileData=$this->Mod_home->typeProfileData($user_id,$type);
                            $message=$this->language_messages('profile_updated');
                            echo json_encode(array("status"=>"200","message"=>$message,"data"=>$typeProfileData));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
                else
                {
                    $data=array(
                                "name"=>$name,
                                "description"=>$description,
                                "profile_url"=>$url,
                                "status"=>$status
                            );
                    $result=$this->Mod_home->updateTypeProfile($id,$data);
                    if($result)
                    {
                        $typeProfileData=$this->Mod_home->typeProfileData($user_id,$type);
                        $message=$this->language_messages('profile_updated');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$typeProfileData));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
        
    }
    public function homeProfileStatus()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $profileStatus=$_POST["profile_status"];
            $result=$this->Mod_home->homeProfileStatus($user_id,$profileStatus);
            if($result)
            {
                $message=$this->language_messages('profile_updated');
                echo json_encode(array("status"=>"200","message"=>$message,"data"=>$profileStatus));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function socialLinkOrder()
    {
        
        $id=$_POST["id"];
        
        foreach($id as $key => $value)
        {
            $user_id=$value;
            $order=$key;
            $res[]=$this->Mod_home->socailLinkOrder($user_id,$order);
        }
        if($res)
        {
            $message=$this->language_messages('updated_successfully');
            echo json_encode(array("status"=>"200","message"=>$message));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function getPeopleUserDetail()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokendecoded=JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokendecoded->id;
            /*$id=$_POST["id"];*/
            $profile_id=$_POST["id"];
            $idd=base64_decode($profile_id);
            $date=date('Y-m-d h:i:s');
            $result=$this->Mod_home->tagiUserId($idd);
            $id=$result["user_id"];
            if($user_id == $id)
            {
                $totalPoints=$this->Mod_home->userTotalPoints($id);
                if(!empty($totalPoints["points"]))
                {
                    $totalPoint=$totalPoints["points"];
                }
                else
                {
                    $totalPoint="0";
                }
                $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                $medicalDetails=$this->Mod_home->medicalStatus($id);
                $data=$this->Mod_home->userTagiDetails($id);
                if($data)
                {
                    $default_public_status=$data["default_public_status"];
                    $default_private_status=$data["default_private_status"];
                    $default_business_status=$data["default_business_status"];
                    if($default_public_status == 1)
                    {
                        $type="Public";
                        $publicData=$this->Mod_home->tagiDataList($id,$type);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$publicData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$publicData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$publicData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$publicData["type"];
                        $user_data["profile_image"]=$publicData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                    }
                    if($default_private_status == 1)
                    {
                        $type="Private";
                        $privateData=$this->Mod_home->privateTagiList($id,$type);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$privateData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$privateData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$privateData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$privateData["type"];
                        $user_data["profile_image"]=$privateData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                    }
                    if($default_business_status == 1)
                    {
                        $type="Business";
                        $businessData=$this->Mod_home->businessTagiList($id,$type);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$businessData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$businessData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$businessData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$businessData["type"];
                        $user_data["profile_image"]=$businessData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                    }
                    $userData=$this->Mod_home->getUserProfile($id);
                    unset($userData['password']);
                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                    echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                }
            }
            else
            {
                $resultCheck=$this->Mod_home->peopleLogCheck($user_id,$id);
                if($resultCheck)
                {
                    $totalPoints=$this->Mod_home->userTotalPoints($id);
                    if(!empty($totalPoints["points"]))
                    {
                        $totalPoint=$totalPoints["points"];
                    }
                    else
                    {
                        $totalPoint="0";
                    }
                    $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                    $medicalDetails=$this->Mod_home->medicalStatus($id);
                    $data=$this->Mod_home->userTagiDetails($id);
                    if($data)
                    {
                        $udata=$this->Mod_home->userTagiDetails($user_id);
                        $default_public_status=$data["default_public_status"];
                        $default_private_status=$data["default_private_status"];
                        $default_business_status=$data["default_business_status"];
                        
                        $user_default_public_status=$udata["default_public_status"];
                        $user_default_private_status=$udata["default_private_status"];
                        $user_default_business_status=$udata["default_business_status"];
                        
                        if($user_default_public_status == 1)
                        {
                           $user_type="Public";
                        }
                        if($user_default_private_status == 1)
                        {
                           $user_type="Private";
                        }
                        if($user_default_business_status == 1)
                        {
                            $user_type="Business";
                        }
                        if($default_public_status == 1)
                        {
                            $type="Public";
                            $publicData=$this->Mod_home->tagiDataList($id,$type);
                            $direct_status=$publicData["direct_status"];
                            $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                            $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                            
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$publicData["name"];
                            $user_data["email"]=$data["email"];
                            $user_data["description"]=$publicData["description"];
                            $user_data["status"]=$result["status"];
                            $user_data["direct_status"]=$publicData["direct_status"];
                            $user_data["medical_status"]=$data["medical_status"];
                            $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                            $user_data["type"]=$publicData["type"];
                            $user_data["profile_image"]=$publicData["image"];
                            $user_data["profile_status"]=$data["profile_status"];
                            $user_data["phone_number"]=$medicalDetails["mobile_number"];
                            $user_data["total_tagi"]=$totalTagiCount;
                            $user_data["points"]=$totalPoint;
                            $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                        }
                        if($default_private_status == 1)
                        {
                            $type="Private";
                            $privateData=$this->Mod_home->privateTagiList($id,$type);
                            $direct_status=$privateData["direct_status"];
                            $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                            $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                            
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$privateData["name"];
                            $user_data["email"]=$data["email"];
                            $user_data["description"]=$privateData["description"];
                            $user_data["status"]=$result["status"];
                            $user_data["direct_status"]=$privateData["direct_status"];
                            $user_data["medical_status"]=$data["medical_status"];
                            $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                            $user_data["type"]=$privateData["type"];
                            $user_data["profile_image"]=$privateData["image"];
                            $user_data["profile_status"]=$data["profile_status"];
                            $user_data["phone_number"]=$medicalDetails["mobile_number"];
                            $user_data["total_tagi"]=$totalTagiCount;
                            $user_data["points"]=$totalPoint;
                            $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                        }
                        if($default_business_status == 1)
                        {
                            $type="Business";
                            $businessData=$this->Mod_home->businessTagiList($id,$type);
                            $direct_status=$businessData["direct_status"];
                            $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                            $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                            
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$businessData["name"];
                            $user_data["email"]=$data["email"];
                            $user_data["description"]=$businessData["description"];
                            $user_data["status"]=$result["status"];
                            $user_data["direct_status"]=$businessData["direct_status"];
                            $user_data["medical_status"]=$data["medical_status"];
                            $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                            $user_data["type"]=$businessData["type"];
                            $user_data["profile_image"]=$businessData["image"];
                            $user_data["profile_status"]=$data["profile_status"];
                            $user_data["phone_number"]=$medicalDetails["mobile_number"];
                            $user_data["total_tagi"]=$totalTagiCount;
                            $user_data["points"]=$totalPoint;
                            $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                        }
                        if($user_data)
                        {
                            $userData=$this->Mod_home->getUserProfile($id);
                            unset($userData['password']);
                            $token=JWT::encode($userData, $this->config->item('jwt_key'));
                            echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                            
                        }
                    }
                    
                }
                else
                {
                    $log_data=$this->Mod_home->logPointData($id);
                    if($log_data)
                    {
                        $points=$log_data["points"];
                        $addpoint=$points+1;
                        $update_points=$this->Mod_home->updateLogPoints($id,$addpoint);
                        if($update_points)
                        {
                            $totalPoints=$this->Mod_home->userTotalPoints($id);
                            if(!empty($totalPoints["points"]))
                            {
                                $totalPoint=$totalPoints["points"];
                            }
                            else
                            {
                                $totalPoint="0";
                            }
                            $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                            $medicalDetails=$this->Mod_home->medicalStatus($id);
                            $data=$this->Mod_home->userTagiDetails($id);
                            if($data)
                            {
                                $udata=$this->Mod_home->userTagiDetails($user_id);
                                $default_public_status=$data["default_public_status"];
                                $default_private_status=$data["default_private_status"];
                                $default_business_status=$data["default_business_status"];
                                
                                $user_default_public_status=$udata["default_public_status"];
                                $user_default_private_status=$udata["default_private_status"];
                                $user_default_business_status=$udata["default_business_status"];
                                
                                if($user_default_public_status == 1)
                                {
                                   $user_type="Public";
                                }
                                if($user_default_private_status == 1)
                                {
                                   $user_type="Private";
                                }
                                if($user_default_business_status == 1)
                                {
                                    $user_type="Business";
                                }
                                if($default_public_status == 1)
                                {
                                    $type="Public";
                                    $publicData=$this->Mod_home->tagiDataList($id,$type);
                                    $direct_status=$publicData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$publicData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$publicData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$publicData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$publicData["type"];
                                    $user_data["profile_image"]=$publicData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                                }
                                if($default_private_status == 1)
                                {
                                    $type="Private";
                                    $privateData=$this->Mod_home->privateTagiList($id,$type);
                                    $direct_status=$privateData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$privateData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$privateData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$privateData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$privateData["type"];
                                    $user_data["profile_image"]=$privateData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                                }
                                if($default_business_status == 1)
                                {
                                    $type="Business";
                                    $businessData=$this->Mod_home->businessTagiList($id,$type);
                                    $direct_status=$businessData["direct_status"];
                                    $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                    $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                    
                                    $user_data["first_name"]=$data["first_name"];
                                    $user_data["last_name"]=$data["last_name"];
                                    $user_data["user_name"]=$businessData["name"];
                                    $user_data["email"]=$data["email"];
                                    $user_data["description"]=$businessData["description"];
                                    $user_data["status"]=$result["status"];
                                    $user_data["direct_status"]=$businessData["direct_status"];
                                    $user_data["medical_status"]=$data["medical_status"];
                                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                    $user_data["type"]=$businessData["type"];
                                    $user_data["profile_image"]=$businessData["image"];
                                    $user_data["profile_status"]=$data["profile_status"];
                                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                    $user_data["total_tagi"]=$totalTagiCount;
                                    $user_data["points"]=$totalPoint;
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                                }
                                if($user_data)
                                {
                                    $userData=$this->Mod_home->getUserProfile($id);
                                    unset($userData['password']);
                                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                    echo json_encode(array("status"=>"200","message"=>"Tagi details","data"=>$user_data,"token"=>$token));
                                }
                                else
                                {
                                    $message=$this->language_messages('error_something_wrong');
                                    echo json_encode(array("status"=>"400","message"=>$message));
                                }
                            }
                           /* echo json_encode(array("status"=>"200","message"=>"Add tagi successfully"));*/
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $points=1;
                        $add_points=$this->Mod_home->addLogPoints($id,$points);
                        $totalPoints=$this->Mod_home->userTotalPoints($id);
                        if(!empty($totalPoints["points"]))
                        {
                            $totalPoint=$totalPoints["points"];
                        }
                        else
                        {
                            $totalPoint="0";
                        }
                        $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                        $medicalDetails=$this->Mod_home->medicalStatus($id);
                        $data=$this->Mod_home->userTagiDetails($id);
                        if($data)
                        {
                            $udata=$this->Mod_home->userTagiDetails($user_id);
                            $default_public_status=$data["default_public_status"];
                            $default_private_status=$data["default_private_status"];
                            $default_business_status=$data["default_business_status"];
                            
                            $user_default_public_status=$udata["default_public_status"];
                            $user_default_private_status=$udata["default_private_status"];
                            $user_default_business_status=$udata["default_business_status"];
                            
                            if($user_default_public_status == 1)
                            {
                               $user_type="Public";
                            }
                            if($user_default_private_status == 1)
                            {
                               $user_type="Private";
                            }
                            if($user_default_business_status == 1)
                            {
                                $user_type="Business";
                            }
                            if($default_public_status == 1)
                            {
                                $type="Public";
                                $publicData=$this->Mod_home->tagiDataList($id,$type);
                                $direct_status=$publicData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$publicData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$publicData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$publicData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$publicData["type"];
                                $user_data["profile_image"]=$publicData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);    
                            }
                            if($default_private_status == 1)
                            {
                                $type="Private";
                                $privateData=$this->Mod_home->privateTagiList($id,$type);
                                $direct_status=$privateData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$privateData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$privateData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$privateData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$privateData["type"];
                                $user_data["profile_image"]=$privateData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                            }
                            if($default_business_status == 1)
                            {
                                $type="Business";
                                $businessData=$this->Mod_home->businessTagiList($id,$type);
                                $direct_status=$businessData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$businessData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$businessData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$businessData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$businessData["type"];
                                $user_data["profile_image"]=$businessData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinks($id,$type);
                            }
                            if($user_data)
                            {
                                $userData=$this->Mod_home->getUserProfile($id);
                                unset($userData['password']);
                                $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                            }
                            else
                            {
                                $message=$this->language_messages('error_something_wrong');
                                echo json_encode(array("status"=>"400","message"=>$message));
                            }
                        }
                    }
                }
            }
        }
    }
    public function deletePeopleLog()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDeocded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $id=$_POST["id"];
            $result=$this->Mod_home->deletePeopleLog($id);
            if($result)
            {
                $message=$this->language_messages('delete_successfully');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function peopleLogUserDetails()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDeocded->id;
            $profile_id=$_POST["profile_id"];
            $time=$_POST["time"];
            $direct_status=$_POST["direct_status"];
            $totalPoints=$this->Mod_home->userTotalPoints($profile_id);
            if(!empty($totalPoints["points"]))
            {
                $totalPoint=$totalPoints["points"];
            }
            else
            {
                $totalPoint="0";
            }
            $type=$_POST["type"];
            $totalTagiCount=$this->Mod_home->totalUserTagiCount($profile_id);
            $medicalDetails=$this->Mod_home->medicalStatus($profile_id);
            $data=$this->Mod_home->userTagiDetails($profile_id);
            if($type == "Public")
            {
                $publicData=$this->Mod_home->tagiDataList($profile_id,$type);
                $user_data["first_name"]=$data["first_name"];
                $user_data["last_name"]=$data["last_name"];
                $user_data["user_name"]=$publicData["name"];
                $user_data["email"]=$data["email"];
                $user_data["description"]=$publicData["description"];
                $user_data["status"]=$result["status"];
                $user_data["direct_status"]=$direct_status;
                $user_data["medical_status"]=$data["medical_status"];
                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                $user_data["type"]=$publicData["type"];
                $user_data["profile_image"]=$publicData["image"];
                $user_data["profile_status"]=$data["profile_status"];
                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                $user_data["total_tagi"]=$totalTagiCount;
                $user_data["points"]=$totalPoint;
                if($direct_status == 1)
                {
                    $user_data["social_links"]=$this->Mod_home->directtagiSocialLinksByDate($profile_id,$type,$time);
                }
                else
                {
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($profile_id,$type,$time);
                }
            }
            if($type == "Private")
            {
                $privateData=$this->Mod_home->privateTagiList($profile_id,$type);
                $user_data["first_name"]=$data["first_name"];
                $user_data["last_name"]=$data["last_name"];
                $user_data["user_name"]=$privateData["name"];
                $user_data["email"]=$data["email"];
                $user_data["description"]=$privateData["description"];
                $user_data["status"]=$result["status"];
                $user_data["direct_status"]=$direct_status;
                $user_data["medical_status"]=$data["medical_status"];
                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                $user_data["type"]=$privateData["type"];
                $user_data["profile_image"]=$privateData["image"];
                $user_data["profile_status"]=$data["profile_status"];
                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                $user_data["total_tagi"]=$totalTagiCount;
                $user_data["points"]=$totalPoint;
                if($direct_status == 1)
                {
                    $user_data["social_links"]=$this->Mod_home->directtagiSocialLinksByDate($profile_id,$type,$time);
                }
                else
                {
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($profile_id,$type,$time);
                }
            }
            if($type == "Business")
            {
                $businessData=$this->Mod_home->businessTagiList($profile_id,$type);
                $user_data["first_name"]=$data["first_name"];
                $user_data["last_name"]=$data["last_name"];
                $user_data["user_name"]=$businessData["name"];
                $user_data["email"]=$data["email"];
                $user_data["description"]=$businessData["description"];
                $user_data["status"]=$result["status"];
                $user_data["direct_status"]=$direct_status;
                $user_data["medical_status"]=$data["medical_status"];
                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                $user_data["type"]=$businessData["type"];
                $user_data["profile_image"]=$businessData["image"];
                $user_data["profile_status"]=$data["profile_status"];
                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                $user_data["total_tagi"]=$totalTagiCount;
                $user_data["points"]=$totalPoint;
                if($direct_status == 1)
                {
                    $user_data["social_links"]=$this->Mod_home->directtagiSocialLinksByDate($profile_id,$type,$time);
                }
                else
                {
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($profile_id,$type,$time);
                }
            }
            if($user_data)
            {
                $userData=$this->Mod_home->getUserProfile($profile_id);
                unset($userData['password']);
                $token=JWT::encode($userData, $this->config->item('jwt_key'));
                echo json_encode(array("status"=>"200","message"=>"User details","data"=>$user_data,"token"=>$token));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userTotalPoints()
    {
        $token=$_POST["token"];
        $language=$_POST["language"];
        if(!empty($token))
        {
            $tokenDecode=JWT::decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecode->id;
            $result=$this->Mod_home->userTotalPoints($user_id);
            $giftCardResult=$this->Mod_home->allGiftCardRangeList();
            foreach($giftCardResult as $cards)
            {
                $data["id"]=$cards["id"];
                $data["point_range_from"]=$cards["point_range_from"];
                $data["point_range_to"]=$cards["point_range_to"];
                if($language == "en")
                {
                    $data["home_note"]=$cards["home_note"];
                }
                else
                {
                    $data["home_note"]=$cards["arabic_note"];
                }
                $gift[]=$data;
            }
            $public_status=$this->Mod_home->getPublicStatus($user_id);
            $public_direct_status=$public_status['direct_status'];
            $business_status=$this->Mod_home->getBusinessStatus($user_id);
            $business_direct_status=$business_status['direct_status'];
            $private_status=$this->Mod_home->getPrivateStatus($user_id);
            $private_direct_status=$private_status['direct_status'];
            $status=array(
                "public_status"=>$public_direct_status,
                "business_status"=>$business_direct_status,
                "private_status"=>$private_direct_status
            );
            
            if($result)
            {
                if($gift)
                {
                    echo json_encode(array("status"=>"200","message"=>"User Points","data"=>$result,"range"=>$gift,"profile_status"=>$status));
                }
                else
                {
                    $data["id"]="0";
                    $data["point_range_from"]="0";
                    $data["point_range_to"]="100";
                    $data["home_note"]=" ";
                    $gift[]=$data;
                    echo json_encode(array("status"=>"200","message"=>"User Points","data"=>$result,"range"=>$gift,"profile_status"=>$status));
                }
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"200","message"=>$message,"profile_status"=>$status));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function barcodeUpload()
    {
        $temp_pictures=$_FILES['barcode']['tmp_name']; 
        $barcodeImages = $_FILES['barcode']['name']; 
        $sourcePath = $_FILES['barcode']['tmp_name'];  
        $targetPath = "barCode/".$barcodeImages;  
        $url=base_url().$targetPath;
        if(move_uploaded_file($sourcePath, $targetPath))
        {
            $message=$this->language_messages('uploaded_successfully');
            echo json_encode(array("status"=>"200","message"=>$message,"url"=>$url));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function allGiftCardList()
    {
        $result=$this->Mod_home->allGiftCardList();
        if($result)
        {
            echo json_encode(array("status"=>"200","message"=>"Gift Card List","data"=>$result));
        }
        else
        {
            $message=$this->language_messages('error_not_found');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function userGiftCardList()
    {
        $token=$_POST['token'];
        if($token)
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $result=$this->Mod_home->giftCardList($user_id);
            if($result)
            {
                echo json_encode(array("status"=>"200","message"=>"Card List","data"=>$result));
            }
            else
            {
                $message=$this->language_messages('error_not_found');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
    }
    public function tokenDecode()
    {
        $token=$_POST["token"];
        if($token)
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            echo json_encode(array("status"=>"200","message"=>"Token data","data"=>$tokenDecoded));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function getNotification()
    {
        $firebasetoken="fqqYjc8RR0WwltXCtoVIQn:APA91bEiigg40Mbzi1K0ZoSlFed14fDYwZ-7fTLWhCXqd-rr84MWmNyiEt-RqKu3DCGLDSlIo0XYRjNXeQL83hWEMTQFkzwzi5zB3JNUK03WXcbIt0pUkWgW_Z1cmBq2B4IciHN42AmS";
        $message="Testing";
        $date=date('Y-m-d h:i:s');
        $user_id=1;
        $message1 = array('body' => $message,'title' => $message);
        $field=array("message" => $message,"id" => $user_id,"date"=>$date);
        
        $fields = array('to'=> $firebasetoken,
                        'notification'=> $field,
                        'data' => $field           
                        );
        $headers = array
        (
            'Authorization: key=' . SERVER_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );
        $results=curl_exec($ch );           
        $resultsArray=json_decode($results);
        /*print_r($resultsArray);
        die;*/
         $success=$resultsArray->success;
    }
    
    
    public function getQrcodeUserDetail()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokendecoded=JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
             $user_id=$tokendecoded->id;
            /*$id=$_POST["id"];*/
            $qrcode=$_POST["qrcode"];
            $profileLink=$_POST["type"];
            
            $seed = 1234567890;
            mt_srand($seed);
    	    $url=$this->ProfileUrlDecode($profileLink,$seed);
    	    $userId=substr($url,0,4);
    	    $userProfileType=substr($url,4,7);
    	    $tagi_id=base64_decode($userId);
    	    $profile_type=str_rot13($userProfileType);
    	    if($profile_type == "UDP")
    	    {
    	        $type="Public";
    	    }
    	    elseif($profile_type == "UBP")
    	    {
    	        $type="Business";
    	    }
    	    elseif($profile_type == "UPP")
    	    {
    	        $type="Private";
    	    }
            
            $time=$_POST["time"];
            if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $time))
            {
                $date_from_timestamp=$time;
            }
            else
            {
                $decodeTime=$this->decode($time);
                $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
            }
            $date=date('Y-m-d h:i:s');
            $result=$this->Mod_home->qrcodeUserId($qrcode,$type);
            $id=$result["id"];
            if($user_id == $id)
            {
                $totalPoints=$this->Mod_home->userTotalPoints($id);
                if(!empty($totalPoints["points"]))
                {
                    $totalPoint=$totalPoints["points"];
                }
                else
                {
                    $totalPoint="0";
                }
                $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                $medicalDetails=$this->Mod_home->medicalStatus($id);
                $data=$this->Mod_home->userTagiDetails($id);
                if($data)
                {
                    $default_public_status=$data["default_public_status"];
                    $default_private_status=$data["default_private_status"];
                    $default_business_status=$data["default_business_status"];
                    $publicData=$this->Mod_home->tagiDataList($id,$type);
                    $user_data["first_name"]=$data["first_name"];
                    $user_data["last_name"]=$data["last_name"];
                    $user_data["user_name"]=$publicData["name"];
                    $user_data["email"]=$data["email"];
                    $user_data["description"]=$publicData["description"];
                    $user_data["status"]=$result["status"];
                    $user_data["direct_status"]=$publicData["direct_status"];
                    $user_data["medical_status"]=$data["medical_status"];
                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                    $user_data["type"]=$publicData["type"];
                    $user_data["profile_image"]=$publicData["image"];
                    $user_data["profile_status"]=$data["profile_status"];
                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                    $user_data["total_tagi"]=$totalTagiCount;
                    $user_data["points"]=$totalPoint;
                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);    
                    $userData=$this->Mod_home->getUserProfile($id);
                    unset($userData['password']);
                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                    echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                }
            }
            else
            {
                $resultCheck=$this->Mod_home->peopleLogCheck($user_id,$id);
                
                if($resultCheck)
                {
                    $totalPoints=$this->Mod_home->userTotalPoints($id);
                    if(!empty($totalPoints["points"]))
                    {
                        $totalPoint=$totalPoints["points"];
                    }
                    else
                    {
                        $totalPoint="0";
                    }
                    
                    $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                    $medicalDetails=$this->Mod_home->medicalStatus($id);
                    $data=$this->Mod_home->userTagiDetails($id);
                    if($data)
                    {
                        $udata=$this->Mod_home->userTagiDetails($user_id);
                        $default_public_status=$data["default_public_status"];
                        $default_private_status=$data["default_private_status"];
                        $default_business_status=$data["default_business_status"];
                        
                        $user_default_public_status=$udata["default_public_status"];
                        $user_default_private_status=$udata["default_private_status"];
                        $user_default_business_status=$udata["default_business_status"];
                        
                        if($user_default_public_status == 1)
                        {
                           $user_type="Public";
                        }
                        if($user_default_private_status == 1)
                        {
                           $user_type="Private";
                        }
                        if($user_default_business_status == 1)
                        {
                            $user_type="Business";
                        }
                        $publicData=$this->Mod_home->tagiDataList($id,$type);
                        $direct_status=$publicData["direct_status"];
                        $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                        $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                        
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$publicData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$publicData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$publicData["direct_status"];
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$publicData["type"];
                        $user_data["profile_image"]=$publicData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);   
                        
                        if($user_data)
                        {
                            $userData=$this->Mod_home->getUserProfile($id);
                            unset($userData['password']);
                            $token=JWT::encode($userData, $this->config->item('jwt_key'));
                            echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    
                }
                else
                {
                    $log_data=$this->Mod_home->logPointData($id);
                    
                    if($log_data)
                    {
                        $points=$log_data["points"];
                        $addpoint=$points+1;
                        $update_points=$this->Mod_home->updateLogPoints($id,$addpoint);
                        if($update_points)
                        {
                            $totalPoints=$this->Mod_home->userTotalPoints($id);
                            if(!empty($totalPoints["points"]))
                            {
                                $totalPoint=$totalPoints["points"];
                            }
                            else
                            {
                                $totalPoint="0";
                            }
                            $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                            $medicalDetails=$this->Mod_home->medicalStatus($id);
                            $data=$this->Mod_home->userTagiDetails($id);
                            if($data)
                            {
                                $udata=$this->Mod_home->userTagiDetails($user_id);
                                $default_public_status=$data["default_public_status"];
                                $default_private_status=$data["default_private_status"];
                                $default_business_status=$data["default_business_status"];
                                
                                $user_default_public_status=$udata["default_public_status"];
                                $user_default_private_status=$udata["default_private_status"];
                                $user_default_business_status=$udata["default_business_status"];
                                
                                if($user_default_public_status == 1)
                                {
                                   $user_type="Public";
                                }
                                if($user_default_private_status == 1)
                                {
                                   $user_type="Private";
                                }
                                if($user_default_business_status == 1)
                                {
                                    $user_type="Business";
                                }
                                $publicData=$this->Mod_home->tagiDataList($id,$type);
                                $direct_status=$publicData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$publicData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$publicData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$publicData["direct_status"];
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$publicData["type"];
                                $user_data["profile_image"]=$publicData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);   
                                
                                if($user_data)
                                {
                                    $userData=$this->Mod_home->getUserProfile($id);
                                    unset($userData['password']);
                                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                    echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                                }
                                else
                                {
                                    $message=$this->language_messages('error_something_wrong');
                                    echo json_encode(array("status"=>"400","message"=>$message));
                                }
                            }
                           /* echo json_encode(array("status"=>"200","message"=>"Add tagi successfully"));*/
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $points=1;
                        $add_points=$this->Mod_home->addLogPoints($id,$points);
                        $totalPoints=$this->Mod_home->userTotalPoints($id);
                        
                        if(!empty($totalPoints["points"]))
                        {
                            $totalPoint=$totalPoints["points"];
                        }
                        else
                        {
                            $totalPoint="0";
                        }
                        $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                        $medicalDetails=$this->Mod_home->medicalStatus($id);
                        $data=$this->Mod_home->userTagiDetails($id);
                        if($data)
                        {
                            $udata=$this->Mod_home->userTagiDetails($user_id);
                            $default_public_status=$data["default_public_status"];
                            $default_private_status=$data["default_private_status"];
                            $default_business_status=$data["default_business_status"];
                            
                            $user_default_public_status=$udata["default_public_status"];
                            $user_default_private_status=$udata["default_private_status"];
                            $user_default_business_status=$udata["default_business_status"];
                            
                            if($user_default_public_status == 1)
                            {
                               $user_type="Public";
                            }
                            if($user_default_private_status == 1)
                            {
                               $user_type="Private";
                            }
                            if($user_default_business_status == 1)
                            {
                                $user_type="Business";
                            }
                            $publicData=$this->Mod_home->tagiDataList($id,$type);
                            $direct_status=$publicData["direct_status"];
                            $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                            $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                            
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$publicData["name"];
                            $user_data["email"]=$data["email"];
                            $user_data["description"]=$publicData["description"];
                            $user_data["status"]=$result["status"];
                            $user_data["direct_status"]=$publicData["direct_status"];
                            $user_data["medical_status"]=$data["medical_status"];
                            $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                            $user_data["type"]=$publicData["type"];
                            $user_data["profile_image"]=$publicData["image"];
                            $user_data["profile_status"]=$data["profile_status"];
                            $user_data["phone_number"]=$medicalDetails["mobile_number"];
                            $user_data["total_tagi"]=$totalTagiCount;
                            $user_data["points"]=$totalPoint;
                            $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);    
                            
                            if($user_data)
                            {
                                $userData=$this->Mod_home->getUserProfile($id);
                                unset($userData['password']);
                                $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                            }
                            else
                            {
                                $message=$this->language_messages('error_something_wrong');
                                echo json_encode(array("status"=>"400","message"=>$message));
                            }
                        }
                    }
                }
            }
        }
    }
    public function creatWallet()
    {
        $id=$_GET["id"];
        $time=$_GET["time"];
        
        //$userData=$this->Mod_home->getUserProfile($id);
        $medicalDetails=$this->Mod_home->medicalStatus($id);
        $data=$this->Mod_home->userTagiDetails($id);
        if($data)
        {
            $default_public_status=$data["default_public_status"];
            $default_private_status=$data["default_private_status"];
            $default_business_status=$data["default_business_status"];
            if($default_public_status == 1)
            {
                $type="Public";
                $publicData=$this->Mod_home->tagiDataList($id,$type);
                $user_data["user_name"]=$publicData["name"];
                $user_data["qrcode"]=$data["qrcode"];
                $phone_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Call');
                $whatsapp_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Whatsapp');
                $gmail_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Gmail');
                $yahoo_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Yahoo');
                if(!empty($phone_links))
                {
                    $user_data["phone_number"]=$phone_links['link'];
                }
                else
                {
                    $user_data["phone_number"]=$whatsapp_links['link'];
                }
                if(!empty($gmail_links))
                {
                    $user_data['email']=$gmail_links['link'];
                }
                else
                {
                    $user_data['email']=$yahoo_links['link'];
                }
            }
            if($default_private_status == 1)
            {
                $type="Private";
                $privateData=$this->Mod_home->privateTagiList($id,$type);
                $user_data["user_name"]=$privateData["name"];
                $user_data["qrcode"]=$data["private_qrcode"];
                $phone_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Call');
                $whatsapp_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Whatsapp');
                $gmail_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Gmail');
                $yahoo_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Yahoo');
                if(!empty($phone_links))
                {
                    $user_data["phone_number"]=$phone_links['link'];
                }
                else
                {
                    $user_data["phone_number"]=$whatsapp_links['link'];
                }
                if(!empty($gmail_links))
                {
                    $user_data['email']=$gmail_links['link'];
                }
                else
                {
                    $user_data['email']=$yahoo_links['link'];
                }
            }
            if($default_business_status == 1)
            {
                $type="Business";
                $businessData=$this->Mod_home->businessTagiList($id,$type);
                $user_data["user_name"]=$businessData["name"];
                $user_data["qrcode"]=$data["business_qrcode"];
                $phone_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Call');
                $whatsapp_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Whatsapp');
                $gmail_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Gmail');
                $yahoo_links=$this->Mod_home->walletTagiSocialLinks($id,$type,'Yahoo');
                if(!empty($phone_links))
                {
                    $user_data["phone_number"]=$phone_links['link'];
                }
                else
                {
                    $user_data["phone_number"]=$whatsapp_links['link'];
                }
                if(!empty($gmail_links))
                {
                    $user_data['email']=$gmail_links['link'];
                }
                else
                {
                    $user_data['email']=$yahoo_links['link'];
                }
            }
            if($user_data)
            {
                $name=$user_data["user_name"];
                if(!empty($user_data['email']))
                {
                    $email=$user_data['email'];
                }
                else
                {
                    $email=$data["email"];
                }
                if(!empty($user_data['phone_number']))
                {
                    $phone=$user_data['phone_number'];
                }
                else
                {
                    $phone=" ";
                }
                $code=$user_data['qrcode'];
            }
            else
            {
                $name="";
                $email="";
                $phone="";
                $code="";
            }
        }
        if($type == "Public")
	    {
	        $profile_type="UDP";
	    }
	    elseif($type == "Business")
	    {
	        $profile_type="UBP";
	    }
	    elseif($type == "Private")
	    {
	        $profile_type="UPP";
	    }
	    $profileLink=$this->ProfileUrlEncode($id,$profile_type);
        /*$decodeTime=$this->decode($encodedTime);*/
        include('wallet/src/PKPass.php');
        $userQrUrl="https://tagmoi.co/read/walletqrcode/".$code."/".$profileLink."/".$time;
        
        // Replace the parameters below with the path to your .p12 certificate and the certificate password!
        $pass = new PKPass('wallet/src/Certificate/CertificatesPass.p12', '12345');
        
        // Pass content
        $data = [
            'description' => 'TagMoi Card',
            'formatVersion' => 1,
            'organizationName' => 'TagMoi Card',
            'passTypeIdentifier' => 'pass.TagMoi.co', // Change this!
            'serialNumber' => $id,
            'teamIdentifier' => 'GC5KJM4W48', // Change this!
            'coupon' => [
                'primaryFields' => [
                    [
                        'backgroundColor' => 'rgb(255,255,255)',
                        'key' => 'origin',
                        'label' => 'TagMoi Card',
                        'value' => '',
                    ]
                ],
                'secondaryFields' => [
                    [
                        'key' => 'Name',
                        'label' => 'Name',
                        'value' => $name,
                    ],
                    [
                        'key' => 'Email',
                        'label' => 'Email',
                        'value' => $email,
                    ],
                    [
                        'key' => 'Phone',
                        'label' => 'Phone',
                        'value' => $phone,
                    ]
                ],
                'backFields' => [
                    [
                        'key' => 'id',
                        'label' => 'Card Number',
                        'value' => $id,
                    ],
                ]
            ],
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $userQrUrl,
                'messageEncoding' => 'iso-8859-1',
                'logoImage' => 'assets/img/wallet/logo.png'
            ] ,
            'backgroundColor' => 'rgb(255,255,255)',
            'logoText' => '',
            'relevantDate' => date('Y-m-d\TH:i:sP')
        ];
        $pass->setData($data);
        
        // Add files to the pass package
        $pass->addFile('assets/img/wallet/icon.png');
        $pass->addFile('assets/img/wallet/icon@2x.png');
        $pass->addFile('assets/img/wallet/logo.png');
        
        // Create and output the pass
        if(!$pass->create(true)) {
            echo 'Error: ' . $pass->getError();
        }
    }
    public function getUserProfileData()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokendecoded=JWT:: decode($token, $this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokendecoded->id;
            $date=date('Y-m-d h:i:s');
            $profileLink=$_POST["profile_url"];
            $time=$_POST["time"];
            $status=$_POST["status"];
            
            $decodeTime=$this->decode($time);
            $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
            $seed = 1234567890;
            mt_srand($seed);
    	    $url=$this->ProfileUrlDecode($profileLink,$seed);
    	    $userId=substr($url,0,4);
    	    $userProfileType=substr($url,4,7);
    	    $id=base64_decode($userId);
    	    $profile_type=str_rot13($userProfileType);
    	    $str_direct_status=str_rot13($status);
            $profile_decode_status=$this->directStatusDecode($str_direct_status,$seed);
    	    $decode_status=base64_decode($profile_decode_status);
    	    
    	    if($profile_type == "UDP")
    	    {
    	        $type="Public";
    	    }
    	    elseif($profile_type == "UBP")
    	    {
    	        $type="Business";
    	    }
    	    elseif($profile_type == "UPP")
    	    {
    	        $type="Private";
    	    }
            if($user_id == $id)
            {
                $totalPoints=$this->Mod_home->userTotalPoints($id);
                if(!empty($totalPoints["points"]))
                {
                    $totalPoint=$totalPoints["points"];
                }
                else
                {
                    $totalPoint="0";
                }
                $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                $medicalDetails=$this->Mod_home->medicalStatus($id);
                $data=$this->Mod_home->userTagiDetails($id);
                if($data)
                {
                    $default_public_status=$data["default_public_status"];
                    $default_private_status=$data["default_private_status"];
                    $default_business_status=$data["default_business_status"];
                    
                    $publicData=$this->Mod_home->tagiDataList($id,$type);
                    $user_data["first_name"]=$data["first_name"];
                    $user_data["last_name"]=$data["last_name"];
                    $user_data["user_name"]=$publicData["name"];
                    $user_data["email"]=$data["email"];
                    $user_data["description"]=$publicData["description"];
                    $user_data["status"]=$result["status"];
                    $user_data["direct_status"]=$decode_status;
                    $user_data["medical_status"]=$data["medical_status"];
                    $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                    $user_data["type"]=$publicData["type"];
                    $user_data["profile_image"]=$publicData["image"];
                    $user_data["profile_status"]=$data["profile_status"];
                    $user_data["phone_number"]=$medicalDetails["mobile_number"];
                    $user_data["total_tagi"]=$totalTagiCount;
                    $user_data["points"]=$totalPoint;
                    if($decode_status == 1)
                    {
                        $user_data["social_links"]=$this->Mod_home->tagiDefaultSocialLinks($id,$type);
                    }
                    else
                    {
                        $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);     
                    }
                    $userData=$this->Mod_home->getUserProfile($id);
                    unset($userData['password']);
                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                    echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                }
            }
            else
            {
                $resultCheck=$this->Mod_home->peopleLogCheck($user_id,$id);
                if($resultCheck)
                {
                    $totalPoints=$this->Mod_home->userTotalPoints($id);
                    if(!empty($totalPoints["points"]))
                    {
                        $totalPoint=$totalPoints["points"];
                    }
                    else
                    {
                        $totalPoint="0";
                    }
                    $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                    $medicalDetails=$this->Mod_home->medicalStatus($id);
                    $data=$this->Mod_home->userTagiDetails($id);
                    if($data)
                    {
                        $udata=$this->Mod_home->userTagiDetails($user_id);
                        $default_public_status=$data["default_public_status"];
                        $default_private_status=$data["default_private_status"];
                        $default_business_status=$data["default_business_status"];
                        
                        $user_default_public_status=$udata["default_public_status"];
                        $user_default_private_status=$udata["default_private_status"];
                        $user_default_business_status=$udata["default_business_status"];
                        $publicData=$this->Mod_home->tagiDataList($id,$type);
                        $direct_status=$publicData["direct_status"];
                        $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                        $this->Mod_home->addOtherPeopleLog($id,$user_id,$type,$date);
                        $user_data["first_name"]=$data["first_name"];
                        $user_data["last_name"]=$data["last_name"];
                        $user_data["user_name"]=$publicData["name"];
                        $user_data["email"]=$data["email"];
                        $user_data["description"]=$publicData["description"];
                        $user_data["status"]=$result["status"];
                        $user_data["direct_status"]=$decode_status;
                        $user_data["medical_status"]=$data["medical_status"];
                        $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                        $user_data["type"]=$publicData["type"];
                        $user_data["profile_image"]=$publicData["image"];
                        $user_data["profile_status"]=$data["profile_status"];
                        $user_data["phone_number"]=$medicalDetails["mobile_number"];
                        $user_data["total_tagi"]=$totalTagiCount;
                        $user_data["points"]=$totalPoint;
                        
                        if($decode_status == 1)
                        {
                            $user_data["social_links"]=$this->Mod_home->tagiDefaultSocialLinks($id,$type);
                        }
                        else
                        {
                            $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);     
                        }
                        if($user_data)
                        {
                            $userData=$this->Mod_home->getUserProfile($id);
                            unset($userData['password']);
                            $token=JWT::encode($userData, $this->config->item('jwt_key'));
                            echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                }
                else
                {
                    $log_data=$this->Mod_home->logPointData($id);
                    if($log_data)
                    {
                        $points=$log_data["points"];
                        $addpoint=$points+1;
                        $update_points=$this->Mod_home->updateLogPoints($id,$addpoint);
                        if($update_points)
                        {
                            $totalPoints=$this->Mod_home->userTotalPoints($id);
                            if(!empty($totalPoints["points"]))
                            {
                                $totalPoint=$totalPoints["points"];
                            }
                            else
                            {
                                $totalPoint="0";
                            }
                            $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                            $medicalDetails=$this->Mod_home->medicalStatus($id);
                            $data=$this->Mod_home->userTagiDetails($id);
                            if($data)
                            {
                                $udata=$this->Mod_home->userTagiDetails($user_id);
                                $default_public_status=$data["default_public_status"];
                                $default_private_status=$data["default_private_status"];
                                $default_business_status=$data["default_business_status"];
                                
                                $user_default_public_status=$udata["default_public_status"];
                                $user_default_private_status=$udata["default_private_status"];
                                $user_default_business_status=$udata["default_business_status"];
                                $publicData=$this->Mod_home->tagiDataList($id,$type);
                                $direct_status=$publicData["direct_status"];
                                $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                                $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                                
                                $user_data["first_name"]=$data["first_name"];
                                $user_data["last_name"]=$data["last_name"];
                                $user_data["user_name"]=$publicData["name"];
                                $user_data["email"]=$data["email"];
                                $user_data["description"]=$publicData["description"];
                                $user_data["status"]=$result["status"];
                                $user_data["direct_status"]=$decode_status;
                                $user_data["medical_status"]=$data["medical_status"];
                                $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                                $user_data["type"]=$publicData["type"];
                                $user_data["profile_image"]=$publicData["image"];
                                $user_data["profile_status"]=$data["profile_status"];
                                $user_data["phone_number"]=$medicalDetails["mobile_number"];
                                $user_data["total_tagi"]=$totalTagiCount;
                                $user_data["points"]=$totalPoint;
                                if($decode_status == 1)
                                {
                                    $user_data["social_links"]=$this->Mod_home->tagiDefaultSocialLinks($id,$type);
                                }
                                else
                                {
                                    $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);     
                                }
                                if($user_data)
                                {
                                    $userData=$this->Mod_home->getUserProfile($id);
                                    unset($userData['password']);
                                    $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                    echo json_encode(array("status"=>"200","message"=>"Tagi details","data"=>$user_data,"token"=>$token));
                                }
                                else
                                {
                                    $message=$this->language_messages('error_something_wrong');
                                    echo json_encode(array("status"=>"400","message"=>$message));
                                }
                            }
                           /* echo json_encode(array("status"=>"200","message"=>"Add tagi successfully"));*/
                        }
                        else
                        {
                            $message=$this->language_messages('error_something_wrong');
                            echo json_encode(array("status"=>"400","message"=>$message));
                        }
                    }
                    else
                    {
                        $points=1;
                        $add_points=$this->Mod_home->addLogPoints($id,$points);
                        $totalPoints=$this->Mod_home->userTotalPoints($id);
                        if(!empty($totalPoints["points"]))
                        {
                            $totalPoint=$totalPoints["points"];
                        }
                        else
                        {
                            $totalPoint="0";
                        }
                        $totalTagiCount=$this->Mod_home->totalUserTagiCount($id);
                        $medicalDetails=$this->Mod_home->medicalStatus($id);
                        $data=$this->Mod_home->userTagiDetails($id);
                        if($data)
                        {
                            $udata=$this->Mod_home->userTagiDetails($user_id);
                            $default_public_status=$data["default_public_status"];
                            $default_private_status=$data["default_private_status"];
                            $default_business_status=$data["default_business_status"];
                            
                            $user_default_public_status=$udata["default_public_status"];
                            $user_default_private_status=$udata["default_private_status"];
                            $user_default_business_status=$udata["default_business_status"];
                            $publicData=$this->Mod_home->tagiDataList($id,$type);
                            $direct_status=$publicData["direct_status"];
                            $this->Mod_home->addpeopleLog($user_id,$id,$type,$direct_status,$date);
                            $this->Mod_home->addOtherPeopleLog($id,$user_id,$user_type,$date);
                            $user_data["first_name"]=$data["first_name"];
                            $user_data["last_name"]=$data["last_name"];
                            $user_data["user_name"]=$publicData["name"];
                            $user_data["email"]=$data["email"];
                            $user_data["description"]=$publicData["description"];
                            $user_data["status"]=$result["status"];
                            $user_data["direct_status"]=$decode_status;
                            $user_data["medical_status"]=$data["medical_status"];
                            $user_data["user_medical_status"]=$medicalDetails["profile_status"];
                            $user_data["type"]=$publicData["type"];
                            $user_data["profile_image"]=$publicData["image"];
                            $user_data["profile_status"]=$data["profile_status"];
                            $user_data["phone_number"]=$medicalDetails["mobile_number"];
                            $user_data["total_tagi"]=$totalTagiCount;
                            $user_data["points"]=$totalPoint;
                            if($decode_status == 1)
                            {
                                $user_data["social_links"]=$this->Mod_home->tagiDefaultSocialLinks($id,$type);
                            }
                            else
                            {
                                $user_data["social_links"]=$this->Mod_home->tagiSocialLinksByDate($id,$type,$date_from_timestamp);     
                            }
                            if($user_data)
                            {
                                $userData=$this->Mod_home->getUserProfile($id);
                                unset($userData['password']);
                                $token=JWT::encode($userData, $this->config->item('jwt_key'));
                                echo json_encode(array("status"=>"200","message"=>"TagMoi details","data"=>$user_data,"token"=>$token));
                            }
                            else
                            {
                                $message=$this->language_messages('error_something_wrong');
                                echo json_encode(array("status"=>"400","message"=>$message));
                            }
                        }
                    }
                }
            }
        }
    }
    public function setPrivateProfilePassword()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token,$this->config->item('HS256'));
            $user_id=$tokenDecoded->id;
            $password=$_POST["password"];
            $result=$this->Mod_home->setPrivateProfilePassword($user_id,$password);
            if($result)
            {
                $message=$this->language_messages('profile_updated');
                echo json_encode(array("status"=>"200","message"=>$message));
            }
            else
            {
                $message=$this->language_messages('error_something_wrong');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));   
        }
    }
    public function forgotPrivatePassword()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecode=JWT::decode($token,$this->config->item('HS256'));
            $user_id=$tokenDecode->id;
            $userData=$this->Mod_home->getUserProfile($user_id);
            $email=$_POST["email"];
            $code=rand("9999","1000");
            $language=$_POST['language'];
            $name=$userData['first_name']." ".$userData['last_name'];
            if($language == 'en')
            {
                $type="Change Private Password";
                $body="We received a request to reset your TagMoi password.";
                $this->sendChangePasswordMail($email,$type,$name,$code,$body);
            }
            elseif($language == 'ar')
            {
                $body=".لقد تلقينا طلبًا لإعادة تعيين كلمة مرور تاغ موا الخاصة بك";
                $type="تغير الرقم السري للخاص";
                $this->sendArabicChangePasswordMail($email,$type,$name,$code,$body);
            }
            $this->Mod_home->updatePrivatePasswordOtp($user_id,$code);
            $message=$this->language_messages('password_mail_message');
            echo json_encode(array("status"=>"200","message"=>$message,"data"=>$code));
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function changePrivatePassword()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $password=$_POST["password"];
            $newPassword=$_POST["new_password"];
            $confirmPassword=$_POST["confirm_password"];
            $passwordCheck=$this->Mod_home->protectedPasswordCheck($user_id);
            $userPassword=$passwordCheck["protected_password"];
            if($password == $userPassword)
            {
                if($newPassword == $confirmPassword)
                {
                    $result=$this->Mod_home->updateNewProtectedPassword($user_id,$newPassword);
                    if($result)
                    {
                        $message=$this->language_messages('password_updated');
                        echo json_encode(array("status"=>"200","message"=>$message,"data"=>$newPassword));
                    }
                    else
                    {
                        $message=$this->language_messages('error_something_wrong');
                        echo json_encode(array("status"=>"400","message"=>$message));
                    }
                }
                else
                {
                    $message=$this->language_messages('error_confirm_password_not_match');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_password_not_match');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function resetPrivatePassword()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $password=$_POST["password"];
            $confirmPassword=$_POST["confirm_password"];
            $passwordCheck=$this->Mod_home->protectedPasswordCheck($user_id);
            $userPassword=$passwordCheck["protected_password"];
            
            if($password == $confirmPassword)
            {
                $result=$this->Mod_home->updateNewProtectedPassword($user_id,$password);
                if($result)
                {
                    $message=$this->language_messages('password_updated');
                    echo json_encode(array("status"=>"200","message"=>$message,"data"=>$password));
                }
                else
                {
                    $message=$this->language_messages('error_something_wrong');
                    echo json_encode(array("status"=>"400","message"=>$message));
                }
            }
            else
            {
                $message=$this->language_messages('error_confirm_password_not_match');
                echo json_encode(array("status"=>"400","message"=>$message));
            }
        }
        else
        {
            $message=$this->language_messages('error_something_wrong');
            echo json_encode(array("status"=>"400","message"=>$message));
        }
    }
    public function sendChangePasswordMail($email,$type,$name,$code,$body)
    {
        require 'vendor/autoload.php';
        $API_KEY='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';
        $FROM_EMAIL = 'support@tagmoi.co';
        $TO_EMAIL = $email; 
        $subject = $type; 
        $from = new SendGrid\Email(null, $FROM_EMAIL);
        $to = new SendGrid\Email(null, $TO_EMAIL);
        $decode= base64_encode($TO_EMAIL);
        $htmlContent = 'Hi '.$name.',  
                        <br/>'.$body.'
                        <br/>Your code is: '.$code.'
                        <br/><br/>Best Regards,
                        <br/>TagMoi Support';
                          
        $content = new SendGrid\Content("text/html",$htmlContent);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($API_KEY);
        $response = $sg->client->mail()->send()->post($mail);
        if($response->statusCode() == 202)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    public function sendArabicChangePasswordMail($email,$type,$name,$code,$body)
    {
        
        require 'vendor/autoload.php';
        $API_KEY='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';
        $FROM_EMAIL = 'support@tagmoi.co';
        $TO_EMAIL = $email; 
        $subject = $type; 
        $from = new SendGrid\Email(null, $FROM_EMAIL);
        $to = new SendGrid\Email(null, $TO_EMAIL);
        $decode= base64_encode($TO_EMAIL);
        $htmlContent = '، '.$name.' مرحباً
                        
                        <br/>'.$body.'
                        <br/>'.$code.':الكود الخاص بك هو
                        
                        <br/>،دمتم سالمين
                        <br/>تاغ موا لدعم الفني';
        $content = new SendGrid\Content("text/html",$htmlContent);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($API_KEY);
        $response = $sg->client->mail()->send()->post($mail);
        if($response->statusCode() == 202)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    public function GetDataForContactCard()
    {
         $json = file_get_contents('php://input');
        $data = json_decode($json);
       
         $user_id=$data->id;
        $userData=$this->Mod_home->getUserProfile($user_id);
        if(!empty($userData))
        {
            echo json_encode(array("success" =>1,"data" => $userData));
        }
        else
        {
              echo json_encode(array("success" =>0,"data" => NULL));
        }
    }
    public function failedTagi()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT:: decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $uid=$_POST["uid"];
            $data=array(
                    "user_id"=>$user_id,
                    "uid"=>$uid
                );
            $result=$this->Mod_home->failedTagi($data);
            if($result)
            {
                echo json_encode(array("status"=>"200","message"=>"Successfully Submited"));
            }
            else
            {
                echo json_encode(array("status"=>"400","message"=>"Something is wrong so please try again"));
            }
        }
    }
    public function shareProfileUrl()
    {
        $token=$_POST["token"];
        if(!empty($token))
        {
            $tokenDecoded=JWT::decode($token,$this->config->item('jwt_key'),array('HS256'));
            $user_id=$tokenDecoded->id;
            $usertype=$_POST["type"];
            $direct_status=$_POST["status"];
            $encode_status=$this->directStatusEncode($direct_status);
            /*echo $encode_status;
            $str_direct_status=str_rot13($encode_status);
            $seed = 1234567890;
            mt_srand($seed);
            $decode_status=$this->directStatusDecode($str_direct_status,$seed);
            echo $decode_status;
            die;*/
            if($usertype == "Public")
    	    {
    	        $type="UDP";
    	    }
    	    elseif($usertype == "Business")
    	    {
    	        $type="UBP";
    	    }
    	    elseif($usertype == "Private")
    	    {
    	        $type="UPP";
    	    }
    	    $qrcode=$this->Mod_home->getpublicQrcode($user_id,$usertype);
    	    $profileLink=$this->ProfileUrlEncode($user_id,$type);
        	$Time=time();
            $encodedTime = $this->encode($Time);
    	    $url=$profileLink."/".$encode_status."/".$encodedTime;
    	    $full_url="https://tagmoi.co/read/shareprofile/".$url;
    	    if($profileLink)
    	    {
    	        /*if($status == 1)
        	    {
        	        $addLog=$this->Mod_home->addDirectLog($user_id,$usertype,$direct_status,$encodedTime);
        	    }*/
    	        echo json_encode(array("status"=>"200","message"=>"Profile Url","data"=>$url,"full_url"=>$full_url,"qrcode"=>$qrcode));
    	    }
    	    else
    	    {
    	        echo json_encode(array("status"=>"400","message"=>"Something is wrong please try again"));
    	    }
        }
        else
        {
            echo json_encode(array("status"=>"400","message"=>"Something is wrong please try again"));
        }
    }
    
    public function publicqrcode()
    {
        //Public Qr Code
            $id=$_POST["user_id"];
            $public_code=$this->qrcodename();
            $publicfileName = 'qr'.$public_code.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$publicfileName;
            $urlRelativeFilePath = "$public_code/".$publicfileName;
            $publicuserQr="qrcode".$public_code;
            //$type=base64_encode('Public');
            $profileLink=$this->ProfileUrlEncode($id,'UDP');
            $data="https://tagmoi.co/read/qrcode/qrcode".$public_code."/".$profileLink;
            $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
            $logo = 'assets/img/qr_logo.png';
            $publicfilepath = 'qrcode/qr'.$public_code.'.png';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            if($logo !== FALSE){
            	$logo = imagecreatefromstring(file_get_contents($logo));
            
            	$QR_width = imagesx($QR);
            	$QR_height = imagesy($QR);
            	
            	$logo_width = imagesx($logo);
            	$logo_height = imagesy($logo);
            	
            	// Scale logo to fit in the QR Code
            	$logo_qr_width = $QR_width/5;
            	$scale = $logo_width/$logo_qr_width;
            	$logo_qr_height = $logo_height/$scale;
            	
            	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            }
            imagepng($QR,$publicfilepath);
            imagedestroy($QR);
            $updateqr=$this->Mod_home->publicqrcode($id,$publicuserQr,$publicfilepath);
    }
    public function businessqrcode()
    {
        $id=$_POST["user_id"];
        $public_code=$this->qrcodename();
            $publicfileName = 'qr'.$public_code.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$publicfileName;
            $urlRelativeFilePath = "$public_code/".$publicfileName;
            $publicuserQr="qrcode".$public_code;
            //$type=base64_encode('Public');
            $profileLink=$this->ProfileUrlEncode($id,'UBP');
            $data="https://tagmoi.co/read/qrcode/qrcode".$public_code."/".$profileLink;
            $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
            $logo = 'assets/img/qr_logo.png';
            $publicfilepath = 'qrcode/qr'.$public_code.'.png';
            
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            if($logo !== FALSE){
            	$logo = imagecreatefromstring(file_get_contents($logo));
            
            	$QR_width = imagesx($QR);
            	$QR_height = imagesy($QR);
            	
            	$logo_width = imagesx($logo);
            	$logo_height = imagesy($logo);
            	
            	// Scale logo to fit in the QR Code
            	$logo_qr_width = $QR_width/5;
            	$scale = $logo_width/$logo_qr_width;
            	$logo_qr_height = $logo_height/$scale;
            	
            	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            }
            imagepng($QR,$publicfilepath);
            imagedestroy($QR);
        $updateqr=$this->Mod_home->businessqrcode($id,$publicuserQr,$publicfilepath);
    }
    public function privateqrcode()
    {
        $id=$_POST["user_id"];
         $public_code=$this->qrcodename();
            $publicfileName = 'qr'.$public_code.'.png';
            $tempDir = "qrcode/";
            $pngAbsoluteFilePath = $tempDir.$publicfileName;
            $urlRelativeFilePath = "$public_code/".$publicfileName;
            $publicuserQr="qrcode".$public_code;
            //$type=base64_encode('Public');
             $profileLink=$this->ProfileUrlEncode($id,'UPP');
            $data="https://tagmoi.co/read/qrcode/qrcode".$public_code."/".$profileLink;
            $size = isset($_GET['size']) ? $_GET['size'] : '300x300';
            $logo = 'assets/img/qr_logo.png';
            $publicfilepath = 'qrcode/qr'.$public_code.'.png';
            $QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
            if($logo !== FALSE){
            	$logo = imagecreatefromstring(file_get_contents($logo));
            
            	$QR_width = imagesx($QR);
            	$QR_height = imagesy($QR);
            	
            	$logo_width = imagesx($logo);
            	$logo_height = imagesy($logo);
            	
            	// Scale logo to fit in the QR Code
            	$logo_qr_width = $QR_width/5;
            	$scale = $logo_width/$logo_qr_width;
            	$logo_qr_height = $logo_height/$scale;
            	
            	imagecopyresampled($QR, $logo, $QR_width/2.5, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
            }
            imagepng($QR,$publicfilepath);
            imagedestroy($QR);
            $updateqr=$this->Mod_home->privateqrcode($id,$publicuserQr,$publicfilepath);

    }
    public function qrcodename()
    {
        $date=date("dmYhis");
        $num=rand("999","10000").$date;
        return $num;
    }
    public function createQRCode()
    {
       // $users=$this->Mod_home->getQrCodeUser();
       /* print_r($users);
        die;*/
            $id=$_POST['user_id'];
            
            //Public Qr Code
            $public=$this->publicqrcode($id);
            //Business Qr Code
            
            $business=$this->businessqrcode($id);
            //Private Qr Code
            $private=$this->privateqrcode($id);      
        
    }
    public function testTime()
    {
        $time=$_POST["time"];
        $decodeTime=$this->decode($time);
        echo $decodeTime;
        echo "</br>";
        $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
        echo $date_from_timestamp;
    }
    
}



