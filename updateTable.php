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
		echo " to go to go back to the video page.\n";
	}

	if (! is_numeric($_POST["length"])) {
		echo"<script type='text/javascript'>alert('The length must be a number.')</script>";
		$validLength = false;
		echo "Click ";
		echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
		echo " to go to go back to the video page.\n";
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
		echo " to go to go back to the video page.\n";
	}
}

if(isset($_POST["checkoutid"]))
{
	//update 'rented' from available to rented using value?
	$id = $_POST["checkoutid"];
	$status = 'rented';

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
	} else {
		echo "Connection worked! <br>";
	}

	$checkoutMovieStmt = $mysqli->prepare("UPDATE videos SET rented = ? WHERE id= ?"); 
	$checkoutMovieStmt->bind_param("si", $status, $id);
	$checkoutMovieStmt->execute();
	$checkoutMovieStmt->close();

	echo "Check-out successful! \n";
	echo "Click ";
	echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
	echo " to go to go back to the video page.\n";

}

if(isset($_POST["checkinid"]))
{
	//update 'rented' from rented to available
	$id = $_POST["checkinid"];
	$status = 'available';

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
	} else {
		echo "Connection worked! <br>";
	}

	$checkinMovieStmt = $mysqli->prepare("UPDATE videos SET rented = ? WHERE id= ?"); 
	$checkinMovieStmt->bind_param("si", $status, $id);
	$checkinMovieStmt->execute();
	$checkinMovieStmt->close();

	echo "Check-in successful! \n";
	echo "Click ";
	echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
	echo " to go to go back to the video page.\n";

}

if(isset($_POST["deleteid"]))
{
	$id = $_POST["deleteid"];

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
	} else {
		echo "Connection worked! <br>";
	}

	$deleteMovieStmt = $mysqli->prepare("DELETE FROM videos WHERE id= ?"); 
	$deleteMovieStmt->bind_param("i", $id);
	$deleteMovieStmt->execute();
	$deleteMovieStmt->close();

	echo "Delete successful! \n";
	echo "Click ";
	echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
	echo " to go to go back to the video page.\n";
}

if(isset($_POST["deleteAll"]))
{
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
	} else {
		echo "Connection worked! <br>";
	}

	$deleteAllMovieStmt = $mysqli->prepare("DELETE FROM videos"); 
	$deleteAllMovieStmt->execute();
	$deleteAllMovieStmt->close();

	echo "Delete all successful! \n";
	echo "Click ";
	echo "<a href=http://web.engr.oregonstate.edu/~barnetal/dataStorage.php>here</a>";
	echo " to go to go back to the video page.\n";
}
?>