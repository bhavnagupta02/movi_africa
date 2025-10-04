<?php include 'header.php';
{
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
      echo $BY;   
?>  

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>

<?php  
	  $stmts= $user_home->runQuery("SELECT * FROM admin_manage WHERE id=9");
      $stmts->execute();
      $userRow=$stmts->fetch(PDO::FETCH_ASSOC);
	  $id=9;
?>



<div id="film-banner">
	<div>
		<h2>Privacy Page</h2>
	</div>	
</div>

<section class="feature_listing">
    <div class="container">
        <div class="row">
    <div class="main_div">
	

		<style>	
.btn.btn-success{color:#fff !important;}
.btn.btn-success:hover{color:#000 !important;}




#film-banner div a{transition: all ease-in-out .3s;color: #fff;border: 1px solid #fff;border-radius: 4px;font-size: 14px;text-decoration: none;padding: 1px 16px;cursor: pointer;font-weight: 600;display: inline-block;
margin-top: 18px;}

#Pg-Tp{}
#Pg-Tp h1{font-size: 30px;
margin: 0 0 30px 0;font-family: inherit;
font-weight: 500;
line-height: 1.1;
color: inherit;}
#Pg-Tp h2{font-family: inherit;
font-weight: 500;
line-height: 1.1;
color: inherit;font-size: 24px;
margin: 0 0 30px 0;letter-spacing: 0;
position: relative;
text-align: left;
padding: 0;}

#Pg-Tp h2::before{height:0;}

#Pg-Tp p{margin: 0 0 30px 0;
color: #333;font-size: 18px;
line-height: 28px;
word-wrap: break-word;}

/*------- RESPONSIVE --------*/

@media (min-width:320px) and (max-width:479px) {
#Pg-Tp {
    padding: 24px;
}
}

@media (min-width:480px) and (max-width:639px) {
#Pg-Tp {
    padding: 24px;
}
}
@media (min-width:640px) and (max-width:767px) {
#Pg-Tp {
    padding: 24px;
}
}
</style>			
				
			<div id="Pg-Tp">	
				<?php echo $userRow['col1']; ?>
			</div>
			
           </div>
        </div>
	

        </div>
		<br style="clear:both;">
</section> 
<?php } ?>                  
        
	<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <?php include 'footer.php';?>
    <script>
        document.title = "Privacy";
	</script>
    </body>
</html>
