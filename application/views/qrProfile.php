<?php
    $links=$data["social_links"];
    $social_links=$link["social_icons"];
    /*print_r($data);
    die;*/
?>
<!doctype html>
<html lang="en">
  <head>
    <title>TagMoi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    padding: 20px 8px;
    text-decoration: none;
    font-family: 'Poppins', sans-serif !important;
}
   .header img {
    display: block;
    text-align: center;
    margin: auto;
}
   .profile {
    padding: 15px;
   }
   .profile .img-left {
    float: left;
    width: 20%;
    margin-right: 12px;
    }
   .profile .img-left img {
    width: 70px;
    height: 70px;
}
   .profile-data h2 {
    margin: 0;    
    font-size: 20px;
    color: #512d6b;
    font-family: 'Playfair Display', serif;
    }
   .profile-data p {
    font-family: 'Poppins', sans-serif !important;
    color: #858587;
    line-height: 18px;
    margin: 0;
    font-size: 14px;
    }
    .buttons {
    margin-top: 12px;
    }
    .links a {
    display: block;
    float: left;
    text-decoration: none;
    width: 33%;
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
.buttons a{font-family: 'Raleway', sans-serif;margin:0 0 10px;}
a.btn.btn-primary {
  background: #512d6b;
  padding: 5px 10px;
  color: #ffffff;
  font-weight: 500;
  text-decoration: none;
  border-radius: 5px;
  font-size: 12px;
  margin:0px;
}
button.btn.btn-primary.medical {
  background: #ca0b0d;
  color: #fff;
  border: 0;
  padding: 5px 10px;
  border-radius: 5px;
  font-size:13px;
}
.medical img {
  width: 17px;
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
  float: right;
  width: 75%;
}
p strong{color: #512d6b; }
p.grey{color: #858587; }
p.green{color: #c5db3a; }
.links{padding: 10px 0; }
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
    margin: 15% auto;
    padding: 30px 10px 10px;
    width: 90%;
}
/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-weight: bold;
    top: -26px;
    position: relative;
    right: -2px;
}
.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle {
    color: #512d6b;
    background-color: #ffffff;
    border-color: #ffffff;
}



</style>
  <body>
    <div class="wrapper">
       <div class="content-wrap">
         <div class="top-header">
          <a class="btn btn-primary download-link" onclick="downloadApp()">Click here to Downlaod the app and get your Tagi</a>          
          <div class="header">
            <a href="#">Log In</a>
            <img src="<?php echo base_url(); ?>images/startup-logo.png">
           <a href="#">Sign Up</a>
          </div>
         </div>

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
             <a href="#" class="btn btn-primary">Add to Contact</a>
              <?php 
             if($data["medical_status"] == 1)
             {
             ?>
                <!--<a href="#" style="<?php //if($data['user_medical_status'] == 0){ echo 'pointer-events: none;'; } ?>" class="btn btn-primary medical"><img src="<?php// echo base_url(); ?>images/medical-icon.png">Medical ID</a>-->
                <button id="myBtn" href="#" class="btn btn-primary medical" style="<?php if($data['user_medical_status'] == 0){ echo 'pointer-events: none;'; } ?>"><img src="<?php echo base_url(); ?>images/medical-icon.png">Medical ID</button>
            <?php
             }
            ?>
            </div>
           </div>
           <div class="clearfix" style="clear: both;"></div>
         </div>

         <div class="status">
           <p class="grey">Tag Points:<strong> 1</strong></p>
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
                        ?>
                            <a href="<?php echo $link["link"]; ?>"><img src="<?php echo base_url().$sl["image"] ?>" ></a><br><span><?php echo $sl["type"]; ?></span>
                        <?php
                        }
                    }
                }
            }
            ?>
           <!--<a href="#"><img src="images/stcpay.png"><br><span>STC Pay</span></a>
           <a href="#"><img src="images/twitter.png"><br><span>Twitter</span></a>
           <a href="#"><img src="images/youtube.png"><br><span>Youtube</span></a>
           <a href="#"><img src="images/skype.png"><br><span>Skype</span></a>
           <a href="#"><img src="images/whtsapp.png"><br><span>WhatsApp</span></a>
           <a href="#"><img src="images/instagram.png"><br><span>Instagram</span></a>
           <a href="#"><img src="images/facebook.png"><br><span>Facebook</span></a>-->
         </div>
      </div>

      <!-- The Modal -->
      <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close"><img src="<?php echo base_url(); ?>images/close.png"></span>
          <div class="id-card">
           <!-- <div class="row">
            <div class="col">
              <img src="images/user-image.png">
              <h2>John Smith</h2>
              <p class="m-0">Scottsdale,Arizona United States</p>
            </div>

            <div class="col">
              <strong>Alergies & Reactions:</strong><br><span> Peanuts</span><br>
              <strong>Medical Condition:</strong><br><span> Hypertension</span><br>
              <strong>Medications:</strong><br><span> Lisinopril(10mg by mouth once a day)</span><br>
              <strong>Emergency Contacts:</strong><br><span> Karinna Cavana Spouse (650) 555 33369</span><br>
            </div>

            <div class="col">
              <strong>D.O.B: </strong><br><span> 21/3/1985</span><br>
              <strong>Blood Type: </strong><br><span> O+</span><br>
              <strong>Weight: </strong><br><span> 170lb</span><br>
              <strong>Height: </strong><br><span> 5’8’’</span><br>
            </div>
           </div> -->

           <div class="row">
            <div class="profile">
              <div class="profile-image">
                <img src="images/user-image.png">                
              </div>
              <div class="name-block">
                <h2>John Smith</h2>
                <p class="m-0">Scottsdale,Arizona United States</p>                
              </div>
            </div>
            
            <div class="intro">
              <div class="col">
               <strong>Alergies & Reactions:</strong><span> Peanuts</span><br>
               <strong>Medical Condition:</strong><span> Hypertension</span><br>
               <strong>Medications:</strong><span> Lisinopril(10mg by mouth once a day)</span><br>               
              </div>

              <div class="col details">
                <div class="left-part w-100">
                 <strong>D.O.B: </strong><span> 21/3/1985</span><br>
                 <strong>Blood Type: </strong><span> O+</span><br>
                 <strong>Weight: </strong><span> 170lb</span><br>
                 <strong>Height: </strong><span> 5’8’’</span><br>                  
                </div>

                <div class="right-part">
                 <strong>Emergency Contacts:</strong><br>
                 <span>Karinna Cavana </span><br>                  
                 <span>Spouse</span><br>                  
                 <span>(650) 555 33369</span>                 
                </div>

              </div>
            </div>

           </div>
          </div>
           <div class="red-wrap"><p><img src="images/medical-icon.png">Emergency Medical ID Card</p></div>
        </div>
      </div>

    </div>
    <script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
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
  </body>
</html>