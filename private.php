<?php 
	session_start();  
    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
	//require_once('database.php');
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can display the user's username to them by reading it from the session array.  Remember that because 
    // a username is user submitted content we must use htmlentities on it before displaying it to the user. 
?> 


<html>
<head>
	<link rel="stylesheet" type="text/css" href="test.css">
</head>
<body>
<h2>Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>, here is your very own quit smoking app!<br /> </h2>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$userID = $_SESSION['user']['username'];
//echo $userID . "<br/>";
 
$query = " 
            SELECT 
                username, 
                startDate, 
                cigsDay, 
                cigsPack, 
                costPack 
            FROM smoking_info 
            WHERE 
                username = :userID 
        "; 
		
$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID);
$result = $statement->execute();

$row_count = $statement->rowCount();
//echo $row_count . "<br/>";

//Check results
if(!$result)
{
    //Query failed
    echo "Query failed";
    //Add debugging code
}
elseif(!$statement->rowCount())
{
    //No results returned
    echo "No user found for user " . htmlentities($userID);
   //Add debugging code
}
else
{
    //A record was returned, display results
    $row = $statement->fetch(PDO::FETCH_ASSOC);
 
    /*echo "Start Date: {$row['startDate']}<br/>\n";
    echo "Cigs per Day: {$row['cigsDay']}<br/>\n";
    echo "Cigs per Pack: {$row['cigsPack']}<br/>\n";
    echo "Cost per Pack: {$row['costPack']}<br/>\n";*/
	
	$startDate = $row['startDate'];
	$cigsDay = $row['cigsDay'];
	$cigsPack = $row['cigsPack'];
	$costPack = $row['costPack'];
	
	/*echo $startDate . "<br>";
	echo $cigsDay . "<br>";
	echo $cigsPack . "<br>";
	echo $costPack . "<br>";*/
}
 
$statement->closeCursor();

//Calculations
$currentDate = date("m/d/y");

$startTimeStamp = strtotime($startDate);
$endTimeStamp = strtotime($currentDate);

$timeDiff = abs($endTimeStamp - $startTimeStamp);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// convert to integer
$numberDays = intval($numberDays);

//calculate how much money spent per day on smoking
$packsPerDay = $cigsDay/$cigsPack;
$costPerDay = $packsPerDay*$costPack;
$moneySaved = $numberDays*$costPerDay; 
$dollars = number_format($moneySaved,2);

$startDate = date("m/d/y", strtotime($startDate));//change startDate display to match current date format

echo "<head><link href='test.css' rel='stylesheet'></head>";
echo "<body style='background: #cccccc;'><div style='text-align: center; display: block; padding: 10px; border: 1px solid black; width: 520px; color: white; background: #2B3399;'><h3>You quit on: " . $startDate; echo "</h3>";
echo "<h3>Today is: " . $currentDate; echo "</h3><hr>";
echo "<h1>Days since you quit! " . $numberDays . "</h1>";
echo "<h3>Packs per day before you quit: " . $packsPerDay . "</h3>";
echo "<h3>Amount you have saved: $" . $dollars . "</h3>";

/*if ($dollars >= 50 && $dollars < 100) {
	echo "<p>Congratulations! You have saved over $50 since you quit smoking! You could buy some groceries, a pair of shoes, a gift for someone special or save it for a rainy day!</p> ";
} 
if ($dollars >= 100 && $dollars < 150) {
	echo "<p>Congratulations! You have saved over $100 since you quit smoking! This could help you get some books for school, catch up on bills, buy your family groceries or a decent cell phone!</p> ";
} 
if ($dollars >= 150 && $dollars < 200) {
	echo "<p>Congratulations! You have saved over $150 since you quit smoking! You could buy some new clothes, an electronic reading tablet, a round-trip. student rate bus ticket to Seattle or help with tuition!</p> ";
}
if($dollars >= 200.00) {
	echo "<p>Congratulations! You are rich!</p>";
} */
echo "</div>";
?>

<!--<h3>Never used this app before? Click link just below</h3><h3><a href="tobacco.php">Provide your personal smoking info</a><br /></h3>-->
<a href="memberlist.php">Memberlist</a><br /> 
<a href="edit_account.php">Edit Account</a><br /> 
<a href="logout.php">Logout</a>
</body>
</html>