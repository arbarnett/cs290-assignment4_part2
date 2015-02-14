<?php
ini_set('display_errors', 'On'); //turns on error reporting
// include 'storedInfo.php'; //storedInfo.php has password stored as $myPassword

?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  <form id='addMovie' method="POST" action = "updateTable.php">
  	<fieldset>
  	<legend>Add A Movie To The Database: </legend>
  	<p>Movie Name: <input type= "text" name= "name" /></p>
  	<p>Category: <input type= "text" name= "category" /></p>
  	<p>Length (in minutes): <input type= "text" name= "length" /></p>
  	<p><input type = "submit" name = "AddMoviesubmit" value = "submit" /></p>
  	</fieldset>
  </form>
  </body>
</html>
<?php
//
//print table with current movie database
//
echo '<p> <h3> Current Video Database: </h3> </p>';

//Drop down Category Option List
if (isset($_POST["categoryChoice"])){
	$categorySelect = $_POST["categoryChoice"];
} else {
	$categorySelect = 'All Categories';
}
echo '<p> <h5>Select a Category:</h5></p>';
echo '<form method="POST" action="dataStorage.php">';
echo '<select name="categoryChoice">';
echo '<option value="All Categories">All Categories</option>';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "barnetal-db", "jVIV8TuG4g2sc4ER", "barnetal-db");
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
	}
$query = "SELECT DISTINCT category FROM videos";

if($categoryResult = $mysqli->query($query)) {
		while ($row = $categoryResult->fetch_row()) {
			$selected ='';
			if ($row[0] == $categorySelect) {
				$selected = 'selected';
			}
			echo '<option value="'.$row[0].'" '.$selected.'>'.$row[0].'</option>';
		}
}
echo '</select>';
echo '<input type="submit" value="update category"/>';
echo '</form>';
echo '<br/>';

$categoryResult->close();

echo '<table width="700" border ="1">';
	echo '<tr><th>Name</th><th>Category</th><th>Legnth (minutes)</th><th>Availability</th><th>Check-Out/Check-In</th><th>Delete?</th></tr>';
	
	if ($categorySelect != 'All Categories') {
		$query = "SELECT name, category, length, rented, id FROM videos WHERE category = '". $categorySelect."'";
	} else {
		$query = "SELECT name, category, length, rented, id FROM videos";
	}

	if($result = $mysqli->query($query)) {
		while ($row = $result->fetch_row()) {
			echo '<tr>';
			echo '<td>'. $row[0] . '</td>';
			echo '<td>'. $row[1] . '</td>';
			echo '<td>'. $row[2] . '</td>';
			echo '<td>'. $row[3] . '</td>';
			if ($row[3] == 'available') {
				echo '<td><form method="POST" action="updateTable.php">';
				echo '<input type="hidden" name="checkoutid" value="'.$row['4'].'"/>';
				echo '<input type="submit" value="Check-Out"/>';
				echo '</form></td>';
			} else if ($row[3] == 'rented') {
				echo '<td><form method="POST" action="updateTable.php">';
				echo '<input type="hidden" name="checkinid" value="'.$row['4'].'"/>';
				echo '<input type="submit" value="Check-In"/>';
				echo '</form></td>';
			}
			echo '<td><form method="POST" action="updateTable.php">';
			echo '<input type="hidden" name="deleteid" value="'.$row['4'].'"/>';
			echo '<input type="submit" value="Delete"/>';
			echo '</form></td>';
			echo '</tr>';
		}
	}
	echo '</table>';
	$result->close();

echo '<br/>';
echo '<form method="POST" action="updateTable.php">';
echo '<input type="hidden" name="deleteAll" value="Delete All"/>';
echo '<input type="submit" value="Delete All"/>';
echo '</form>';

?>
