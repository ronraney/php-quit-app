<?php
session_start();  
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="test.css">
</head>
<body>
	<h1 class="textAlignCenter">Have you already entered this information?</h1><a href="private.php" class="homeLink">Go To My Home Page</a></h1>
	<h2 class="textAlignCenter">If not, please enter the following:</h2>
	<form id="tobaccoForm" action="smoking_info.php" enctype="multipart/form-data" method="POST">
	<fieldset>
	<legend>Your Smoking Information</legend>
	<p>When did you quit smoking cigarettes?: <input name="startDate" required="required" type="date"></p>
	<p>How many cigarettes did you smoke per day, on average?: <input name="cigsDay" required="required" type="number" value="20"></p>
	<p>How many cigarettes in each pack?: <input name="cigsPack" required="required" type="number" value="20"></p>
	<p>How much did each pack cost, on average?: <input type="number" name="costPack" min="0" max="9999" step="0.01" size="4" 
    title="CDA Currency Format - no dollar sign and no comma(s) - cents (.##) are optional" value="5.00"/>
	</fieldset>
	<input value="submit" id="submitBtn" type="submit">
	
	</form>
	
</body>
</html>