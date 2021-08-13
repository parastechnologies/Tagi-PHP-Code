<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php 
error_reporting(0);

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
    
    private $nums;
    private $chars;
    private $numeral;
    public function __construct()
    {
        parent::__construct();
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
    public function profiles($tag_id)
	{
	    $id=$tag_id;
	    $idd=base64_decode($id);
	    $this->load->model("Mod_dashboard");
	    $tagiDetails=$this->Mod_dashboard->tagiActivateData($idd);
	    $tag_user_id= base64_encode($tagiDetails["user_id"]);
	    $uid=$tagiDetails["user_id"];
	    $data["data"]=$this->Mod_dashboard->tagiUserDetails($tagiDetails["user_id"]);
	 
	    if($data["data"]["status"] == "0" )
	    {
	        ?>
	        <script>
	            alert("Tagi is deactivated");
	        </script>
	        
	    <?php
	    die;
	    }
        /*$data["links"]=$this->Mod_dashboard->userLinks($user_id);
       
        $data["social_links"]=$this->Mod_dashboard->socialLinks();*/
        //$devicetype=$data["data"]["devicetype"];
        $result=$this->Mod_dashboard->tagiUserDetails($uid);
        $default_public_status=$result["default_public_status"];
        $default_private_status=$result["default_private_status"];
        $default_business_status=$result["default_business_status"];
        $user_id=$result["id"];
        $medicalDetails=$this->Mod_dashboard->medicalStatus($user_id);
        $totalTagiCount=$this->Mod_dashboard->totalUserTagiCount($user_id);
        $totalPoints=$this->Mod_dashboard->userTotalPoints($user_id);
        if($default_public_status == 1)
        {
            $type='UDP';
        }
        if($default_private_status == 1)
        {
            $type='UPP';
        }
        if($default_business_status == 1)
        {
            $type='UBP';
        }
        
        $profileUrl=$this->ProfileUrlEncode($uid,$type);
        $Time=time();
        $encodedTime = $this->encode($Time);
	    $url="https://tagmoi.co/read/tagiProfile/".$profileUrl."/".$encodedTime;
        ?>
        <html>
            <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
            <script> var arr =[]; 
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    </script>
    </head>
       <body>
            <script type="text/javascript">
                
                   function changeLink(applink) 
                    {
                        document.location.href=applink;
                    }
                    changeLink("<?php echo $url; ?>");
        </script>
        
            </body>
            </html>
          <?php  
    	}
	public function tagiProfile($profileLink,$encodedTime)
	{
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
	    
	    $decodeTime=$this->decode($encodedTime);
        $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
	    
	    $this->load->model("Mod_dashboard");
	    $result=$this->Mod_dashboard->tagiUserDetails($tagi_id);
        $default_public_status=$result["default_public_status"];
        $default_private_status=$result["default_private_status"];
        $default_business_status=$result["default_business_status"];
        $user_id=$result["id"];
        $medicalDetails=$this->Mod_dashboard->medicalStatus($user_id);
        $totalTagiCount=$this->Mod_dashboard->totalUserTagiCount($user_id);
        $totalPoints=$this->Mod_dashboard->userTotalPoints($user_id);
        $publicData=$this->Mod_dashboard->tagiDataList($user_id,$type);
        $data["user_id"]=$user_id;
        $data["first_name"]=$result["first_name"];
        $data["last_name"]=$result["last_name"];
        $data["user_name"]=$publicData["name"];
        $data["email"]=$result["email"];
        $data["description"]=$publicData["description"];
        $data["status"]=$publicData["status"];
        $data["user_medical_status"]=$medicalDetails["profile_status"];
        $data["direct_status"]=$publicData["direct_status"];
        $data["medical_status"]=$result["medical_status"];
        $data["type"]=$publicData["type"];
        $data["profile_image"]=$publicData["image"];
        $data["profile_status"]=$result["profile_status"];
        $data["devicetype"]=$result["devicetype"];
        $data["total_tagi"]=$totalTagiCount;
        $data["total_points"]=$totalPoints["points"];
        $data["medical_data"]=$this->Mod_dashboard->medicalStatus($user_id);
        $direct_status=$publicData["direct_status"];
        if($direct_status == 1)
        {
            $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
        }
        else
        {
            $data["social_links"]=$this->Mod_dashboard->tagiSocialLinksByDate($user_id,$type,$date_from_timestamp); 
        }
        $phone_number=$medicalDetails["mobile_number"];
        $phone_links=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Call');
        $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Whatsapp');
       
        if(!empty($phone_links))
        {
            $data["phone_number"]=$phone_links["link"];
        }
        else
        {
            $data["phone_number"]=$whatsapp_links['link'];
        }
	    $user_id=$result["user_id"];
	    $tagi=$this->Mod_dashboard->tagiID($tagi_id);
        $tagiid=$tagi['id'];
        //$link["links"]=$this->Mod_dashboard->userLinks($user_id);
        $link["social_icons"]=$this->Mod_dashboard->socialLinks();
    
        $this->load->view("profile",["data"=>$data,"link"=>$link]);
	}
	public function shareProfile($profileLink,$direct_status,$encodedTime)
	{
	    $seed = 1234567890;
        mt_srand($seed);
	    $url=$this->ProfileUrlDecode($profileLink,$seed);
	    $userId=substr($url,0,4);
	    $userProfileType=substr($url,4,7);
	    $profile_id=base64_decode($userId);
	    $profile_type=str_rot13($userProfileType);
	    $str_direct_status=str_rot13($direct_status);
        $decode_status=$this->directStatusDecode($str_direct_status,$seed);
        $status=base64_decode($decode_status);
        
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
	    
	    $decodeTime=$this->decode($encodedTime);
        $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
	    //$url="http://saurabh.parastechnologies.in/tagi/user/shareprofile?profile_link=".$profile_link."&type=".$profile_type;

	    $this->load->model("Mod_dashboard");
	    $result=$this->Mod_dashboard->tagiUserDetails($profile_id);
        $default_public_status=$result["default_public_status"];
        $default_private_status=$result["default_private_status"];
        $default_business_status=$result["default_business_status"];
        $user_id=$result["id"];
        $medicalDetails=$this->Mod_dashboard->medicalStatus($profile_id);
        $totalTagiCount=$this->Mod_dashboard->totalUserTagiCount($user_id);
        $totalPoints=$this->Mod_dashboard->userTotalPoints($user_id);
        $publicData=$this->Mod_dashboard->tagiDataList($user_id,$type);
        $data["user_id"]=$user_id;
        $data["first_name"]=$result["first_name"];
        $data["last_name"]=$result["last_name"];
        $data["user_name"]=$publicData["name"];
        $data["email"]=$result["email"];
        $data["description"]=$publicData["description"];
        $data["status"]=$publicData["status"];
        $data["user_medical_status"]=$medicalDetails["profile_status"];
        $data["direct_status"]=$status;
        $data["medical_status"]=$result["medical_status"];
        $data["type"]=$publicData["type"];
        $data["profile_image"]=$publicData["image"];
        $data["user_image"]=$result["profile_image"];
        $data["profile_status"]=$result["profile_status"];      
        
        $data["devicetype"]=$result["devicetype"];
        $phone_number=$medicalDetails["mobile_number"];
        $data["total_tagi"]=$totalTagiCount;
        $data["total_points"]=$totalPoints["points"];
        $data["medical_data"]=$this->Mod_dashboard->medicalStatus($profile_id);
        $direct_status=$publicData["direct_status"];
        if($status == 1)
        {
            $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
        }
        else
        {
            $data["social_links"]=$this->Mod_dashboard->tagiSocialLinksByDate($user_id,$type,$date_from_timestamp); 
        }
        
        //$data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type);
        $phone_call=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Call');
        $text_message=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Text Message');
        $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Whatsapp');
        if(!empty($phone_call))
        {
            $data["phone_number"]=$phone_call['link'];
        }
        else
        {
            $data["phone_number"]=$whatsapp_links['link'];
        }
	    $user_id=$result["user_id"];
	    $tagi=$this->Mod_dashboard->tagiID($tagi_id);
        $tagiid=$tagi['id'];
        //$link["links"]=$this->Mod_dashboard->userLinks($user_id);
        $link["social_icons"]=$this->Mod_dashboard->socialLinks();
        
        $this->load->view("profile",["data"=>$data,"link"=>$link]);
	}
	public function user($id,$username)
	{
	    $user_id=base64_decode($id);
	    $this->load->model("Mod_dashboard");
	    $data["data"]=$this->Mod_dashboard->tagiUserDetails($user_id);
	    $data["links"]=$this->Mod_dashboard->userLinks($user_id);
	    $data["social_links"]=$this->Mod_dashboard->socialLinks();
	    $this->load->view("user",$data);
	}
	public function qrprofiles($QR_Code,$profileLink)
	{
	    $Time=time();
        $encodedTime = $this->encode($Time);
        
        $url="https://tagmoi.co/read/qrcodeprofile/".$QR_Code."/".$profileLink."/".$encodedTime;
        ?>
        <html>
            <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
            <script> var arr =[]; 
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        </script>
        </head>
           <body>
                <script type="text/javascript">
                    
                       function changeLink(applink) 
                        {
                            document.location.href=applink;
                        }
                        changeLink("<?php echo $url; ?>");
            </script>
            
                </body>
                </html>
              <?php  
     
	}
	public function qrprofile($QR_Code,$profileLink,$encodedTime)
	{
	    /*$decodeTime=$this->decode($encodedTime);
        echo $decodeTime;
        echo "</br>";
         echo "</br>";
        $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
        echo $date_from_timestamp;
        */
	    $qrcode=$QR_Code;
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
	    /*echo $type;
	    die;*/
	    $seed = 1234567890;
        mt_srand($seed);
        /*$str_direct_status=str_rot13($direct_status);
        $decode_status=$this->directStatusDecode($str_direct_status,$seed);
        $status=base64_decode($decode_status);*/
	    
	    $decodeTime=$this->decode($encodedTime);
        $date_from_timestamp = date("Y-m-d H:i:s",$decodeTime);
	    $this->load->model("Mod_dashboard");
	    $data["data"]=$this->Mod_dashboard->qrcodeUserId($qrcode,$type);
	    $id=$data["data"]['id'];
	    $idd=base64_encode($id);
	    if($data["data"]["status"] == "0" )
	    {
	        ?>
	        <script>
	            alert("Tagi is deactivated");
	        </script>
	        
	    <?php
	    die;
	    }
        $tagi_id=$id;
        /*echo $tagi_id;
        die;*/
	    $result=$this->Mod_dashboard->tagiUserDetails($tagi_id);
        $user_id=$result["id"];
        $medicalDetails=$this->Mod_dashboard->medicalStatus($user_id);
        $totalTagiCount=$this->Mod_dashboard->totalUserTagiCount($user_id);
        $totalPoints=$this->Mod_dashboard->userTotalPoints($user_id);
       
        $publicData=$this->Mod_dashboard->tagiDataList($user_id,$type);
        $data["user_id"]=$user_id;
        $data["first_name"]=$result["first_name"];
        $data["last_name"]=$result["last_name"];
        $data["user_name"]=$publicData["name"];
        $data["email"]=$result["email"];
        $data["description"]=$publicData["description"];
        $data["status"]=$publicData["status"];
        $data["user_medical_status"]=$medicalDetails["profile_status"];
        $data["direct_status"]=$publicData["direct_status"];
        $data["medical_status"]=$result["medical_status"];
        $data["type"]=$publicData["type"];
        $data["profile_image"]=$publicData["image"];
        $data["profile_status"]=$result["profile_status"];
        $data["devicetype"]=$result["devicetype"];
        $data["total_tagi"]=$totalTagiCount;
        $data["total_points"]=$totalPoints["points"];
        $data["medical_data"]=$this->Mod_dashboard->medicalStatus($user_id);
        $direct_status=$publicData["direct_status"];
        if($direct_status == 1)
        {
            $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
        }
        else
        {
            $data["social_links"]=$this->Mod_dashboard->tagiSocialLinksByDate($user_id,$type,$date_from_timestamp); 
        }
        $phone_number=$medicalDetails["mobile_number"];
        $phone_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Call');
        
        $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Whatsapp');
        if(!empty($phone_links))
        {
            $data["phone_number"]=$phone_links["link"];
        }
        else
        {
            $data["phone_number"]=$whatsapp_links['link'];
        }
        $user_id=$result["user_id"];
	    $tagi=$this->Mod_dashboard->tagiID($tagi_id);
        $tagiid=$tagi['id'];
        //$link["links"]=$this->Mod_dashboard->userLinks($user_id);
        $link["social_icons"]=$this->Mod_dashboard->socialLinks();
    
        $this->load->view("profile",["data"=>$data,"link"=>$link]);	    
     
	}
	public function qrProfileDeatil($qrcode)
	{
	    $this->load->model("Mod_dashboard");
	    $result=$this->Mod_dashboard->qrcodeUserId($qrcode);
        $default_public_status=$result["default_public_status"];
        $default_private_status=$result["default_private_status"];
        $default_business_status=$result["default_business_status"];
        $user_id=$result["id"];
        $medicalDetails=$this->Mod_dashboard->medicalStatus($user_id);
        $totalTagiCount=$this->Mod_dashboard->totalUserTagiCount($user_id);
        $totalPoints=$this->Mod_dashboard->userTotalPoints($user_id);
        if($default_public_status == 1)
        {
            $type="Public";
            $publicData=$this->Mod_dashboard->tagiDataList($user_id,$type);
            $data["user_id"]=$user_id;
            $data["first_name"]=$result["first_name"];
            $data["last_name"]=$result["last_name"];
            $data["user_name"]= $publicData["name"];
            $data["email"]=$result["email"];
            $data["description"]=$publicData["description"];
            $data["status"]=$publicData["status"];
            $data["user_medical_status"]=$medicalDetails["profile_status"];
            $data["direct_status"]=$publicData["direct_status"];
            $data["medical_status"]=$result["medical_status"];
            $data["type"]=$publicData["type"];
            $data["profile_image"]=$publicData["image"];
            $data["profile_status"]=$result["profile_status"];
            $data["devicetype"]=$result["devicetype"];
            $data["phone_number"]=$medicalDetails["mobile_number"];
            $data["total_tagi"]=$totalTagiCount;
            $data["total_points"]=$totalPoints["points"];
            $data["medical_data"]=$this->Mod_dashboard->medicalStatus($user_id);
            $direct_status=$publicData["direct_status"];
            if($direct_status == 1)
            {
                $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
            }
            else
            {
                $data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type); 
            }  
        }
        if($default_private_status == 1)
        {
            $type="Private";
            $privateData=$this->Mod_dashboard->privateTagiList($user_id,$type);
             $data["user_id"]=$user_id;
            $data["first_name"]=$result["first_name"];
            $data["last_name"]=$result["last_name"];
            $data["user_name"]=$privateData["name"];
            $data["email"]=$result["email"];
            $data["description"]=$privateData["description"];
            $data["status"]=$privateData["status"];
            $data["user_medical_status"]=$medicalDetails["profile_status"];
            $data["direct_status"]=$privateData["direct_status"];
            $data["medical_status"]=$result["medical_status"];
            $data["type"]=$privateData["type"];
            $data["profile_image"]=$privateData["image"];
            $data["profile_status"]=$result["profile_status"];
            $data["devicetype"]=$result["devicetype"];
            $data["phone_number"]=$medicalDetails["mobile_number"];
            $data["total_tagi"]=$totalTagiCount;
            $data["total_points"]=$totalPoints["points"];
            $data["medical_data"]=$this->Mod_dashboard->medicalStatus($user_id);
            $direct_status=$privateData["direct_status"];
            if($direct_status == 1)
            {
                $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
            }
            else
            {
                $data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type); 
            } 
        }
        if($default_business_status == 1)
        {
            $type="Business";
            $businessData=$this->Mod_dashboard->businessTagiList($user_id,$type);
            $data["user_id"]=$user_id;
            $data["first_name"]=$result["first_name"];
            $data["last_name"]=$result["last_name"];
            $data["user_name"]=$businessData["name"];
            $data["email"]=$result["email"];
            $data["description"]=$businessData["description"];
            $data["status"]=$businessData["status"];
            $data["user_medical_status"]=$medicalDetails["profile_status"];
            $data["direct_status"]=$businessData["direct_status"];
            $data["medical_status"]=$result["medical_status"];
            $data["type"]=$businessData["type"];
            $data["profile_image"]=$businessData["image"];
            $data["profile_status"]=$result["profile_status"];
            $data["devicetype"]=$result["devicetype"];
            $data["phone_number"]=$medicalDetails["mobile_number"];
            $data["total_tagi"]=$totalTagiCount;
            $data["total_points"]=$totalPoints["points"];
            $data["medical_data"]=$this->Mod_dashboard->medicalStatus($user_id);
            $direct_status=$businessData["direct_status"];
            if($direct_status == 1)
            {
                $data["social_links"]=$this->Mod_dashboard->tagiDefaultSocialLinks($user_id,$type);
            }
            else
            {
                $data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type); 
            } 
        }

	    $user_id=$result["user_id"];
	    $tagi=$this->Mod_dashboard->tagiID($tagi_id);
        $tagiid=$tagi['id'];
        //$link["links"]=$this->Mod_dashboard->userLinks($user_id);
        $link["social_icons"]=$this->Mod_dashboard->socialLinks();
    
        $this->load->view("profile",["data"=>$data,"link"=>$link]);
	}
	public function testDate()
	{
	    /*$Time=time();
        echo $Time;
        $num = $Time;*/
        $encoded = "fYVdCB";
        
        echo "<br/> $num encoded = $encoded";
        // 3674 encoded = Ac
        
        echo "<br/> $encoded decoded = ".$this->decode($encoded);
        $decode=$this->decode($encoded);
        echo "<br/> ";
        $date_from_timestamp = date("Y-m-d H:i:s",$decode);
        echo $date_from_timestamp;
        // Ac decoded = 3674
	}
}
    