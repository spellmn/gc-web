<?php
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require '../pdo/mysql.php';			// Connect to the database
	$db = new Db();

    date_default_timezone_set('America/New_York');

	if (!empty($_SESSION["id"]) && $_SESSION["id"] > 0)
		$res = updateClient($_SESSION, $_SESSION["id"], $db);
	else
		$res = saveClient($_SESSION, $db);

	if ($res > 0)
		header('location:../client_list.php');
	else
		header('location:../client_edit.php?id='.$_SESSION["id"]);	
	echo "Res: ". $res;

function saveClient($POST, $db)
{
	$res = 0;
 	$sql = "INSERT INTO Client 
		(DBA, firstName, middleName, lastName, suffix, street1, street2, city, state, zip, permitNumber, DOB, POB, emailAddress, website, phoneNumber, identity) 
		VALUES 
		(:DBA, :firstName, :middleName, :lastName, :suffix, :street1, :street2, :city, :state, :zip, :permitNumber, :DOB, :POB, :emailAddress, :website, :phoneNumber, :identity);";
	
	$DOB = 'NULL';
	 try {
	 	 $date = new DateTime($POST["DOB"]);
	 	 $DOB = $date->format('Y-m-d'); // 31.07.2012
	 } catch (Exception $e) {
	     //echo 'Caught exception: ',  $e->getMessage(), "\n";
	 } 
    
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->bindValue(":DBA", trim(strtoupper($POST["DBA"])));
	$sth->bindValue(":firstName", trim(strtoupper($POST["firstName"])));
	$sth->bindValue(":middleName", trim(strtoupper($POST["middleName"])));
	$sth->bindValue(":lastName", trim(strtoupper($POST["lastName"])));
	$sth->bindValue(":suffix", trim(strtoupper($POST["suffix"])));
	$sth->bindValue(":street1", trim(strtoupper($POST["street1"])));
	$sth->bindValue(":street2", trim(strtoupper($POST["street2"])));
	$sth->bindValue(":city", trim(strtoupper($POST["city"])));
	$sth->bindValue(":state", trim(strtoupper($POST["state"])));
	$sth->bindValue(":zip", trim(strtoupper($POST["zip"])));
	$sth->bindValue(":permitNumber", trim(strtoupper($POST["permitNumber"])));
	$sth->bindValue(":DOB", $DOB);
	$sth->bindValue(":POB", trim(strtoupper($POST["POB"])));
	$sth->bindValue(":emailAddress", trim(strtoupper($POST["emailAddress"])));
	$sth->bindValue(":website", trim(strtoupper($POST["website"])));
	$sth->bindValue(":phoneNumber", trim(strtoupper($POST["phoneNumber"])));
	$sth->bindValue(":identity", trim(strtoupper($POST["identity"])));

	$res =  $sth->execute();
	$res = $db->conn->lastInsertId(); 

	return $res;
}

function updateClient($POST, $clientId, $db)
{
	$res = 0;
	$sql = "Update Client SET 
		DBA = :DBA, 
		firstName = :firstName, 
		middleName = :middleName, 
		lastName = :lastName, 
		suffix = :suffix, 
		street1 = :street1, 
		street2 = :street2,
		city = :city, 
		state = :state, 
		zip = :zip, 
		permitNumber = :permitNumber, 
		DOB = :DOB, 
		POB = :POB, 
		emailAddress = :emailAddress, 
		website = :website, 
		phoneNumber = :phoneNumber, 
		identity = :identity 
		WHERE id = :id;";

 	$sth = $db->conn->prepare($sql, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_FOUND_ROWS => true));
 	$DOB = 'NULL';
	if (!empty($POST["DOB"]))
	{
	  try {
	 	$date = new DateTime($POST["DOB"]);
	 	$DOB = $date->format('Y-m-d'); // 31.07.2012
	 	echo "Updated DOB";
	  } catch (Exception $e) {
	     echo 'Caught exception: ',  $e->getMessage(), "\n";
	  }
	} 

	$sth->bindValue(":DBA", trim(strtoupper($POST["DBA"])));
	$sth->bindValue(":firstName", trim(strtoupper($POST["firstName"])));
	$sth->bindValue(":middleName", trim(strtoupper($POST["middleName"])));
	$sth->bindValue(":lastName", trim(strtoupper($POST["lastName"])));
	$sth->bindValue(":suffix", trim(strtoupper($POST["suffix"])));
	$sth->bindValue(":street1", trim(strtoupper($POST["street1"])));
	$sth->bindValue(":street2", trim(strtoupper($POST["street2"])));
	$sth->bindValue(":city", trim(strtoupper($POST["city"])));
	$sth->bindValue(":state", trim(strtoupper($POST["state"])));
	$sth->bindValue(":zip", trim(strtoupper($POST["zip"])));
	$sth->bindValue(":permitNumber", trim(strtoupper($POST["permitNumber"])));
	$sth->bindValue(":DOB", $DOB);
	$sth->bindValue(":POB", trim(strtoupper($POST["POB"])));
	$sth->bindValue(":emailAddress", trim(strtoupper($POST["emailAddress"])));
	$sth->bindValue(":website", trim(strtoupper($POST["website"])));
	$sth->bindValue(":phoneNumber", trim(strtoupper($POST["phoneNumber"])));
	$sth->bindValue(":identity", trim(strtoupper($POST["identity"])));
	$sth->bindValue(":id", $clientId);
	$res = $sth->execute();
	$res = $sth->rowCount();

	return $res;
}

?>
