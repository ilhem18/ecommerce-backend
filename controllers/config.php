<?php 
// Establish a PDO database connection
$dsn = "mysql:host=localhost;dbname=ecommerce;charset=utf8mb4";
$username = "root";
$password = "";
try {
    $con = new PDO($dsn, $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "Error:" .$e->getMessage();
}


?>