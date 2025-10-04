<?php
class Database
{
     
    private $host     = "localhost";
    private $db_name  = "saleofcl_moviafrica";
    private $username = "root";
    private $password = "";
    public $conn;
     
    public function dbConnection()
	{
        // define("SITE_URL","https://moviafrica.com/");
        define("SITE_URL","http://localhost/movi_africa/");
        define("FROM_EMAIL","test@forevershayari.com");
        define("SITE_NAME","MOVI AFRICA");
        define("GMAIL_LOGIN_CLIENT_ID","425192971124-7s3aet3hgo7uhunts3up6u51mcs9c9ho.apps.googleusercontent.com");
        
        
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
                         
        }
		catch(PDOException $exception)
		{
             echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}
?>