<?php
ini_set('display_errors', 'On'); //turns on error reporting
// include 'storedInfo.php'; //storedInfo.php has password stored as $myPassword

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
} else {
	echo "Connection worked! <br>";
}
?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <form id='addMovie' method="POST" >
  	<fieldset>
  	<legend>Add A Movie To The Database: </legend>
  	<p>Movie Name: <input type= "text" name= "name" /></p>
  	<p>Category: <input type= "text" name= "category" /></p>
  	<p>Length (in minutes): <input type= "text" name= "length" /></p>
  	<p><input type = "submit" name = "submit" value = "Submit" /></p>
  	</fieldset>
  </form>
  </body>
</html>
<?php
//deal with input from add movie form

//make this happen only if submit has been pressed
if	(empty($_POST["name"]) || empty($_POST["category"]) || empty($_POST["length"])) {
	echo"<script type='text/javascript'>alert('Every field must be entered to add a movie.')</script>";
}

if (! is_numeric($_POST["length"])) {
	echo"<script type='text/javascript'>alert('The length must be a number.')</script>";
}
//get here, we know input is valid
$rented = 1;
$addmovieStmt = $mysqli->prepare("INSERT INTO videos(name,category,length,rented) VALUES (?,?,?,?)"); 
$addmovieStmt->bind_param("ssii", $_POST["name"], $_POST["category"], $_POST["length"], $rented);
$addmovieStmt->execute();
$addmovieStmt->close();
?>
