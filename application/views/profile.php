<?php
    $links=$data["social_links"];
    $social_links=$link["social_icons"];
    if($data["profile_status"] == 1)
    {
        if($data["direct_status"] ==1)
        {
            foreach($links as $link)
            {   
                foreach($social_links as $sl)
                {
                    if($link["type"] == $sl["type"])
                    {
                        if($link["type"] == "Facebook")
                        {
                            $messangerLink=$link['profile_url'];
                            $mlink=explode("id=",$messangerLink);
                            if(!empty($mlink[1]))
                            {
                                $profileUrl=$mlink[1];
                            }
                            else
                            {
                                $mlink2=explode("https://www.facebook.com/",$messangerLink);
                                $profileUrl=$mlink2[1];
                            }
                            ?>
                        <a id="autotrigger" onclick="social('<?php echo $link['profile_url']; ?>','<?php echo $sl['linking_url']; ?>','<?php echo $_GET['profile_link']; ?>','<?php echo base_url(); ?>','<?php echo $_GET['type']; ?>','<?php echo $profileUrl ?>')" ></a>
                        <?php
                        }
                        elseif($link["type"] == "Telegram")
                        {
                            ?>
                                <a id="autotrigger" href="<?php echo $link['profile_url']; ?>" ></a>
                            <?php
                        }
                        elseif($link["type"] == "Calendly")
                        {
                            $url=ltrim($link['profile_url']);
                            if(strpos($url, "http://") !== false || strpos($url, "https://") !== false)
                            {
                                $profileUrl=$url;
                            }
                            else
                            {
                                $profileUrl="https://".$url;
                            }
                            ?>
                                <a id="autotrigger" href="<?php echo $profileUrl; ?>" ></a>
                            <?php
                        }
                        elseif($link["type"] == "Skype")
                        {
                            ?>
                        <a id="autotrigger" href="<?php echo "skype:".$link['link']."?chat"; ?>" ></a>
                        <?php
                        }
                        elseif($link["type"] == "Messanger")
                        {
                            $messangerLink=$link['profile_url'];
                            if(strpos($messangerLink, "http://") !== false || strpos($messangerLink, "https://") !== false)
                            {
                                $mlink=explode("id=",$messangerLink);
                                if(!empty($mlink[1]))
                                {
                                    $profileUrl="http://m.me/".$mlink[1];
                                }
                                else
                                {
                                    $mlink2=explode("https://www.facebook.com/",$messangerLink);
                                    $profileUrl="http://m.me/".$mlink2[1];
                                }
                            }
                            else
                            {
                                $profileUrl="http://m.me/".$url;
                            }
                            ?>
                        <a id="autotrigger" href="<?php echo $profileUrl; ?>" ></a>
                        <?php
                        }
                        elseif($link["type"] == "Location")
                        {
                            $string = $link['profile_url'];
                            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string,$b);
                            $location= implode(" ",$b[0]);
                            ?>
                        <a id="autotrigger" href="<?php echo $location; ?>" ></a>
                        <?php
                        }
                        elseif($link["type"] == "FaceTime")
                        {
                            ?>
                            
                            <a id="autotrigger" href="<?php echo $link['profile_url']; ?>" ></a>
                            
                        <?php
                        }
                        elseif($link["type"] == "Signal")
                        {
                            ?>
                        <!--<a target="_blank" onclick="Signal('<?php// echo $link['profile_url']; ?>','<?php// echo $sl['linking_url']; ?>','<?php// echo $_GET['profile_link']; ?>','<?php// echo base_url(); ?>')" ><img src="<?php// echo base_url().$sl["image"] ?>" ><br><span><?php// echo $sl["type"]; ?></span></a>-->
                            <a id="autotrigger" href="https://signal.org/en/" ></a>
                        <?php
                        }
                        else
                        {
                ?>
                    <a id="autotrigger" href="<?php echo $link['profile_url']; ?>" ></a>
                <?php
                        }
                        
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>TagMoi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vcard.js"> </script>
    <script> var arr =[]; 
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        
    </script>
    <script>
    $("#autotrigger")[0].click()
    </script>
  </head>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600&display=swap');
    body {
    margin: 0;
    padding: 0;
    width: 100%;
    }
    .info-wrap {
    width: 40%;
    margin: 0 auto;
    box-shadow: 0px 10px 15px rgb(0 0 0 / 30%);
}
.profile-lock {
    text-align: center;
    background: #fff;
    margin-top: -100px;
    position: relative;
    width: 100%;
    height: 200px;
    padding-top: 100px;
}
.center-text {
    width: 40%;
    margin: 0px auto;
    display: flex;
}
    .wrapper {
    width: 100%;
    margin: 0 auto;
    padding: 0;
    font-size: 16px;
    font-family: 'Roboto', sans-serif;
    background: #ffffff;
    }
    .header {
    overflow: hidden;
    display: flex;
    margin: 0;
    background: #512d6b;
}
.header a{
    display: inline-block;
    color: #fff;
    padding: 32px 8px;
    text-decoration: none;
    font-family: 'Poppins', sans-serif !important;
}
   .header img {
    display: block;
    text-align: center;
    margin: auto;
}
   
  
   .profile .img-left img {
    width: 100%;
    height: auto;
}

   .profile-data h2 {
    margin: 0 0 10px;
    font-size: 27px;
    color: #512d6b;
    font-family: 'Playfair Display', serif;
}
   .profile-data p {
    font-family: 'Poppins', sans-serif !important;
    color: #858587;
    line-height: 22px;
    margin: 0 0 15px;
    font-size: 16px;
}
    .buttons {
    margin-top: 12px;
    }
    .links a {
    display: inline-block;
    text-decoration: none;
    width: 32%;
    text-align: center;
    }
    .links span {
        text-align: center;
        display: block;
        margin: -10px 0 0px;
        font-size: 14px;
        color: #707070;
        font-family: 'Poppins', sans-serif !important;
    }
    .links img {
    width: 80%;
    margin: 20px;
    box-shadow: 0px 2px 23px rgb(0 0 0 / 30%);
    border-radius: 34px;
    }
 
.buttons a{font-family: 'Raleway', sans-serif;margin:0 0 10px;}
a.btn.btn-primary {
    background: #512d6b;
    padding: 10px 22px;
    color: #ffffff;
    font-weight: 500;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    margin-right: 7px;
    vertical-align: top;
}
button.btn.btn-primary.medical {
    background: #ca0b0d;
    color: #fff;
    border: 0;
    padding: 11px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-family: 'Raleway', sans-serif;
}
.medical img {
  width: 18%;
  margin: -3px 5px 0 0;
  vertical-align: middle;
}
.status {
  background: #f4f3f4;
  font-family: 'Poppins', sans-serif !important;
  padding: 1px 8px;
}
.status p {
  font-size: 14px;
  margin: 5px 0 0;
}
.profile-data {
    text-align: center;
    margin: 10px 0 20px;
    padding: 0 15px;
}
p strong{color: #512d6b; }
p.grey{color: #858587; }
p.green{color: #c5db3a; }
.links {
    padding: 10px 0;
    overflow: hidden;
}
a.btn-primary.download-link {
  padding: 15px;
  border: 0;
  font-size: 14px;
  font-family: 'Poppins', sans-serif !important;
  color: #512d6b;
  background: #f5f5f5;
  display: block;
  overflow: hidden;
  text-align: center;
}
.id-card h2 {
  margin: 0;
  font-size: 18px;
  color: #ffffff;
  font-family: 'Playfair Display', serif;
}
.id-card .profile {
    display: flex;
    padding: 0;
}
.id-card .m-0 {
    margin: 0;
    font-size: 13px;
    line-height: 15px;
    font-family: 'Poppins', sans-serif !important;
    font-weight: 400;
}
.id-card {
    background: #512d6b !important;
    border-radius: 6px 6px 0 0;
    padding: 8px;
    color: #fff;
}
.id-card img{overflow: hidden;
    width: 80%;}
.id-card strong, span {
    font-size: 12px;
    font-family: 'Poppins', sans-serif !important;
}
.id-card strong {
    font-weight: 400;
}
.id-card span {
    font-weight: 100;
}
.red-wrap {
    background: #ca0b0d;
    border-radius: 0px 0px 6px 6px;
    text-align: center;
    padding: 8px 0;
    font-family: 'Playfair Display', serif;
}
.red-wrap p {
    margin: 0;
    display: inline-block;
    color: #fff;
    text-align: center;
}
.red-wrap img {
    width: 10%;
    margin-right: 5px;
    vertical-align: middle;
}
.details{display: flex;}
.details .left-part{width: 50%}


/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 30px 10px 10px;
    width: 30%;
}
/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-weight: bold;
    top: -18px;
    position: relative;
    right: -2px;
}
.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
#bankdetails .modal-body {
    padding: 15px;
    font-family: 'Raleway', sans-serif;
}
#bankdetails .modal-footer {
    padding: 0 15px 15px;
}
.modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
    background: rgba(0,0,0,0.67);
}
#bankdetails .close {
    color: #fff;
    float: right;
    font-weight: bold;
    top: 10px;
    position: absolute;
    right: 15px;
    background: transparent;
    box-shadow: none;
    border: 0;
    font-size: 40px;
    outline: none;
}
#bankdetails .modal-dialog {
    width: 100%;
    margin-top: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
#bankdetails .modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 0;
    width: 100%;
    border-radius: 6px;
    box-shadow: 0px 3px 26px rgb(33 30 30 / 40%);
}
#bankdetails  h4.modal-title {
    margin: 0;
    color:#fff;
}
#bankdetails .modal-header {
    background: #512d6b;
    padding: 15px 30px;
    text-align: center;
    font-family: 'Raleway', sans-serif;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    position:relative;
}
#bankdetails .form-group {
    display: block;
    width: 100%;
}
#bankdetails label {
    display: block;
    font-size: 14px;
}
#bankdetails input.form-control {
    width: 100%;
    margin: 10px 0;
    border: 1px solid #dadada;
    height: 36px;
    font-family: 'Raleway', sans-serif;
    padding: 0 12px;
}
#bankdetails .btn-primary{
    background: #512d6b;
    padding: 8px 22px;
    color: #ffffff;
    font-weight: 500;
    text-decoration: none;
    border-radius: 30px;
    font-size: 15px;
    margin-right: 7px;
    vertical-align: top;
    box-shadow: none;
    border: 0;
    font-family: 'Raleway', sans-serif;
  }
.modal-backdrop{
    display:none;
}

.profile-image {
    width: auto;
    margin: 0px 15px 6px 15px;
    margin-right: 10px;
}
.profile-image img {
    overflow: hidden;
    width: 100px !important;
    height: 100px;
    object-fit: contain !important;
}
span.close img {
    float: right;
}

a.btn.btn-primary.download-link {
    margin: 0;
    border-radius: 0px;
}
.intro
{
    width: 100%;
}

#Stcpaydetails  .modal-content {
    margin: 10% auto;
    padding: 0px;
    width: 100%;
}
#Stcpaydetails .modal-header {
    position: relative;
}

#Stcpaydetails .modal-body img {
    display: block;
    margin: 0 auto;
}

#Stcpaydetails .btn{margin: 0 auto;}
.profile-image img {
    overflow: hidden;
    width: 100px !important;
}
#Stcpaydetails .modal-header {
    position: relative;
    background: #512d6b;
}
#Stcpaydetails h4.modal-title {
    text-align: center;
    display: block;
    width: 100%;
    color: #ffffff !important;
    font-weight: 500;
    font-family: 'Raleway', sans-serif;
}
#Stcpaydetails .modal-header .close {
    position: absolute;
    top: 20px !important;
    right: 20px !important;
    color: #fff !important;
    outline: none;
}
#Stcpaydetails .modal-dialog {
    -webkit-transform: none;
    transform: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    margin: 0px;
}

#Stcpaydetails .modal-body img {
    display: block;
    margin: 12px auto 0 !important;
    border-radius: 10px !important;
    width:50%;
}
.links {
    padding: 10px 0 10px 10px;
    overflow: hidden;
}
.body{padding:0px !important;}
#myModal .modal-content {
    margin: 0 auto;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
#block .profile-lock {
    text-align: center;
    background: #fff;
    margin-top: 0px;
    position: relative;
    width: 100%;
    height: 200px;
    padding-top: 50px;
}
#block .modal-content {
    width: 100%;
    margin: 0px;
    font-family: 'Raleway', sans-serif;
}
#block .modal-dialog {
    max-width: 40%;
    bottom: -50px;
    position: absolute;
    left: 30%;
    width: 100%;
    margin: 0;
    font-family: 'Raleway', sans-serif;
}
#block .modal-content img {
    width: auto !important;
    box-shadow: none;
    border-radius: 0;
}
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
@media screen and (max-width:768px) {
  .center-text {width: 100%; }
  .info-wrap {width: 100%; }
  a.btn.btn-primary {padding: 10px 10px; }
  button.btn.btn-primary.medical {padding: 10px 10px; }
  #block .modal-dialog {
    max-width: 100%;
      left:0;
  }
}

@media screen and (max-width:480px) {
    .buttons a.btn.btn-primary, .buttons button {
    width: 100%;
}
.medical img {
    width: 11%;
}
  .modal-content {
    width: 93%;
  }
  .links img {
    border-radius: 25px;
  }
  .links img {
    margin: 15px 0;
    box-shadow: 0px 2px 15px rgb(0 0 0 / 30%);
}
   .profile-image img {
    width: 60px !important;
}
  .id-card h2 {
    font-size: 14px;}
    
   #bankdetails .modal-dialog, #Stcpaydetails .modal-dialog{
    width: 95%;
    margin: 0;
}
#bankdetails h4.modal-title, #Stcpaydetails h4.modal-title {
    margin: 0;
    color: #fff;
    font-size: 15px !important;
}
#bankdetails .modal-header {
    padding: 15px;
}
#bankdetails .close {
    font-size: 30px;
}
#Stcpaydetails .btn {
    margin: 0 auto;
    width: 100%;
}
#Stcpaydetails .modal-body img {
    margin: 0 !important;
    width: 100%;
}
#Stcpaydetails .modal-body {
    padding-bottom: 0px !important;
}
}
</style>
  <body style="padding-right:0 !important">
    <div class="wrapper">
       <div class="content-wrap">
         <div class="top-header">
          <a class="btn btn-primary download-link" onclick="downloadApp()" id="downloadApp"></a>          
          <div class="header">
            <div class="center-text">              
              <a href="#" id="login" onclick="downloadApp()">Log In</a>
              <img src="<?php echo base_url(); ?>images/web-logo.svg" style="margin:5px auto;width:80px">
              <a href="#" id="signup" onclick="downloadApp()" >Sign Up</a>
              
            </div>
          </div>
         </div>
         
         <div class="info-wrap">
           <div class="profile">
           <div class="img-left">
             <?php
               if($data["profile_image"])
               {
                   ?>
                   <img src="<?php echo base_url(); ?>profileImages/<?php echo $data["profile_image"]; ?>">
                   <?php
               }
               else
               {
               ?>
                    <img src="<?php echo base_url(); ?>profileImages/dummy.png">
               <?php
               }
               ?>
           </div>

           <div class="profile-data">
             <h2><?php echo $data["user_name"]; ?></h2>
             <p><?php echo $data["description"]; ?></p>
             <div class="buttons">
                 <?php
                 $profilePhoto=$data["profile_image"];
                 ?>
              <a class="btn btn-primary" target="_blank" href="<?php echo 'http://massage.parastechnologies.in/vcard/VcardExport.php?name='.$data['user_name'].'&phone='.$data["phone_number"].'&photo='.$profilePhoto; ?>"><b id="add_to_contact"> </b></a>
              <?php 
             if($data["medical_status"] == 1)
             {
             ?>
                <button id="myBtn" href="#" class="btn btn-primary medical" style="<?php if($data['user_medical_status'] == 0){ echo 'pointer-events: none;'; } ?>"><img src="<?php echo base_url(); ?>images/medical-icon.png"><b id="medical_id"></b></button>
            <?php
             }
            ?>
            </div>
           </div>
           <div class="clearfix" style="clear: both;"></div>
          </div>

           <div class="status">
            <p class="grey">TagMoi Points:<strong> <?php if(!empty($data["total_points"])){ echo $data["total_points"]; }else{ echo "0"; } ?></strong></p>
           </div>

           <div class="links">
             <?php
            if($data["profile_status"] == 1)
            {
                foreach($links as $link)
                {
                    foreach($social_links as $sl)
                    {
                        if($link["type"] == $sl["type"])
                        {
                            if(!empty($sl["linking_url"]))
                            {
                                if($link["type"] == "Facebook")
                                {
                                    $messangerLink=$link['profile_url'];
                                    $mlink=explode("id=",$messangerLink);
                                    if(!empty($mlink[1]))
                                    {
                                        $profileUrl=$mlink[1];
                                    }
                                    else
                                    {
                                        $mlink2=explode("https://www.facebook.com/",$messangerLink);
                                        $profileUrl=$mlink2[1];
                                    }
                                    ?>
                                <a target="_blank" onclick="social('<?php echo $link['profile_url']; ?>','<?php echo $sl['linking_url']; ?>','<?php echo $_GET['profile_link']; ?>','<?php echo base_url(); ?>','<?php echo $_GET['type']; ?>','<?php echo $profileUrl ?>')" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                <?php
                                }
                                elseif($link["type"] == "Bank")
                                {
                                    ?>
                                    <a class="border-btn read-more-click bank_details" href="#" data-toggle="modal" data-target="#bankdetails"><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="bankdetails" role="dialog">
                                    <div class="modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title" id="long_press"></h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="card-box mb-3">
                                           <input type="hidden" name="userId" value="118">
                                             <div class="row">
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label id="bank_name" ></label>
                                                  <input type="text" class="form-control" placeholder="Bank Name" value="<?php echo $link['link']; ?>">
                                                </div>                        
                                              </div>
                                
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label id="account_number2"></label>
                                                  <input type="text" class="form-control" placeholder="Account Number" value="<?php echo $link['link2']; ?>">
                                                </div>                        
                                              </div>             
                                               
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                    <?php
                                }
                                elseif($link["type"] == "Bank2")
                                {
                                    
                                    ?>
                                    <a class="border-btn read-more-click bank_details" href="#" data-toggle="modal" data-target="#bankdetails"><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="bankdetails" role="dialog">
                                    <div class="modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title" id="long_press"></h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="card-box mb-3">
                                           <input type="hidden" name="userId" value="118">
                                             <div class="row">
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label id="bank_name"></label>
                                                  <input type="text" class="form-control" placeholder="Bank Name" value="<?php echo $link['link']; ?>">
                                                </div>                        
                                              </div>
                                
                                              <div class="col-sm-12">
                                                <div class="form-group">
                                                  <label id="account_number" ></label>
                                                  <input type="text" class="form-control" placeholder="Account Number" value="<?php echo $link['link2']; ?>">
                                                </div>                        
                                              </div>             
                                               
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                    <?php
                                }
                                elseif($link["type"] == "Stcpay")
                                {
                                    ?>
                                    <a class="border-btn read-more-click bank_details" href="#" data-toggle="modal" data-target="#Stcpaydetails"><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="Stcpaydetails" role="dialog">
                                    <div class="modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Stc Pay</h4>
                                        </div>
                                        <div class="modal-body">
                                          <div class="card-box mb-3">
                                           <input type="hidden" name="userId" value="118">
                                             <div class="row">
                                              <div class="col-sm-12">
                                                <img src="<?php echo $link['link']; ?>">                       
                                              </div>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <a class="btn btn-primary" href ="<?php echo $link['link']; ?>" download >Download</a>
                                        </div>
                                      </div>
                                      
                                    </div>
                                    </div>
                                    <?php
                                }
                                elseif($link["type"] == "Telegram")
                                {
                                    ?>
                                        <a target="_blank" id="tl_btn" href="<?php echo $link['profile_url']; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    <?php
                                }
                                elseif($link["type"] == "Calendly")
                                {
                                    $url=ltrim($link['profile_url']);
                                    if(strpos($url, "http://") !== false || strpos($url, "https://") !== false)
                                    {
                                        $profileUrl=$url;
                                    }
                                    else
                                    {
                                        $profileUrl="https://".$url;
                                    }
                                    ?>
                                        <a target="_blank" id="tl_btn" href="<?php echo $profileUrl; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    <?php
                                }
                                elseif($link["type"] == "Skype")
                                {
                                    ?>
                                <a target="_blank" href="<?php echo "skype:".$link['link']."?chat"; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                <?php
                                }
                                elseif($link["type"] == "Messanger")
                                {
                                    $messangerLink=$link['profile_url'];
                                    if(strpos($messangerLink, "http://") !== false || strpos($messangerLink, "https://") !== false)
                                    {
                                        $mlink=explode("id=",$messangerLink);
                                        if(!empty($mlink[1]))
                                        {
                                            $profileUrl="http://m.me/".$mlink[1];
                                        }
                                        else
                                        {
                                            $mlink2=explode("https://www.facebook.com/",$messangerLink);
                                            $profileUrl="http://m.me/".$mlink2[1];
                                        }
                                    }
                                    else
                                    {
                                        $profileUrl="http://m.me/".$url;
                                    }
                                    ?>
                                <a target="_blank" href="<?php echo $profileUrl; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                <?php
                                }
                                elseif($link["type"] == "Location")
                                {
                                    $string = $link['profile_url'];
                                    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string,$b);
                                    $location= implode(" ",$b[0]);
                                    ?>
                                <a target="_blank" href="<?php echo $location; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                <?php
                                }
                                elseif($link["type"] == "FaceTime")
                                {
                                    ?>
                                    
                                    <a  id="disable" href="<?php echo $link['profile_url']; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                    
                                <?php
                                }
                                elseif($link["type"] == "Signal")
                                {
                                    ?>
                                <!--<a target="_blank" onclick="Signal('<?php// echo $link['profile_url']; ?>','<?php// echo $sl['linking_url']; ?>','<?php// echo $_GET['profile_link']; ?>','<?php// echo base_url(); ?>')" ><img src="<?php// echo base_url().$sl["image"] ?>" ><br><span><?php// echo $sl["type"]; ?></span></a>-->
                                    <a target="_blank" href="https://signal.org/en/" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                                <?php
                                }
                                else
                                {
                        ?>
                            <a target="_blank" href="<?php echo $link['profile_url']; ?>" ><img src="<?php echo base_url().$sl["image"] ?>" ><br><span><?php echo $sl["type"]; ?></span></a>
                        <?php
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                ?>
                <div class="modal fade" id="block" role="dialog" style="display:block; opacity:1 !important">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body">
                      <div class="profile-lock">
                        <h2 style="margin:0px"><img src="<?php echo base_url(); ?>images/lock.png"></h2>
                        <h2 style="margin:0px" id="profile_off" ></h2>
                        
                    </div>
                    </div>
                    
                  </div>
                  
                </div>
                </div>
                <?php
            }
            ?>
         </div>
         </div>         

      </div>

      <!-- The Modal -->
      <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close1 close "><img src="<?php echo base_url(); ?>images/close.png"></span>
          <div class="id-card">

           <div class="row">
            <div class="profile">
              <div class="profile-image">
                <?php
                  if(!empty($data["medical_data"]["profile_image"]))
                  {
                  ?>
                    <img src="/tagi/profileImages/<?php echo $data["medical_data"]["profile_image"]; ?>" style="object-fit: contain;" >                
                  <?php
                  }
                  else
                  {
                      ?>
                      <img src="/tagi/profileImages/dummy.png" >
                      <?php
                  }
                ?>               
              </div>
              <div class="name-block">
                <h2><?php echo $data["medical_data"]["first_name"]." ".$data["medical_data"]["last_name"]; ?></h2>
                <p class="m-0"><?php echo $data["medical_data"]["city"].", ".$data["medical_data"]["state"]." ".$data["medical_data"]["country"]; ?></p>                
              </div>
            </div>
            
            <div class="intro">
              <div class="col">
               <strong>Alergies & Reactions:</strong><span> <?php echo $data["medical_data"]["allergies_reactions"]; ?></span><br>
               <strong>Medical Condition:</strong><span> <?php echo $data["medical_data"]["medical_condition"]; ?></span><br>
               <strong>Medications:</strong><span> <?php echo $data["medical_data"]["medications"]; ?></span><br>               
              </div>

              <div class="col details">
                <div class="left-part">
                 <strong>D.O.B: </strong><span> <?php echo $data["medical_data"]["dob"]; ?></span><br>
                 <strong>Blood Type: </strong><span> <?php echo $data["medical_data"]["blood_type"]; ?></span><br>
                 <strong>Weight: </strong><span> <?php echo $data["medical_data"]["weight"]; ?></span><br>
                 <strong>Height: </strong><span> <?php echo $data["medical_data"]["height"]; ?></span><br>                  
                </div>

                <div class="right-part">
                 <strong>Emergency Contacts:</strong><br>
                 <span><?php echo $data["medical_data"]["name"]; ?> </span><br>                  
                 <span><?php echo $data["medical_data"]["relation_type"]; ?></span><br>                  
                 <span><?php echo $data["medical_data"]["mobile_number"]; ?></span>                 
                </div>

              </div>
            </div>

           </div>
          </div>
           <div class="red-wrap"><p><img src="<?php echo base_url(); ?>images/medical-icon.png">Emergency Medical ID Card</p></div>
        </div>
      </div>

    </div>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var span = document.getElementsByClassName("close1")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<script>

    function social(link,linking_url,profile_link,server_url,type,profileUrl)
    {
        if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) 
        {
            // console.log(window.location.origin,"wqeqwe");
            let url = server_url+'user/shareprofile?profile_link='+profile_link+'&type='+type;
            let url1 = '';
            let check = 0;
            
            function changeLink(applink,) 
            {
               window.open(applink, "_blank");
            }
            changeLink("fb://profile/?id="+profileUrl);
            setInterval(function () {
                window.location.replace(url);
            }, 2000);
        }
        else
        {
            // console.log(window.location.origin,"wqeqwe");
            let url = server_url+'user/shareprofile?profile_link='+profile_link+'&type='+type;
            let url1 = '';
            let check = 0;
            
            function changeLink(applink,) 
            {
               window.open(applink, "_blank");
            }
            changeLink(linking_url+link);
            setInterval(function () {
                window.location.replace(url);
            }, 2000);
        }
    }
    function Signal(link,linking_url,profile_link,server_url)
    {
       // console.log(window.location.origin,"wqeqwe");
        let url = "https://signal.org/en/";
        let url1 = '';
        let check = 0;
        
        function changeLink(applink,) 
        {
           window.open(applink, "_blank");
        }
        changeLink("org.thoughtcrime.securesms://sms=987878787");
        setInterval(function () {
            window.location.replace(url);
        }, 2000);    
    }
    
    function addContact(name,address,phone,photo)
    {
        dataString = 'name='+ name+'&address='+ address+'&phone='+ phone+'&photo='+ photo;
        $.ajax({ 
              type: 'post',    
              url: '<?php echo base_url() ?>dashboard/creatVcard',
              data: dataString,
              cache: false,
              success: function(res) {
              console.log(res);
                  if(res == 2){
                      Swal.fire(
                        'Success',
                        'Tag Active Successfully',
                        'success'
                      ).then((result) => {
                if (result.value) {
                    
                    window.location.reload();
                  }
                  })      
                      
                  }
                  if(res == 1){
                      Swal.fire(
                        'Success',
                        'Tag Disactive Successfully',
                        'success'
                      ).then((result) => {
                if (result.value) {
                    
                    window.location.reload();
                  }
                  })   
                  }
                  if(res == 0)
                  {
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                      })
                  }
              }
          });
    }
    </script>
<script>
    function downloadApp()
    {
        function changeLink(applink,) 
        {
            window.location.href=applink;
        }
        changeLink("tagi://details?user_id=+<?php echo $data["user_id"];?>+");
      setInterval(function () {
                  window.location.replace("http://play.google.com/store/apps/details?id=com.tagi");
          }, 2000);
    }
</script>
<script type="text/javascript">
var userLang = navigator.language || navigator.userLanguage; 
var a= userLang.split('-');

if(a[0] == 'ar')
{
    $("#downloadApp").text("اظغط هنا لتنزيل التطبيق والحصول على شريحة تاغ موا الخاصة بك");
    $("#login").text("تسجيل الدخول");
    $("#signup").text("انشاء حساب");
    $("#long_press").text("اضغط لفترة طويلة لنسخ تفاصيل البنك");
    $("#bank_name").text("إسم البنك");
    $("#account_number").text("رقم الايبان / الحساب");
    $("#account_number2").text("رقم الايبان / الحساب");
    $("#medical_id").text("الهوية الطبية");
    $("#add_to_contact").text("إضافة الإتصال"); 
    $("#profile_off").text("البروفايل مقفل");
    
}
else
{
    $("#downloadApp").text("Click here to Downlaod the app and get your TagMoi");
    $("#login").text("Log In");
    $("#signup").text("Sign Up");
    $("#long_press").text("Long Press To Copy Bank Details");
    $("#bank_name").text("Bank Name");
    $("#account_number").text("Account Number");
    $("#account_number2").text("Account Number");
    $("#medical_id").text("Medical ID");
    $("#add_to_contact").text("Add to Contact");
    $("#profile_off").text("The Profile is Off");
}
</script>
<script>
    if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) 
    {
        
    }
    else
    {
        document.getElementById("disable").style = "pointer-events: none";
    }
    
</script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
  </body>
</html>