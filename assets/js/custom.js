
var userAgent = window.navigator.userAgent.toLowerCase();
safari = /safari/.test( userAgent );
var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
var isMobile = navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i);
var oSwipper = null;

let bIsPro = jQuery('#bIsPro').val();

if (!safari && !isChrome) 
{
    if (window && !window.ReactNativeWebView) 
    {
        //document.getElementById("a#addTo").style.display = "none";
    }
}

if (window && window.ReactNativeWebView) {
    jQuery('#back').hide();
} else {
    // jQuery('#Cog').hide();
}

function webviewLogout() 
{
    if (window && window.ReactNativeWebView) 
    {
        window.ReactNativeWebView.postMessage("log out");
    }
}

function goBack() 
{
    window.history.back();
}
function process() 
{
    var sSlug = jQuery('#sSlug').val();
    // var url=" https://api.qrserver.com/v1/create-qr-code/?size=110x110&color=00aced&data=" + window.location.href + '/q';
    var url;
    if (window && window.ReactNativeWebView) 
    {
        url="https://api.qrserver.com/v1/create-qr-code/?size=110x110&color=000&data=https://poplme.co/" + sSlug + '/a';
        //var url="https://api.qrserver.com/v1/create-qr-code/?size=110x110&color=00aced&data=https://poplme.com/?link=https%3A%2F%2Fpoplme%2Eco%2F" + {/literal}"{$oMember->getSlug()}"{literal} + '/a';
    }
    else 
    {
        url="https://api.qrserver.com/v1/create-qr-code/?size=110x110&color=000&data=https://poplme.co/" + sSlug + '/q';
        //var url="https://api.qrserver.com/v1/create-qr-code/?size=110x110&color=00aced&data=https://poplme.com/?link=https%3A%2F%2Fpoplme%2Eco%2F" + {/literal}"{$oMember->getSlug()}"{literal} + '/q';
    }
    document.getElementById('QRCode').src = url;
}
/* Open */
function BuyPopl() 
{
  document.getElementById("BuyPopl").style.height = "100%";
}

/* Close */
function closeBuyPopl() 
{
  document.getElementById("BuyPopl").style.height = "0%";
}
/* Close */
function closePWA() 
{
  document.getElementById("PWA").style.height = "0%";
}
function ChoosePassportImage(){
    jQuery('#PassportImage').click();
}
function DeleteLink()
{
    var sHash = jQuery("#fill_link").data('link-hash');
    if(sHash==='')
    {
        /*Close Add Link Dialog*/
        CloseAddLinkDialog();
    }
    else
    {
        /*Delete Exist Link*/
        var hRes = confirm("Are you sure you want to delete this link?");
        if (hRes === true) 
        {
            /*Get Link ID*/
            var iLinkID = jQuery("#fill_link").data('link-id');
            /*Get Profile Num*/
            var iProfileNum = (oSwipper.activeIndex+1);
            jQuery.post('/', {'sAction':'AjaxCleanLinkValue','iLinkID':iLinkID,'iProfileNum':iProfileNum,'sHash':sHash}, function(json) {
                if(json.done==1)
                {
                    history.go(0);
                }
            }, 'json');
        }
    }    
}
function CloseLinksPopup()
{
    jQuery('#AllLinks').css('height',"0%");
    /*jQuery('#AllLinks').hide();*/
    
    off();
}
function CloseAddLinkDialog()
{
    
    jQuery('#LinkDialog').css('height',"0%");
    jQuery('#AllLinks').css('height',"0%");
    jQuery('#LinkDetailsPageLoader').hide();
    /*jQuery('#LinkDialog').hide();*/
    off();
}
function ClearLinkInput()
{
    jQuery("#fill_link").val('');
    document.getElementById("fill_link").focus();
}
function ClearLinkTitleInput()
{
    jQuery("#linkTitle").val('');
    jQuery("#result").val('');
    document.getElementById("result").innerHTML = "";
    document.getElementById("linkTitle").focus();
}
function OpenEditLinkDialog(iLinkID,sHash,taps,input)
{
    if (iLinkID !== 0) 
    {
        if (window && window.ReactNativeWebView) {window.ReactNativeWebView.postMessage("editLinkStart");}
    }
    on();
    jQuery('#sDiaplogOp').val('Edit');
    jQuery('#AllLinks').hide();
    jQuery('#AllLinks').css('height',"0%");
    jQuery('#LinkDialog').css('height',"0%");
    jQuery('#LinkDialog').show();
    
    /*Get Profile Num*/
    var iProfileNum = (oSwipper.activeIndex+1);
    /*Get Link Details and Value*/
    jQuery.post('/', {'sAction':'AjaxGetLinkValue','iLinkID':iLinkID,'sHash':sHash,'iProfileNum':iProfileNum}, function(json) {
        /*Fill link details*/
        jQuery("#IconLink").prop('src',json.sIcon);
        jQuery("#IconLinkSmall").prop('src',json.sIcon);
        jQuery("#HelperText").html(json.sHelper);
        jQuery("#fill_link").val(json.sValue);
        jQuery("#fill_link").prop('placeholder',json.sPlaceHolder);
        // document.getElementById("fill_link").placeholder = json.sPlaceHolder;
        // document.getElementById("fill_link").value = json.sValue;
        jQuery("#LinkURL").data('url',json.sURL);
        jQuery("#fill_link").data('link-id',iLinkID);
        jQuery("#fill_link").data('link-hash',sHash);
        jQuery('#linkTitle').val(json.sTitle);
        jQuery('#result').val(json.sTitle);
        if (bIsPro === '1') {
            document.getElementById("result").innerHTML = json.sTitle;
        }
        if (iLinkID == '3') {
            jQuery("#PlaceholderText").html("Instagram");
            input = "Instagram";
        } else if (iLinkID == '4') {
            jQuery("#PlaceholderText").html("Snapchat");
            input = "Snapchat";
        } else if (iLinkID == '5') {
            jQuery("#PlaceholderText").html("Twitter");
            input = "Twitter";
        } else if (iLinkID == '6') {
            jQuery("#PlaceholderText").html("Facebook");
            input = "Facebook";
        } else if (iLinkID == '7') {
            jQuery("#PlaceholderText").html("LinkedIn");
            input = "LinkedIn";
        } else if (iLinkID == '8') {
            jQuery("#PlaceholderText").html("Text");
            input = "Text";
        } else if (iLinkID == '9') {
            jQuery("#PlaceholderText").html("Email");
            input = "Email";
        } else if (iLinkID == '10') {
            jQuery("#PlaceholderText").html("YouTube");
            input = "YouTube";
        } else if (iLinkID == '11') {
            jQuery("#PlaceholderText").html("TikTok");
            input = "TikTok";
        } else if (iLinkID == '12') {
            jQuery("#PlaceholderText").html("Soundcloud");
            input = "Soundcloud";
        } else if (iLinkID == '13') {
            jQuery("#PlaceholderText").html("Spotify");
            input = "Spotify";
        } else if (iLinkID == '14') {
            jQuery("#PlaceholderText").html("Apple");
            input = "Apple";
        } else if (iLinkID == '15') {
            jQuery("#PlaceholderText").html("Venmo");
            input = "Venmo";
        } else if (iLinkID == '16') {
            jQuery("#PlaceholderText").html("Cash App");
            input = "Cash App";
        } else if (iLinkID == '17') {
            jQuery("#PlaceholderText").html("Paypal");
            input = "Paypal";
        } else if (iLinkID == '18') {
            jQuery("#PlaceholderText").html("WhatsApp");
            input = "WhatsApp";
        } else if (iLinkID == '19') {
            jQuery("#PlaceholderText").html("Pinterest");
            input = "Pinterest";
        } else if (iLinkID == '20') {
            jQuery("#PlaceholderText").html("VSCO");
            input = "VSCO";
        } else if (iLinkID == '21') {
            jQuery("#PlaceholderText").html("Twitch");
            input = "Twitch";
        } else if (iLinkID == '22') {
            jQuery("#PlaceholderText").html("Contact card");
            input = "Contact card";
        } else if (iLinkID == '23') {
            jQuery("#PlaceholderText").html("Custom link");
            input = "Custom link";
        } else if (iLinkID == '24') {
            jQuery("#PlaceholderText").html("Website");
            input = "Website";
        } else if (iLinkID == '25') {
            jQuery("#PlaceholderText").html("Address");
            input = "Address";
        } else if (iLinkID == '27') {
            jQuery("#PlaceholderText").html("FaceTime");
            input = "FaceTime";
        } else if (iLinkID == '28') {
            jQuery("#PlaceholderText").html("Calendly");
            input = "Calendly";
        } else if (iLinkID == '29') {
            jQuery("#PlaceholderText").html("OnlyFans");
            input = "OnlyFans";
        } else if (iLinkID == '30') {
            jQuery("#PlaceholderText").html("Podcasts");
            input = "Podcasts";
        } else if (iLinkID == '31') {
            jQuery("#PlaceholderText").html("Call");
            input = "Call";
        } else if (iLinkID == '32') {
            jQuery("#PlaceholderText").html("Tinder");
            input = "Tinder";
        } else if (iLinkID == '33') {
            jQuery("#PlaceholderText").html("Discord");
            input = "Discord";
        } else if (iLinkID == '36') {
            jQuery("#PlaceholderText").html("Linktree");
            input = "Linktree";
        } else if (iLinkID == '37') {
            jQuery("#PlaceholderText").html("File");
            input = "File";
        } else {
            jQuery("#PlaceholderText").html("Yelp");
            input = "Yelp";
        }
        jQuery('#LinkDialog').css('height',"500px");
        jQuery('#LinkDetailsPageLoader').hide();  
        if (bIsPro === '1') {
            if (json.sValue!=="") { document.getElementById("analytics").innerHTML = taps; document.getElementById("linkTaps").innerHTML = input + ' taps'; } else { jQuery('#analytics').hide(); jQuery('#linkTaps').hide(); }
        } else {
            document.getElementById("analytics").innerHTML = "<u>" + "Unlock analytics with Popl Pro" + "</u>";
            document.getElementById("analytics").style.fontSize = "95%";
        }
        if (window && window.ReactNativeWebView) {window.ReactNativeWebView.postMessage("editLinkEnd");}
    }, 'json'); 
}
function OpenAddLinkDialog(iLinkID)
{
    jQuery('#sDiaplogOp').val('Add');
    on();
    jQuery('#LinkDialog').css('height',"0%");
    jQuery('#gridDemo3').hide();
    jQuery('#PageLoader').show();
    jQuery('#AllLinksTitle').hide();

    /*Get Link Details*/
    jQuery.post('/', {'sAction':'AjaxGetLinkDetails','iLinkID':iLinkID}, function(json) {
        /*Fill link details*/
        jQuery('#result').val("");
        document.getElementById("analytics").style.display = "none";
        document.getElementById("linkTaps").style.display = "none";
        jQuery("#IconLink").prop('src',json.sIcon);
        jQuery("#IconLinkSmall").prop('src',json.sIcon);
        jQuery("#HelperText").html(json.sHelper);
        jQuery("#fill_link").val('');
        jQuery('#linkTitle').val('');
        jQuery("#fill_link").prop('placeholder',json.sPlaceHolder);
        jQuery("#LinkURL").data('url',json.sURL);
        jQuery("#fill_link").data('link-id',iLinkID);
        
        if (iLinkID == '3') {
            jQuery("#PlaceholderText").html("Instagram");
            jQuery('#linkTitle').val(jQuery("#PlaceholderText").val());
        } else if (iLinkID == '4') {
            jQuery("#PlaceholderText").html("Snapchat");
            jQuery('#linkTitle').val(jQuery("#PlaceholderText").val());
        } else if (iLinkID == '5') {
            jQuery("#PlaceholderText").html("Twitter");
        } else if (iLinkID == '6') {
            jQuery("#PlaceholderText").html("Facebook");
        } else if (iLinkID == '7') {
            jQuery("#PlaceholderText").html("LinkedIn");
        } else if (iLinkID == '8') {
            jQuery("#PlaceholderText").html("Text");
        } else if (iLinkID == '9') {
            jQuery("#PlaceholderText").html("Email");
        } else if (iLinkID == '10') {
            jQuery("#PlaceholderText").html("YouTube");
        } else if (iLinkID == '11') {
            jQuery("#PlaceholderText").html("TikTok");
        } else if (iLinkID == '12') {
            jQuery("#PlaceholderText").html("Soundcloud");
        } else if (iLinkID == '13') {
            jQuery("#PlaceholderText").html("Spotify");
        } else if (iLinkID == '14') {
            jQuery("#PlaceholderText").html("Apple");
        } else if (iLinkID == '15') {
            jQuery("#PlaceholderText").html("Venmo");
        } else if (iLinkID == '16') {
            jQuery("#PlaceholderText").html("Cash App");
        } else if (iLinkID == '17') {
            jQuery("#PlaceholderText").html("Paypal");
        } else if (iLinkID == '18') {
            jQuery("#PlaceholderText").html("WhatsApp");
        } else if (iLinkID == '19') {
            jQuery("#PlaceholderText").html("Pinterest");
        } else if (iLinkID == '20') {
            jQuery("#PlaceholderText").html("VSCO");
        } else if (iLinkID == '21') {
            jQuery("#PlaceholderText").html("Twitch");
        } else if (iLinkID == '22') {
            jQuery("#PlaceholderText").html("Contact card");
        } else if (iLinkID == '23') {
            jQuery("#PlaceholderText").html("Custom link");
        } else if (iLinkID == '24') {
            jQuery("#PlaceholderText").html("Website");
        } else if (iLinkID == '25') {
            jQuery("#PlaceholderText").html("Address");
        } else if (iLinkID == '27') {
            jQuery("#PlaceholderText").html("FaceTime");
        } else if (iLinkID == '28') {
            jQuery("#PlaceholderText").html("Calendly");
        } else if (iLinkID == '29') {
            jQuery("#PlaceholderText").html("OnlyFans");
        } else if (iLinkID == '30') {
            jQuery("#PlaceholderText").html("Podcasts");
        } else if (iLinkID == '31') {
            jQuery("#PlaceholderText").html("Call");
        } else if (iLinkID == '32') {
            jQuery("#PlaceholderText").html("Tinder");
        } else if (iLinkID == '33') {
            jQuery("#PlaceholderText").html("Discord");
        } else if (iLinkID == '36') {
            jQuery("#PlaceholderText").html("Linktree");
        } else if (iLinkID == '37') {
            jQuery("#PlaceholderText").html("File");
            input = "File";
        } else {
            jQuery("#PlaceholderText").html("Yelp");
        }
        //jQuery("#PlaceholderText").html(json.sPlaceHolder);
        jQuery('#LinkDialog').show();
        jQuery('#LinkDialog').css('height',"500px");
        jQuery('#LinkDetailsPageLoader').hide();   
        jQuery('#AllLinks').css('height',"0%");
    }, 'json'); 
}
// function SaveNewLink() 
// {
//     jQuery('.enterYour').hide();
//     jQuery('.AddLinkBlock').hide();
//     jQuery('#LinkDetailsPageLoader').show();
//     var sDialogOp   = jQuery('#sDiaplogOp').val();
//     var sValue      = jQuery("#fill_link").val();
//     var sHash       = jQuery("#fill_link").data('link-hash');
//     //var sLinkTitle  = jQuery("#linkTitle").val(); //change for new popl app
//     var sLinkTitle  = jQuery("#PlaceholderText").val();
//     if (jQuery("#linkTitle").val() == "") {
//         sLinkTitle = jQuery("#result");
//     }
//     if(sValue=='')
//     {
//         CloseAddLinkDialog();
//         return false;
//     }
//     /*Get Link ID*/
//     var iLinkID = jQuery("#fill_link").data('link-id');
//     /*Get Profile Num*/
//     var iProfileNum = (oSwipper.activeIndex+1);
//     /*Save Link Value*/
//     jQuery.post('/', {
//                     'sAction':sDialogOp=='Edit'?'AjaxUpdateLinkValue':'AjaxSaveLinkValue',
//                     'iLinkID':iLinkID,
//                     'sValue':sValue,
//                     'sLinkTitle':sLinkTitle, 
//                     'sHash':sHash,
//                     'iProfileNum':iProfileNum}, 
//             function(json) {
//                 if(json.done==1) { history.go(0); }
//         }, 'json');
//     off();
// }


function on() {
  jQuery('#overlay').show();
}

function off() {
    jQuery('#AllLinks').css('height',"0%");
    jQuery('#overlay').hide();
    jQuery('#QrCodeOverlay').css('height',"0%");
}

function editClicked() {
    var aPositions = Array();
	var state = sortable.option("disabled"); // get
    if(!state) {
        //     var aElements = document.getElementsByClassName('grid-square');
        //     for(var iEl = 0; iEl < aElements.length; iEl++)
        //     {
        //         aPositions[iEl] = aElements[iEl].getAttribute("data-link-id");
        //     }
            
        //     jQuery.post('/', {'sAction':'AjaxUpdateLinksSorting','aPositions':aPositions}, function(json) {
        //     if(json.done==1)
        //     {}   
        //   }, 'json');
        // document.getElementById("direct").disabled = true; 
        if ($('#direct_on').val() == '1') {
            $('div#gridDemo.flex-row div.grid-square:not(:first-child)').addClass('blur');
            $('div#gridDemo.flex-row div.grid-square:last-child').removeClass('blur');
            $(".direct_info").attr('style', 'display: block');
        }
    } else {
        document.getElementById("direct").disabled = true; 
    }
	//sortable.option("disabled", !state); // set
};



function BuyPoplPro() {
    if (window && window.ReactNativeWebView) {
        window.ReactNativeWebView.postMessage("BuyPoplPro");
    } else {
        if (confirm('Download the Popl App to go pro âš¡ï¸')) {
          // Save it!
          window.location.href='https://popl.co/app';
        } else {
          // Do nothing!
        }
    }
}



function deleteAccount()
{
    var hRes = confirm("Are you sure you want to delete your account?");
    if (hRes === true) 
    {
        window.location = WebsiteURL+'/?sAction=deleteAccount';
    } 
}
function ClearField(sElementID)
{
    jQuery('#'+sElementID).val('');
}

jQuery('#Register').on('submit', function () 
{
    
    jQuery('#RegisterBtn').prop("disabled", true);
    var sEmail = jQuery('#sEmail').val();
    jQuery.getJSON(WebsiteURL, {sAction:'AjaxCheckEmail',sEmail:sEmail}, function(json)
    {
        if(json.checked)
        {
            return true;
        }
        else
        {
           return false; 
        }    
    } );
});
function getPhoto(iID)
{
    jQuery.getJSON(WebsiteURL, {'sAction':'getPhotoByID','iID':iID}, function(json)
    {
        //json.url  
    } );
}
function CheckForm()
{
  var sEmail   = jQuery('#sEmail').val();
    if(sEmail==='')
    {
        jQuery('#sEmail').notify("Sorry, no profile was found for that email", "error");
        return false;
    }
    jQuery.post('/', {'sAction':'AjaxCheckMemberEmail','sEmail':sEmail}, function(json) {
      if(json.checked==1)
      {
          jQuery('#sEmail').notify("Sorry, no profile was found for that email", "error");
          return false;
          
      }
      else
      {
          jQuery('#EnterEmail').submit();
      }    
    }, 'json'); 
}

jQuery('#ChangePassword').on('submit', function () 
{
    var sPassword   = jQuery('#sPassword').val();
    var sRePassword = jQuery('#sRePassword').val();
    if (sPassword != sRePassword) {
        jQuery('#sRePassword').notify("Passwords do not match", "error");
        return false;
    } 
    return true;
});

function DeletePortfolio()
{
    jQuery.getJSON(WebsiteURL, {sAction:'AjaxDeletePortfolio'}, function(json)
    {
        if(json.done==1)
        {
            jQuery('#sPortfolio').val('');
        }   
    } );
}
function CheckPasswordRestoreCode()
{
  var sCode = jQuery('#sCode').val();
    jQuery.post('/', {'sAction':'AjaxCheckCodeForPasswordReset','sCode':sCode}, function(json) {
      if(json.done==1)
      {
          window.location = '/?sAction=ChangePassword&sCode='+sCode;
      }
      else
      {
          jQuery('#sCode').notify("Sorry, this code does not match", "error");
      }    
    }, 'json'); 
}
function CheckCode()
{
  var sCode = jQuery('#sCode').val();
  jQuery('#CheckCodeBtn').prop("disabled", true);
    jQuery.post('/', {'sAction':'CheckCode','sCode':sCode}, function(json) {
      if(json.activated==1)
      {
          window.location = '/?sAction=EditProfile';
      }
      else
      {
          jQuery('#sCode').notify("Sorry, this code does not match", "error");
          jQuery('#CheckCodeBtn').prop("disabled", false);
      }    
    }, 'json'); 
}
function ActivateProfile()
{
    
    jQuery('#ActivateAccountBtn').prop("disabled", true);
    var sPhone = jQuery('#sPhone').val();
    if (sPhone.length < 10)
    {
        jQuery('#sPhone').notify("Please enter a full phone number", "warn");
    }
    
    jQuery.post('/', {'sAction':'SendSMS','sPhone':sPhone}, function(json) {
       if(json.sent==1)
       {
           window.location = '/?sAction=EnterCode';
       }
       else
       {
           jQuery('#sPhone').notify("Sorry, this number already exists", "error");
           jQuery('#ActivateAccountBtn').prop("disabled", false);
       }    
    }, 'json');
}
function LoadProfile(sSlug,iProfileNum)
    {
        var iActiveProfile = jQuery('#iProfileNum').val();
        console.log('came here iProfileNum', iProfileNum);
        jQuery.getJSON(WebsiteURL, {
            'sAction':'LoadProfile',
            'sSlug':sSlug,
            'iProfileNum':(iActiveProfile==1?2:1)}, function(json)
            {
                jQuery('#iProfileNum').val(iActiveProfile==1?2:1);
                //jQuery('#iProfileNum').val(2);
                console.log("came here load profile: ", jQuery('#iProfileNum').val() );
                 
            } 
        );
    }

function IncView(iLinkID,iProfileID,sHash)
{
    jQuery.getJSON(WebsiteURL, {sAction:'AjaxIncView','iLinkID':iLinkID,'iID':iProfileID,'sHash':sHash}, function(json){} );
}
function choosePhoto(iProfileNum)
{
    console.log('came to choose photo');
    jQuery('#sPhoto'+iProfileNum).click();
}
function choosePortfolio()
{
    jQuery('#sPDF').click();
}
jQuery('#sPDF').change(function() 
{
    var file = $('#sPDF')[0].files[0].name;
    jQuery('#sPortfolio').val(file);
});



function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      jQuery('.profile-photo-wrapper').html('<img src="'+e.target.result+'">');
      jQuery('#profile_picture').prop('src',e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

 jQuery(".sPhoto").change(function() {
   readURL(this);
   var iProfileNum = jQuery(this).data('profile-num'); 
   /*Upload Photo on Server*/
     
         var fd = new FormData();
         var files = jQuery('#sPhoto'+iProfileNum)[0].files[0];
         fd.append('file',files);

         jQuery.ajax({
             url: '/?sAction=UploadProfilePhoto',
             type: 'post',
             data: fd,
             contentType: false,
             processData: false,
             success: function(json){
                 jQuery('.profile-photo-wrapper').html('<img src="'+json.img+'">');
                jQuery('#profile_picture').prop('src',json.img);
             },
         });
     
 });

function ChangePasswordForSpecialRegistred()
{
    var sPassword   = jQuery('#sPassword').val();
    var sRePassword = jQuery('#sRePassword').val();
    jQuery.post('/', {'sAction':'AjaxUpdatePasswordWithoutCode','sPassword':sPassword,sRePassword:sRePassword}, function(json) {
       if(json.done==1)
       {
           window.location = '/?sAction=EditProfile';
       }
       else
       {
           if (sPassword != sRePassword) {
                jQuery('#sRePassword').notify("Passwords do not match", "warn");
           } 
       }    
    }, 'json');
}
function ChangePassword()
{
    var sPassword   = jQuery('#sPassword').val();
    var sRePassword = jQuery('#sRePassword').val();
    var sOldPassword = jQuery('#sOldPassword').val();
    jQuery.post('/', {'sAction':'AjaxUpdatePasswordWithoutCode','sPassword':sPassword,sRePassword:sRePassword,sOldPassword:sOldPassword}, function(json) {
       if(json.done==1)
       {
           window.location = '/?sAction=EditProfile';
       }
       else
       {
           if (sPassword != sRePassword) {
                jQuery('#sRePassword').notify("Passwords do not match", "warn");
           } else {
                jQuery('#sOldPassword').notify("Sorry, your current password is incorrect", "error");
           }
       }    
    }, 'json');
}


function ChangeDirectStatus(iState)
{
    jQuery.getJSON('/', {sAction:'AjaxUpdateDirectState',bIsDirect:iState}, function(json)
    {
        if(json.done){}

    } ); 
}
// function SaveProfile()
// {
//     jQuery('#PageLoader').show();  
//     jQuery('#PageContainer').hide();
//     jQuery('#Cog').hide();
//     jQuery('#Reward').hide();
//     jQuery('#myNavSave').hide();
//     var form = $('form')[0]; 
//     var formData = new FormData(form);
//     console.log(formData);
//     jQuery.ajax({
//         type: "POST",
//         url: '/',
//         contentType: false,
//         processData: false, 
//         data: formData,
//      success: function(answer) {
//          window.location = answer;
//      }
//     });
//     console.log("this is getting called");
//     if (window && window.ReactNativeWebView) {
//         window.ReactNativeWebView.postMessage("edit profile");
//     }
// }
function addLink() 
{
    document.getElementById("AddSaveButtonsDialog").style.height = "120px";
}



function SavePassport()
{
    if (document.getElementById("sPassportDate").value != "" && document.getElementById("sPassportName").value != "") {
        jQuery('#input_link_covid').hide();
        jQuery('#covidTitle').hide();
        jQuery('#PageLoader2').show();
        var form = jQuery('.AjaxForm');
        var sURL = form.attr('action');
        var oForm = $('form')[1]; // You need to use standard javascript object here
        var formData = new FormData(oForm);
        jQuery.ajax({
            type: 'POST',
            url: sURL,
            data: formData,
            contentType: false,
            processData: false, 
            success: function(data)
            {
                window.location = answer;
                if (window && window.ReactNativeWebView) { 
                    window.ReactNativeWebView.postMessage("covidSubmit");
                    console.log('covid submit');
                }
                setTimeout(function(){
                  document.getElementById("LinkDetailsDialogCovid").style.height = "0";
                  setTimeout(function(){
                      alert("Your covid pass has been created! You can now pop your covid information to any phone using your popl or QR code!")
                    }, 500);
                }, 2000);
                setTimeout(function(){
                    history.go(0);
                }, 3000);
            },
            error: function (data) {
               
            },
        });
    } else {
        document.getElementById("LinkDetailsDialogCovid").style.height = "0";
        document.getElementById("AllLinks").style.height = "0"; 
    }
}

function qrcodeSmall() {
    process();
    on();
    /*jQuery('#QrCodeOverlay').show();*/
    jQuery('#QrCodeOverlay').css('height',"340px");
}
/* Close */
function closeQrCode() {
  off();
  jQuery('#QrCodeOverlay').css('height',"0%");
}
function removeLink() {
    jQuery('#AddSaveButtonsDialog').css('height',"0%")
}
function editWebview() 
{
    if (window && window.ReactNativeWebView) {
        window.ReactNativeWebView.postMessage("startSpinner");
        jQuery('#Cog').hide();
        jQuery('#PageLoader').hide();
    } else {
        jQuery('#CogWebview').hide(); 
    }
}
function noSwipe() {
        if (isMobile) {
            swiper.allowSlideNext = false;	
            swiper.allowSlidePrev = false;
        }
    }
    function yesSwipe() {
        if (isMobile) {
            swiper.allowSlideNext = true;	
            swiper.allowSlidePrev = true;
        }
    }
function SaveProfile()
{
    jQuery('#PageLoader').show();  
    jQuery('#PageContainer').hide();
    jQuery('#CogWebview').hide();
    jQuery('#Cog').hide();
    jQuery('#Reward').hide();
    jQuery('#myNavSave').hide();
    var form = $('form')[0]; 
    var formData = new FormData(form);
    
    // let data = Array.from(formData.entries()).reduce((memo, pair) => ({
    //   ...memo,
    //   [pair[0]]: pair[1],
    // }), {});
    // console.log(JSON.stringify(data));
    
    jQuery.ajax({
        type: "POST",
        url: '/',
        contentType: false,
        processData: false, 
        data: formData,
        success: function(answer) 
        {
            window.location = answer;
            if (window && window.ReactNativeWebView) 
            { 
               window.ReactNativeWebView.postMessage("complete");
            }
        }
    });
}
if (window && window.ReactNativeWebView) 
{
    jQuery('#CogSettings').hide();
} 
else 
{
    jQuery('#CogWebview').hide(); 
}
 jQuery( document ).ready(function() {
    
//     jQuery('#overlay').on( "click", function() {off();jQuery('#AllLinks').hide();jQuery('#QrCodeOverlay').hide();CloseAddLinkDialog();});
//     if(jQuery(".swiper-container").length !== 0) 
//     {
//         var iActiveProfile = jQuery('#iActiveProfile').val();
//         var swiper = new Swiper('.swiper-container', {
//             effect: 'flip',
//             grabCursor: false,
//             initialSlide:(iActiveProfile-1),
//             loop: false,
//             flipEffect: {
//               // shadow: false,
//               slideShadows: true,
//               // shadowOffset: 20,
//               // shadowScale: 0.94,
//               limitRotation: true,
//               // slideShadows: false,
//             },
//             navigation: {
//               nextEl: '.swiper-button-next',
//               prevEl: '.swiper-button-prev',
//             },
//             pagination: {
//               el: '.swiper-pagination',
//             },
//             on: {
//               slideChange: function () 
//               {
//                   /*Change Active Profile*/
//                   var iProfileNum = (this.activeIndex+1);
//                   jQuery.post('/', {'sAction':'AjaxSetActiveProfile','iProfileNum':iProfileNum}, function(json) { }, 'json');

//                 },
//       }
//     });
//     var iActiveProfile = jQuery('#iActiveProfile').val();
//     var bIsPro = jQuery('#bIsPro').val();
//     if (!bIsPro || !isMobile) 
//     {
//         swiper.allowTouchMove = false;
//     }
//     //swiper.slideTo((iActiveProfile-1), false, false);
//     oSwipper = swiper;
//     }
    
//     for(var iProfile = 1; iProfile <= 2; iProfile++)
//     {
//         if(jQuery("#LinksWrapper"+iProfile).length !== 0) 
//         {
//             var oSortable = jQuery('#LinksWrapper'+iProfile).get(0);
//             var sortable = Sortable.create(oSortable, {
//                 onChoose: function () {
//                     var iProfileNum = (oSwipper.activeIndex+1);    
//                         $('div#LinksWrapper'+iProfileNum+'.flex-row div.grid-square').removeClass('blur');
//                         /*$("#toggle_edit").trigger('click');
//                         $("#toggle_edit").trigger('touchstart');*/
//                         noSwipe();
//                 },

//                 onUnchoose: function () 
//                 {
//                     var iProfileNum = (oSwipper.activeIndex+1);
//                     var aPositions = Array();
//                     var aHashes    = Array();
//                     jQuery('#LinksWrapper'+iProfileNum+' .grid-square').each(function(iEl,oEl) 
//                     {
//                         aPositions[iEl] = oEl.getAttribute("data-link-id");
//                         aHashes[iEl]    = oEl.getAttribute("data-link-hash");
//                     });
//                     jQuery.post('/', {'sAction':'AjaxUpdateLinksSorting','aPositions':aPositions,'aHashes':aHashes,'iProfileNum':iProfileNum}, function(json) 
//                     {
//                         if(json.done==1)
//                         {
//                             if ($('#direct_on').val() == '1' && !$(".toggle_edit").hasClass('red')) 
//                             {
//                                 console.log('came here');
//                                 $('div#LinksWrapper'+iProfileNum+'.flex-row div.grid-square:not(:first-child)').addClass('blur');
//                                 $('div#LinksWrapper'+iProfileNum+'.flex-row div.grid-square.add_grid').removeClass('blur');
//                                 $(".direct_info").attr('style', 'display: block');
//                             }
//                         }   
//                   }, 'json');
//                   yesSwipe();      
//                 }
//             });
//             //sortable.option("disabled", "true"); // set sorting off on default
//             sortable.option("animation", "200"); 
//             sortable.option("delay", "90"); 
//         }
//     }
    
    
    var lines = 3;
    var linesUsed = $('#linesUsed');
    $(".toggle_direct").click(function () 
    {
        if(!$(this).hasClass('red')) 
        {
            ChangeDirectStatus(1);
            $('#direct_on').val("1");
            $(".toggle_direct").addClass('red');
            $(".direct_info").attr('style', 'display: block');
            $(".profile_info").attr('style', 'display: none');
            $('.LinksWrapper.flex-row div.grid-square:visible:not(:first-child)').addClass('blur');
            $('.LinksWrapper.flex-row div.grid-square:last-child').removeClass('blur');
         } 
         else 
         {
            ChangeDirectStatus(0);
            $('#direct_on').val("0");
            $(".toggle_direct").removeClass('red');
            $(".profile_info").attr('style', 'display: block');
            $(".direct_info").removeAttr('style', 'display: block');
            $('.LinksWrapper.flex-row div.grid-square').removeClass('blur');
        }
    //   $(this).css("font-weight","Bold");
    //   $(this).text(function(i, text){
    //       return text === "Direct off" ? "Direct on" : "Direct off";
    //   })
      //first profile
      $('#direct1').css("font-weight","Bold");
      $('#direct1').text(function(i, text){
          return text === "Direct off" ? "Direct on" : "Direct off";
      })
      //second profile
      $('#direct2').css("font-weight","Bold");
      $('#direct2').text(function(i, text){
          return text === "Direct off" ? "Direct on" : "Direct off";
      })
  });
    
    $('#bio').keydown(function(e) {
        
        newLines = $(this).val().split("\n").length;
        linesUsed.text(newLines);
        
        if(e.keyCode == 13 && newLines >= lines) {
            linesUsed.css('color', 'red');
            return false;
        }
        else {
            linesUsed.css('color', '');
        }
    });
    
    jQuery('.example-popover').popover({container: 'body'});
    jQuery('[data-toggle="popover"]').popover();
     
    var srt = jQuery("#Sortable" ).sortable({handle:'.fa-bars'});  
    jQuery('#InstallApp').modal('show');
    jQuery('#Keyword').on('keyup',function(e) {
    if(e.which == 13) {
       jQuery('#Results').html('');
       jQuery('#Results').hide(); 
       jQuery('#Keyword').val('');
    }
    var sKeyword = jQuery('#Keyword').val();
    if(sKeyword.length>=2)
    {
       jQuery.getJSON('/', {sAction:'AjaxQuickSearch',sKeyword:sKeyword}, function(json)
        {
            if(json.done)
            {
                if(json.html!=='')
                {
                    jQuery('#Results').html(json.html);
                    jQuery('#Results').show();
                }
                else
                {
                    jQuery('#Results').html('');
                   jQuery('#Results').hide(); 
                }    

            }

        } ); 
    }
    else
    {
        jQuery('#Results').html('');
        jQuery('#Results').hide(); 
    } 
});

$('body').on('click', function (e) {
        $('[data-toggle=popover]').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
  
});

