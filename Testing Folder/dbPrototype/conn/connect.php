<?php
$servername = "localhost";
$dbname 	= "tudelft_vragendb";
$username 	= "root";
$password 	= "";

try
{
    $conn = new PDO("mysql:host=$servername;
						dbname=$dbname",
        $username, $password);
    // echo "Connectie gelukt <br/>";
    
}
catch(PDOException $e)
{
    echo "Connection Failed: ". $e->getMessage();
}
?>