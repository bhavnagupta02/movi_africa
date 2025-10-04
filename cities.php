<?php 
$arg = $_POST['arg'];
if(!empty($arg)){
    
    $ch = curl_init();
    $curlConfig = array(
        CURLOPT_URL            => "https://www.rockethub.com/misc/cities.php",
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => array(
            'arg' => $arg,
 
        )
    );
    curl_setopt_array($ch, $curlConfig);
    $result = curl_exec($ch);
    curl_close($ch);
    

	print_r($result);

    
}





?>