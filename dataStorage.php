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
//
//deal with input from add movie form
//
$validName = true;
$validCategory = true;
$validLength = true;

if($_POST["submit"] == "Submit")
{
	if	(empty($_POST["name"]) || empty($_POST["category"]) || empty($_POST["length"])) {
		echo"<script type='text/javascript'>alert('Every field must be entered to add a movie.')</script>";
		$validName = $ $validCategory = $validLength = false;
	}

	if (! is_numeric($_POST["length"])) {
		echo"<script type='text/javascript'>alert('The length must be a number.')</script>";
		$validLength = false;
	}
}

if($validName && $validLength && $validCategory) {
	$rented = "available";
	$addmovieStmt = $mysqli->prepare("INSERT INTO videos(name,category,length,rented) VALUES (?,?,?,?)"); 
	$addmovieStmt->bind_param("ssis", $_POST["name"], $_POST["category"], $_POST["length"], $rented);
	$addmovieStmt->execute();
	$addmovieStmt->close();
}

//
//print table with current movie database
//
// $tableName = '';
// $tableCategory = '';
// $tableLength = 0;
// $tableRented ='';


echo '<p> <h3> Current Video Database: </h3>';

echo '<table width="700" border ="1"';
	echo '<tr><th>Name</th><th>Category</th><th>Legnth (minutes)</th><th>Availability</th></tr>';
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
	}
	$tableStmt = $mysqli->prepare("SELECT (name, category, length, rented) FROM videos");
	$tableStmt->bind_param("ssis", $name, $category, $length, $rented);
	$tableStmt->execute();
	$tableStmt->mysqli_bind_result($resultName, $resultCategory, $resultLength, $resultRented);

	while ($row = mysqli_fetch($tableStmt)) {
        echo "<tr>";
        echo "<td>" . $row["tableName"] . "</td>";
    	echo "<td>" . $row["tableCategory"] . "</td>";
    	echo "<td>" . $row["tableLength"] . "</td>";
    	echo "<td>" . $row["tableRengted"] . "</td>";
    	echo "</tr>";
    }
$tableStmt->close();
?>
