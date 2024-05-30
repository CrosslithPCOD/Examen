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
    
}
catch(PDOException $e)
{
    echo "Connection Failed: ". $e->getMessage();
}
?>