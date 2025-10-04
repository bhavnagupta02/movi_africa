<?php include 'header.php';

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    

if(isset($_POST)){
    if($_POST['login_email'] != '' && $_POST['login_password'] != ''){
       $email = $_POST['login_email'];$pass  = $_POST['login_password'];
       if($user_home->newlogin($email,$pass)){
            $Pt = SITE_URL.'profile_info.php?id='.$_SESSION['IdSer'].'';	
    		echo '<script> window.location.href = "'.$Pt.'"; </script>';
       }
    }   
}



      $stmts= $user_home->runQuery("SELECT * FROM faq where type='faq'");
      $stmts->execute();
      $userRow_faq=$stmts->fetchAll(PDO::FETCH_ASSOC);

    echo $BY;

      
?>


	<style>
		*{box-sizing:border-box}html{font-size:13px;line-height:1.4;font-family:helvetica neue,Helvetica,Arial,sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0;color:#333;background-color:#e6e6e6;}table{border-collapse:collapse;border-spacing:0;border:0}td,th{padding:0}td.top,th.top{vertical-align:top}a{background-color:transparent;text-decoration:none}a:hover{text-decoration:underline}a:active,a:hover{outline:0}a,label{cursor:pointer}img{border:0}b,strong,optgroup{font-weight:700}small{font-size:80%}h1{font-size:2em;margin:.67em 0}p{margin:0;padding:0 0 .5em;text-align:justify}hr{box-sizing:content-box;height:0}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}textarea{overflow:auto}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600%7CPoppins:300,400,600"/>
	<style>
		.Dv100{width: 100%;
max-width: 1120px;
margin: 32px auto 20px;
overflow: hidden;}
		.Dv25{float: right;
width: 336px;
background: #f6f6f6;
border: 1px solid #ddd;
padding: 40px 20px 40px 40px;
box-shadow: 0 4px 10px rgba(152,164,171,.16);
border-radius: 4px;}
		.Dv75{float: left;
width: 780px;}
		
		
		.Dv25 .faq_inner_block {

		}
		
		.Dv25 .faq_single_nav {
			margin: 0 5px;
		}
		
		.Dv25 .faq_inner_block .inner_list > a {
			font-weight: 600;
			margin: 10px 0;
			font-size: 18px;
			line-height: 1.5em;
			display:block;
			color:#3e3e5f;
		}
		
		.Dv25 .faq_inner_block .inner_list > a:hover{
			text-decoration:none;
			color:#a2a2a2;
			cursor:pointer;
		} 
		
		.Dv25 .faq_inner_block .inner_list > a.Act-Be{
			color:#a2a2a2;
		}
		
		.Dv75 .content_item {
			padding-right: 20px;
		}
		
		.Dv75 .faq_item_title{
			box-sizing: border-box;
			color: rgb(28,51,83);
			cursor: pointer;
			font-family: "Poppins", sans-serif;
			font-size: 24px;
			font-weight: 400;
			line-height: 36px;
			margin: 10px 0;
		}
		
		.content_item .TogDv{display:none;margin-left: 25px;}
		
		
		
		.Dv75 .content_item > p {
			font-size: 16px;
			margin: 20px 0 35px;
			line-height: 1.6;
		}
	</style>
	<title>FAQ Page</title>
</head>

<body>

<h2 style="text-align: center;text-transform: uppercase;color: #3e3e5f;font-family:'Poppins', sans-serif;margin: 40px 0 10px;">Help Topics and FAQs</h2>

<div class="Dv100">
    
    
	<div class="Dv25">
	  <div class="faq_single_nav">
		<div class="faq_inner_block">
			<div class="inner_list">
				<a id="g00link" data-fixed="false">What is the Africa Film Club ?</a>
				<a id="g01link" data-fixed="false">Why Africa Film Club ?</a>
				<a id="g02link" data-fixed="false">Is Africa Film Club an investment platform ?</a>
				<a id="g03link" data-fixed="false">What types of films do we choose to exhibit ?</a>
				<a id="g04link" data-fixed="false">Is it safe to invest ?</a>
				<a id="g05link" data-fixed="false">How do I submit a film ?</a>
				<a id="g06link" data-fixed="false">How much does it cost to list my film on Africa Film Club ?</a>
				<a id="g07link" data-fixed="false">Are filmmakers vetted ?</a>
				<a id="g08link" data-fixed="false">How do I gain investor interest if I am a first time filmmaker ?</a>
				<a id="g09link" data-fixed="false">What are the benefits for filmmakers on Africa Film Club ?</a>
				<a id="g10link" data-fixed="false">Still have questions ? Contact us and we will get back to you soonest possible.</a>
			</div>
		</div>
	  </div>	
	</div>
	<div class="Dv75">
	  <?php
		   $Cn=0;	               
                foreach ($userRow_faq as $val){
              
	
if($Cn == 0){
	?>
					<div class="content_item" id="g0<?php echo $Cn;?>">
						<h3 class="faq_item_title"> <i class="fa fa-minus" aria-hidden="true"></i><?php echo $val['faq_ques']; ?></h3>
						<div class="TogDv" style="display:block;"><p><?php echo $val['faq_ans']; ?></p></div>
					</div>
	
	<?php
}
else{

	
                  ?>
                  
	
	
				   <div class="content_item" id="g0<?php echo $Cn;?>">
						<h3 class="faq_item_title"> <i class="fa fa-plus" aria-hidden="true"></i><?php echo $val['faq_ques']; ?></h3>
						<div class="TogDv" style="display:none;"><p><?php echo $val['faq_ans']; ?></p></div>
					</div>
            
					
             	
	
	
	 <?php
}	 
	 $Cn++;
	 
               }
             ?>
             
</div>

</div>


</body>
<?php include 'footer.php';?>
<script>

	var Gid = 'g01';
	
    function goToByScroll(id){
        id = id.replace("link","");
		if(Gid != id){
			$("#"+Gid+' .TogDv').hide();
			$("#"+Gid+' .faq_item_title i').attr('class','fa fa-plus');
			$('html,body')
				.animate(
					{
						scrollTop: $("#"+id).offset().top - 60 
					},
					'slow'
				);
				$("#"+id+' .TogDv').show();
				$("#"+id+' .faq_item_title i').attr('class','fa fa-minus');
				Gid=id;
		}
		else if(Gid == id){
			$("#"+Gid+' .TogDv').toggle();
			if($("#"+Gid+' .TogDv').css('display') == 'block') $("#"+id+' .faq_item_title i').attr('class','fa fa-minus');
			else
				$("#"+id+' .faq_item_title i').attr('class','fa fa-plus');
				$("#"+id+'link').removeClass('Act-Be');
			
		}
		else{
			$("#"+Gid+' .TogDv').hide();
			$("#"+Gid+' .faq_item_title i').attr('class','fa fa-plus');
		}
    }

	
	$(".faq_item_title").click(function(f){
		$("#"+Gid+'link').removeClass('Act-Be');
		
		$("#"+$(this).parent().attr('id')+'link').addClass('Act-Be');
		
		f.preventDefault(); 
        goToByScroll($(this).parent().attr('id')+'link');  
	});
	
    $(".faq_inner_block .inner_list a").click(function(e) {
		$(".faq_inner_block .inner_list a").removeClass('Act-Be');
		$(this).addClass('Act-Be');
		e.preventDefault(); 
        goToByScroll($(this).attr("id"));           
    });
</script>	
</html>