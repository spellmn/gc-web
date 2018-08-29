<?php

/*
	This method is used to select, insert, update or delete rows
		from the OPTION(s) table(s)
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './pdo/mysql.php';			// Connect to the database

$db = new Db();
//$results = fillList(0, true, 0);

function fillList($value, $blank, $selected) {
	global $db;
	$sql = "SELECT longName, shortName, ord FROM OptionsView WHERE list = :value ORDER BY ord, shortName ";
	//echo $sql;
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':value' => $value));

	$result = array();
	if ($blank == true) {
   		array_push($result, '<option value="">-- Make Selection --</option>');
	}

	while ($row = $sth->fetch()) {
	    if ($row["id"] === $selected) {
    	  	array_push($result, "<option SELECTED value=\"".$row["shortName"]."\">" . $row["shortName"] . "</option>");
     	} else {
       		array_push($result, "<option value=\"".$row["shortName"]."\">" . $row["shortName"] . "</option>");
     	}
	}
	return $result;
}

//$updated = $db->itemUpdate($I);


    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     foreach($_POST as $key => $value)
    //     {
    //       echo $key."=".$value."<br />";
    //     }
    // }

function fillListByValue($value, $blank, $selectedValue) {
	global $db;
	$sql = "SELECT longName, shortName, ord FROM OptionsView WHERE list = :value ORDER BY ord, shortName ";
	//echo $sql;
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':value' => $value));

	$result = array();
	if ($blank == true) {
   		array_push($result, '<option value="">-- Make Selection --</option>');
	}

	while ($row = $sth->fetch()) {
	    if (strtoupper(trim($row["shortName"])) === trim(strtoupper($selectedValue)))
	    {
    	  	array_push($result, "<option SELECTED value=\"".$row["shortName"]."\">" . $row["shortName"] . "</option>");
     	} else {
       		array_push($result, "<option value=\"".$row["shortName"]."\">" . $row["shortName"] . "</option>");
     	}
	}
	return $result;
}
?>
