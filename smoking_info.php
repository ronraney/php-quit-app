<?php
session_start();  
//Post variables from form
require_once('common.php');

$username = $_SESSION['user']['username'];
$startDate = $_POST["startDate"];
$cigsDay = $_POST["cigsDay"];
$cigsPack = $_POST["cigsPack"];
$costPack = $_POST["costPack"];

//Database connection script

	require_once('database.php');

   $query = "INSERT INTO smoking_info
                 (username, startDate, cigsDay, cigsPack, costPack)
              VALUES
                 ('$username','$startDate', '$cigsDay', '$cigsPack', '$costPack')";
    $db->exec($query);
	 

//The message that will be sent in the email, composed of the input fields on separate lines 

$message = "Smoking Info\r\nUsername: $username\r\nStart Date: $startDate\r\nCigs per Day: $cigsDay\r\nCigs per Pack: $cigsPack\r\nCost per Pack: $costPack\r\n"; 

//Email to send form data to 
$send_to = "Ron <rraney@kumc.edu>";

// Subject for email 
$subject = "Quit Smoking Web App - Smoking Information"; 

////// Redirect user after submitting form  
$redirect_thankyou = 'private.php';  
$redirect_error = 'database_error.php'; 

// NO NEED TO EDIT BELOW HERE !!! 

//Header for from email address - YOU DO NOT NEED TO EDIT THIS 


if ( mail($send_to,$subject,$message) ) 
{ 
    header("Location: $redirect_thankyou"); 
    exit(); 
} 
else 
{ 
    header("Location: $redirect_error"); 
    exit(); 
} 
 
mysql_close($dbc);   
?>
