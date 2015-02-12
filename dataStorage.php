<?php
ini_set('display_errors', 'On'); //turns on error reporting
include 'storedInfo.php'; //storedInfo.php has password stored as $myPassword

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;	
} else {
	echo "Connection worked! <br>";
}

?>