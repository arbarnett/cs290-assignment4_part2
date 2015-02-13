<?php
//move add a movie to the database
$validName = true;
$validCategory = true;
$validLength = true;

if(isset($_POST["AddMoviesubmit"]))
{
	if	(empty($_POST["name"]) || empty($_POST["category"]) || empty($_POST["length"])) {
		echo"<script type='text/javascript'>alert('Every field must be entered to add a movie.')</script>";
		$validName = $ $validCategory = $validLength = false;
		echo "Click ";
		echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
		echo " to go to go back to the video.\n";
	}

	if (! is_numeric($_POST["length"])) {
		echo"<script type='text/javascript'>alert('The length must be a number.')</script>";
		$validLength = false;
		echo "Click ";
		echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
		echo " to go to go back to the video.\n";
	}


	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
	} else {
		echo "Connection worked! <br>";
	}

	if($validName && $validLength && $validCategory) {
		$rented = "available";
		$addmovieStmt = $mysqli->prepare("INSERT INTO videos(name,category,length,rented) VALUES (?,?,?,?)"); 
		$addmovieStmt->bind_param("ssis", $_POST["name"], $_POST["category"], $_POST["length"], $rented);
		$addmovieStmt->execute();
		$addmovieStmt->close();
		echo "Addition successful! \n";
		echo "Click ";
		echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
		echo " to go to go back to the video.\n";
	}
}

	
?>