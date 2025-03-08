<?php
try{    
    // MySQL host (remains localhost)   
    $HOST = "localhost";

    $DBNAME = "sakuranet";
   
    $USER = "root";
    
    $PASS =  "Sairam@151018";
    
    // PDO connection
    $conn = new PDO("mysql:host=".$HOST.";dbname=".$DBNAME."", $USER, $PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo "Database connection failed: " . $e->getMessage();
}
 
