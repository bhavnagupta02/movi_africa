<?php 
$Page = basename($_SERVER['PHP_SELF'], ".php");


?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/livestamp/1.1.2/livestamp.js"></script>
<!--- FOOTER --->

<script>
    var page = '<?php echo $Page; ?>';
    
    if(page=="message"){
        var MsgPageNt = 1;
    }else{
        var MsgPageNt = 0;
    }
    //alert(MsgPageNt);
    //var MsgPageNt = 1;
    
    

    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
    
    (function() {
    document.querySelector('.nav-button').addEventListener('click', function() {
    	this.parentNode.parentNode.classList.toggle('closed')
    }, false);
    });
</script>


<div id="FooBx"></div>

<footer class="footer" style="z-index:600004454;">
 <div class="container">
  <div class="row">


<div>
<?php 
  /*if($user_home->is_logged_in()){ 
 echo '<a href="/aboutus">About</a> <a href="/terms">Terms</a> <a href="/privacy">Privacy</a> <a href="/contact">Contact</a>';
 }else{
     echo '<a href="/terms">Terms</a> <a href="/privacy">Privacy</a> '; 
 }*/
 ?>
 
 <a href="/aboutus">About</a><a href="/contact">Contact</a> <a href="/terms">Terms</a> <a href="/privacy">Privacy</a> 
</div>
<p>Copyright ©  <?php echo SITE_NAME; ?> | All Right Reserved</p>
  
  </div>
 </div>
</footer>
  
<script>
var Page = "<?php echo SITE_URL; ?>";
var TmBack = <?php echo time(); ?>;
var LstFrBx='',LstFrBxNo=0;



(function($) {
  $.fn.easyNotify = function(options) {
  
    var settings = $.extend({
      title: "Notification",
      options: {
        body: "",
        icon: "",
        lang: 'pt-BR',
        onClose: "",
        onClick: "",
        onError: ""
      }
    }, options);

    this.init = function() {
        var notify = this;
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      } 
	  else if (Notification.permission === "granted") {

        var notification = new Notification(settings.title, settings.options);
        
        notification.onclose = function() {
            if (typeof settings.options.onClose == 'function') { 
                settings.options.onClose();
            }
        };

        notification.onclick = function(){
            if (typeof settings.options.onClick == 'function') { 
                settings.options.onClick();
            }
        };

        notification.onerror  = function(){
            if (typeof settings.options.onError  == 'function') { 
                settings.options.onError();
            }
        };

      } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
          if (permission === "granted") {
            notify.init();
          }

        });
      }

    };

    this.init();
    return this;
  };

}(jQuery));


var myFunction = function(){
	alert('Click function');
};



function Now(i,n,m){
	var myImg = i;
	var options = {
		title: n,
		options: {
		  body: m,
		  icon: myImg,
		  lang: 'en-US',
		  onClick: myFunction
		}
	};
	$("#easyNotify").easyNotify(options);
}


var myKeyVals = {type:'FrndLst',usr:'<?php echo $_SESSION['IdSer'];?>'};
var saveData = function(){
	$.ajax({
		type: 'POST',
		url: Page,
		data: myKeyVals,
		dataType: "text",
		success: function(resultData) { 
			var Js = JSON.parse(resultData);
			if(Js.length > 0){
				$("#Connection span.cnt").html(Js.length);
				$("#Connection span.cnt").show();
			}
			else{
				$("#Connection span.cnt").hide();
			}	
		}
	});

	$.ajax({
		type: 'POST',
		url: Page,
		data: {type:'NoticeLst',usr:'<?php echo $_SESSION['IdSer'];?>'},
		dataType: "text",
		success: function(resultData){ 
			var Js = JSON.parse(resultData);
			if(Js.length > 0){
				$("#NoticeLst span.cnt").html(Js.length);
				$("#NoticeLst span.cnt").show();
				var Dta='<ul>';
				for(var i=0;i<Js.length;i++){
					Dta+='<li><a href="'+Page+'profile_info.php?id='+Js[i]['user_unq']+'"><img src="'+Page+'profile_pic_image/'+Js[i]['profile_pic']+'"/> <div><b>'+Js[i]['user_name']+'</b> Acpect Your Friend Request</div></a></li>';
				}
				Dta+='</ul>';
				$('#NoticeLstBxr').html(Dta);
			}
			else{
				$("#NoticeLst span.cnt").hide();
			}
		}
	});
	
	
	
	
	$.ajax({
		type: 'POST',
		url: Page,
		data: {type:'MsgLst',usr:'<?php echo $_SESSION['IdSer'];?>'},
		dataType: "text",
		success: function(resultData){ 
			var Js = JSON.parse(resultData);
			if(Js.length > 0){
				var SndAr=[];
				var Dta='<ul>';
				var Chk=0;
				var CntNt=0;
				for(var i=0;i<Js.length;i++){
					Dta+='<li><a href="'+Page+'message.php?to='+Js[i]['user_unq']+'"><img src="'+Page+'profile_pic_image/'+Js[i]['profile_pic']+'"/> <div><div><b>'+Js[i]['user_name']+'</b> <span>'+Js[i]['date_time']+'</span></div><div style="height: 33px;font-size: 12px;line-height: 16px;">'+Js[i]['msg']+'</div></a></li>';
				
				
					//console.log('Arjun ',MsgPageNt+' - '+Js[i]['status_as']+' - '+Chk);
				
					if(Js[i]['status_as'] == 0){
						CntNt++;
						Chk = 1;
					}
					
					
						if(Js[i]['msg_tm'] > TmBack){
							var nm = Js[i]['user_name'];
							var ms = Js[i]['msg'];
							var mg = Page+'profile_pic_image/'+Js[i]['profile_pic'];
							// Now(mg,nm,ms);
						}
				}
					TmBack = TmBack + 5;
			


			
					if(MsgPageNt == 1 && Chk == 1){
						//console.log('Test 0 : ', Chk);
						UpdateMsg(Js);
					}

				Dta+='</ul>';
				$('#MsgLstBxr').html(Dta);
				
				if(CntNt > 0){
					$("#MsgLst span.cnt").html(CntNt);
					$("#MsgLst span.cnt").show();
					
					//ar
					$("#profile span.cnt").html(CntNt);
					$("#profile span.cnt").show();
					
				}else{
					$("#MsgLst span.cnt").hide();
					
					//ar
					$("#profile span.cnt").hide();
				}	
			}
			else{
				$("#MsgLst span.cnt").hide();
				
				//ar
				$("#profile span.cnt").hide();
			}	
		}
	});
	
}	

 saveData();
window.setInterval(function(){
  saveData();
}, 5000);



</script>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<script>
  var site_url = "<?php echo SITE_URL; ?>";
  
    function onLoad() {
        gapi.load('auth2', function() {
            gapi.auth2.init();
        });
    }
    
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
    	auth2.signOut().then(function () {
    	  console.log('User signed out.');
    	});
    	auth2.disconnect();
    }
  
  
  
/////////////////// fb login  /////////////////////////
  window.fbAsyncInit = function() {
	FB.init({
	  appId      : '466562793992599',
	  cookie     : true,
	  xfbml      : true,
	  version    : 'v3.1'
	});
	  
	FB.AppEvents.logPageView();   
	  
  };

  
  (function(d, s, id){
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) {return;}
	 js = d.createElement(s); js.id = id;
	 js.src = "https://connect.facebook.net/en_US/sdk.js";
	 fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
    
	function testAPI() {
		console.log('Welcome!  Fetching your information.... ');
        FB.api('/me?fields=first_name,last_name,email,name', function(response) { 
            console.log(response);
		   jQuery.ajax({
					type: "POST",
					url: 'fb_login.php',
					dataType: 'json',
					
					data: {first_name: response.first_name,last_name: response.last_name,email: response.email,fb_id:response.id,name: response.name},
					success: function (obj) {
					    
				        /*if(obj==1){
					        window.location.href = site_url ;
					    }else{
					        window.location.href = site_url;
					    }*/
					    
					    if(obj==1){
				            window.location.href = site_url ;
    				    }else if(obj==0){
    				        alert("Your account was deleted. Please contact to administrator");
    				        //$.cookie("PHPSESSID", null);
    				        //$.cookie("G_ENABLED_IDPS", null);
    				        return false;
    				    }
				
					}
			});		

		  console.log('Successful login for: ' + JSON.stringify(response));
		  
		});
	}
	
    function statusChangeCallback(response){
		console.log('statusChangeCallback');
		console.log(response);
		if (response.status === 'connected') {
		  testAPI();
		} 
		else {
		  // The person is not logged into your app or we are unable to tell.
		  document.getElementById('status').innerHTML = 'Please log ' +
			'into this app.';
		}
	}
	
	function checkLoginState() {
	  FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	  });
	}
	
	
	
	/////////////////// fb login end /////////////////////////
		
		
		
	/////////////////// gmail login  /////////////////////////	
		
	
	function onSignIn(googleUser) {
		
	  var profile = googleUser.getBasicProfile();
	  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	  console.log('Name: ' + profile.getName());
	  console.log('Image URL: ' + profile.getImageUrl());
	  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
	  console.log('Email: ' + profile.given_name());
	  console.log('Email: ' + profile.family_name());
	  
	}

	
	function onSuccess(googleUser){
	  console.log('Logged in id: ' + googleUser.getBasicProfile().getId());  
	  console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
	  console.log('Logged in given_name: ' + googleUser.getBasicProfile().getGivenName());
	  console.log('Logged in family_name: ' + googleUser.getBasicProfile().getFamilyName());
	  
			jQuery.ajax({
				type: "POST",
				url: 'gmail_login.php',
				dataType: 'json',
				data: {email: googleUser.getBasicProfile().getEmail(),name:googleUser.getBasicProfile().getName(),img:googleUser.getBasicProfile().getImageUrl(),first_name:googleUser.getBasicProfile().getGivenName(),last_name:googleUser.getBasicProfile().getFamilyName(),gmail_id:googleUser.getBasicProfile().getId()},
				success: function (obj) {
				
					if(obj==1){
				        window.location.href = site_url ;
				    }else if(obj==0){
				        
			            var auth2 = gapi.auth2.getAuthInstance();
                		auth2.signOut().then(function () {
                		  console.log('User signed out.');
                		});
				        alert("Your account was deleted. Please contact to administrator");
				        return false;
				    }
					 
				}
			});	
	}
	
	function onFailure(error) {
	  console.log(error);
	}
	function renderButton(){
	  gapi.signin2.render('my-signin2', {
		'scope': 'profile email',
		'width': 200,
		'height': 26,
		'longtitle': true,
		'theme': 'dark',
		'onsuccess': onSuccess,
		'onfailure': onFailure
	  });
	}

	

	function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(function () {
		  console.log('User signed out.');
		});
	}
	
	 
	
	/////////////////// gmail login end /////////////////////////
</script>




