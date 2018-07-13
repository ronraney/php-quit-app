<?php

$db_name= 'aihreaco_admins';
$db_username = 'aihreaco_admin'; 
$db_password = 'quitSmoking';  
$dsn = "mysql:host=localhost;dbname=$db_name";
try {
    $db = new PDO($dsn, $db_username, $db_password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('database_error.php');
    exit();
}

?>