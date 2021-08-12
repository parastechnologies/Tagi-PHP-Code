<?php
$main=array_merge($data,$links);

?>
<!doctype html>
<html lang="en">
  <head>
    <title></title>
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
    display: block;
    margin: 0;
    background: #512d6b;
}
  .header img {
    display: block;
    text-align: center;
    margin: 10px auto;
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
    width: 100%;
}
   .profile-data h2 {
    margin: 0;
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
 .buttons a{font-family: 'Raleway', sans-serif;margin:0 0 10px;}
 a.btn.btn-primary {background: #c5db3a; padding: 5px 10px; color: #512d6b; font-weight: 700; text-decoration: none; border-radius: 5px; } 
a.btn.btn-primary.medical{background: #ca0b0d; color: #fff;}
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
p strong {color: #512d6b; }
p.grey{color: #858587; }
p.green{color: #c5db3a; }
.links {
    padding: 10px 0;
}
.links img {
    width: 24%;
}
</style>
  <body>
    <div class="wrapper">
       <div class="content-wrap">          
         <div class="header">
           <img src="<?php echo base_url(); ?>images/logo.png">
         </div>

         <div class="profile">
           <div class="img-left">
              <?php 
               if(!empty($main["profile_image"]))
               {
               ?>
                    <img src="<?php echo base_url(); ?>profileImages/<?php echo $main["profile_image"]; ?>">
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
             <h2><?php echo $main["first_name"] ." ".$main["last_name"] ?></h2>
             <p><?php echo $main["description"]; ?></p>
             <div class="buttons">
             <a href="#" class="btn btn-primary">Direct On</a>
             <a href="#" class="btn btn-primary medical"><img src="<?php echo base_url(); ?>images/medical-icon.png">Medical ID</a>
           </div>
           </div>
           <div class="clearfix" style="clear: both;"></div>
         </div>

         <div class="status">
           <p class="grey"><strong>Note:</strong> Tap and hold on any link to move or delete</p>
           <p class="green"><strong>Status:</strong> <b>Your Tagi opens directly to the first link</b></p>
         </div>

         <div class="links">
            <?php
            foreach($links as $link)
            {
                foreach($social_links as $sl)
                {
                    if($link["type"] == $sl["type"])
                    {
                    ?>
                        <a href="<?php echo $link["link"]; ?>"><img src="<?php echo base_url().$sl["image"] ?>" ></a>
                    <?php
                    }
                }
            }
            ?>
         </div>
         
        </div>
    </div>
  </body>
</html>