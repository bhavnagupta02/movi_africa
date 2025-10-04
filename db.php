<?php
    $database = "saleofcl_moviafrica";
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_select_db($conn, $database);
    
    // define("SITE_URL", "https://moviafrica.com/");
    define("SITE_URL", "http://localhost/movi_africa/");
    define("SITE_NAME", "Africa Film Club");

    //define("FROM_EMAIL","test@forevershayari.com");
  
  
    define("CLIENT_TIME_ZONE", "Asia/Kolkata");
