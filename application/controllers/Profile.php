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
    public function profiles($tag_id="")
	{
	    $id=$_GET["tag_id"];
	    $tagi_id=base64_decode($id);
	    
	    $this->load->model("Mod_dashboard");
	    $data["data"]=$this->Mod_dashboard->tagiUserDetails($tagi_id);
	    if($data["data"]["status"] == "0" )
	    {
	        ?>
	        <script>
	            alert("Tagi is deactivated");
	        </script>
	        
	    <?php
	    die;
	    }
        $data["links"]=$this->Mod_dashboard->userLinks($user_id);
       
        $data["social_links"]=$this->Mod_dashboard->socialLinks();
        //$devicetype=$data["data"]["devicetype"];
        $url="https://tagmoi.co/read/tagiProfile/$id";
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
        /*function changeLink(applink) 
        {
            document.location.href=applink;
        }

   
        if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) 
        {
            changeLink("profiletagi://saurabh.parastechnologies.in?user_id=<?php echo $user_id;?>");
            	setInterval(function () {
                          window.location.replace("<?php echo $url; ?>");
                  }, 6000);
        }
        else if( userAgent.match( /Android/i ) )
        {
          changeLink("tagi1://details?email_id=+<?php echo $user_id;?>+");
           setInterval(function () {
                      window.location.replace("<?php echo $url; ?>");
              }, 2000);
             
        }
        else
        {
            changeLink("tagi1://details?email_id=+<?php echo $user_id;?>+");
            //changeLink("<?php echo $url; ?>");
        }*/
        </script>
        
        <script type="text/javascript">
            
               function changeLink(applink) 
                {
                    document.location.href=applink;
                }
                /*if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) 
                {
                    changeLink("tagi://saurabh.parastechnologies.in?user_id=<?php echo $user_id;?>");
                    	setInterval(function () {
                                  window.location.replace("<?php echo $url; ?>");
                          }, 6000);
                }*/
               /* else if( userAgent.match( /Android/i ) )
                {
                    Swal.fire({
                      title: 'Open this page in "Tagi_App"?',
                      //text: "You won't be able to revert this!",
                      //icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Open'
                    }).then((result) => {
                      if (result.isConfirmed) {
                          changeLink("tagi1://details?email_id=+<?php echo $user_id;?>+");
                          setInterval(function () {
                              window.location.replace("<?php echo $url; ?>");
                      }, 2000);
                      }
                      else
                      {
                          setInterval(function () {
                              window.location.replace("<?php echo $url; ?>");
                      }, 2000);
                      }
                    })
                     
                   
                     
                }*/
                
                    changeLink("<?php echo $url; ?>");
                
            
             
            
    </script>
    
        </body>
        </html>
      <?php  
	}
	public function tagiProfile($tag_id)
	{
	    $tagi_id=base64_decode($tag_id);
	    $this->load->model("Mod_dashboard");
	    $result=$this->Mod_dashboard->tagiUserDetails($tagi_id);
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
                $data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type); 
            }
            $phone_number=$medicalDetails["mobile_number"];
            $phone_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Call');
            $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Whatsapp');
            if(!empty($phone_number))
            {
                $data["phone_number"]=$medicalDetails["mobile_number"];
            }
            elseif(!empty($phone_links))
            {
                $data["phone_number"]=$phone_links;
            }
            else
            {
                $data["phone_number"]=$whatsapp_links;
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
            $phone_number=$medicalDetails["mobile_number"];
            $phone_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Call');
            $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Whatsapp');
            if(!empty($phone_number))
            {
                $data["phone_number"]=$medicalDetails["mobile_number"];
            }
            elseif(!empty($phone_links))
            {
                $data["phone_number"]=$phone_links;
            }
            else
            {
                $data["phone_number"]=$whatsapp_links;
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
            $phone_number=$medicalDetails["mobile_number"];
            $phone_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Call');
            $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($id,$type,'Whatsapp');
            if(!empty($phone_number))
            {
                $data["phone_number"]=$medicalDetails["mobile_number"];
            }
            elseif(!empty($phone_links))
            {
                $data["phone_number"]=$phone_links;
            }
            else
            {
                $data["phone_number"]=$whatsapp_links;
            }
        }
	    $user_id=$result["user_id"];
	    $tagi=$this->Mod_dashboard->tagiID($tagi_id);
        $tagiid=$tagi['id'];
        //$link["links"]=$this->Mod_dashboard->userLinks($user_id);
        $link["social_icons"]=$this->Mod_dashboard->socialLinks();
    
        $this->load->view("profile",["data"=>$data,"link"=>$link]);
	}
	public function shareProfile($profile_link="",$type="")
	{
	    $profile_link=$_GET["profile_link"];
	    $profile_type=$_GET["type"];
	     $profile_id=base64_decode($profile_link);
	    $type=base64_decode($profile_type);
	    //$url="http://saurabh.parastechnologies.in/tagi/user/shareprofile?profile_link=".$profile_link."&type=".$profile_type;

	    $this->load->model("Mod_dashboard");
	    $result=$this->Mod_dashboard->tagiUserDetails($profile_id);
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
        $phone_number=$medicalDetails["mobile_number"];
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
        //$data["social_links"]=$this->Mod_dashboard->tagiSocialLinks($user_id,$type);
        $phone_call=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Call');
        $text_message=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Text Message');
        $whatsapp_links=$this->Mod_dashboard->contactTagiSocialLinks($user_id,$type,'Whatsapp');
        if(!empty($phone_call))
        {
            $data["phone_number"]=$phone_call['link'];
        }
        elseif(!empty($text_message))
        {
            $data["phone_number"]=$text_message['link'];
        }
        elseif(!empty($whatsapp_links))
        {
            $data["phone_number"]=$whatsapp_links['link'];
        }
        else
        {
            $data["phone_number"]=$phone_number;
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
	public function qrprofiles($user_id="",$qrcode="")
	{
	    $qrcode=$_GET["qrcode"];
	    $this->load->model("Mod_dashboard");
	    $data["data"]=$this->Mod_dashboard->qrcodeUserId($qrcode);
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
	    
        $url="https://tagmoi.co/read/tagiProfile/$idd";
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
}
    