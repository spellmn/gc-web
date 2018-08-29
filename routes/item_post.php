<?php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require '../pdo/mysql.php';			// Connect to the database
	$db = new Db();
        $res = 0;
	if (!empty($_SESSION["id"]) && $_SESSION["id"] > 0)
		$res = updateItem($_SESSION, $_SESSION["id"], $db);
	else
		$res = saveItem($_SESSION, $db);

	if ($res > 0)
		header('location:../item_list.php');
	else
		header('location:../item_edit.php?id='.$_SESSION["id"]);	
	
function saveItem($POST, $db)
{
	$sql = "INSERT INTO Item 
		(manufacturer, model, serialNumber, caliber, general, barrel, frame, notes) 
		VALUES 
		(:manufacturer, :model, :serialNumber, :caliber, :general, :barrel, :frame, :notes);";

	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindValue(":manufacturer", trim(strtoupper($POST["manufacturer"])));
        $sth->bindValue(":model", trim(strtoupper($POST["model"])));
        $sth->bindValue(":serialNumber", trim(strtoupper($POST["serialNumber"])));
        $sth->bindValue(":caliber", trim(strtoupper($POST["caliber"])));
        $sth->bindValue(":general", trim(strtoupper($POST["general"])));
        $sth->bindValue(":barrel", trim(strtoupper($POST["barrel"])));
        $sth->bindValue(":frame", trim(strtoupper($POST["frame"])));
        $sth->bindValue(":notes", trim(strtoupper($POST["notes"])));
	$res = $sth->execute();
	$res = $db->conn->lastInsertId(); 
	return $res;
}

function updateItem($POST, $itemId, $db)
{
	echo "update";
	$sql = "Update Item SET 
		manufacturer = :manufacturer, 
		model = :model, 
		serialNumber = :serialNumber, 
		caliber = :caliber, 
		general = :general, 
		barrel = :barrel, 
		frame = :frame, 
                notes = :notes  
		WHERE id = :id;";

 	$sth = $db->conn->prepare($sql, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_FOUND_ROWS => true));
        $sth->bindValue(":manufacturer", trim(strtoupper($POST["manufacturer"])));
        $sth->bindValue(":model", trim(strtoupper($POST["model"])));
        $sth->bindValue(":serialNumber", trim(strtoupper($POST["serialNumber"])));
        $sth->bindValue(":caliber", trim(strtoupper($POST["caliber"])));
        $sth->bindValue(":general", trim(strtoupper($POST["general"])));
        $sth->bindValue(":barrel", trim(strtoupper($POST["barrel"])));
        $sth->bindValue(":frame", trim(strtoupper($POST["frame"])));
        $sth->bindValue(":notes", trim(strtoupper($POST["notes"])));
	$sth->bindValue(":id", $itemId);
	$res = $sth->execute();
	$res = $sth->rowCount();

	return $res;
}?>
