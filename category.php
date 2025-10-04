<?php include 'header.php';?>

<style>	
#AppID{
	margin: 32px auto 64px;
	width: 1200px;
	text-align: center;
}
#AppID .CatBx{
    width: 276px;
	display: inline-block;
	margin: 20px 10px 0;
	background: #fff;
	border-radius: 8px;
	overflow: hidden;
	box-shadow: 0px 0px 9px #aaa;
	text-decoration: none;
}
#AppID .CatBx img{}
#AppID .CatBx h2{
	color:#111;
	font-size:13px;
}
</style>
	
<?php		
	if($user_home->is_logged_in()){
		echo '<div style="height:30px;width:100%;"></div>';
	}	
?>

	<div id="AppID">
        <h1 style="text-align: left;font-size: 17px;color: #999797;letter-spacing: 1px;">Explore By Category</h1>
    </div>

			
	<?php include 'footer.php'; ?>				
		
	</body>
	
	<script>
	    document.title = "Category - Rocket H";
		var Cat = ["Outdoors & Adventure","Tech","Family","Health & Wellness","Sports & Fitness","Learning","Photography","Food & Drink"];
		var Catrl = ["Outdoors-Adventure","Tech","Family","Health-Wellness","Sports-Fitness","Learning","Photography","Food-Drink"];
		for(var i=0;i<Cat.length;i++){
			var Data='<a class="CatBx" href="categoty/'+Catrl[i]+'"><img src="webimg/'+(i+1)+'.JPG"/><h2>'+Cat[i]+'</h2></a>';
			$('#AppID').append(Data);
		}
	</script>
	
</html>