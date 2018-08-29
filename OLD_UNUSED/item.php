<?php
/* This method is used to insert, update or delete rows from the ITEM table */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Required for SQL date conversion (mm/dd/Y -> Y-m-d)
date_default_timezone_set('America/New_York');//

function getAllItems($db) 
{
	$sql = "SELECT * FROM Item ORDER BY Manufacturer; ";
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute();
	$str = "";
	while ($row = $sth->fetch()) {
		$str = $str . "<tr>";
   		$str = $str . "<td>".$row["id"]."</td>";
   		$str = $str . "<td>".$row["manufacturer"]."</td>";
   		$str = $str . "<td>".$row["model"]."</td>";
   		$str = $str . "<td>".$row["serialNumber"]."</td>";
   		$str = $str . "<td>".$row["caliber"]."</td>";
   		$str = $str . "<td>".$row["barrel"]."</td>";
   		$str = $str . "<td>".$row["general"]."</td>";
   		$str = $str . "<td>".$row["frame"]."</td>";
   		$str = $str . "<td><a href='item_edit.php?id=".$row["id"]."'>Edit</a></td>";
   		$str = $str . "</tr>";
	}
	return $str;
}

/*  Not used that here that I know of, used in the GET class  */
function getOneItem($id, $db) 
{
	$sql = "SELECT * FROM Item i WHERE i.id = :id; ";
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->bindValue(":id", $id);
	$result = $sth->execute();
	$result = $sth->fetch();
	return $result;
}







function getDps3c($POST, $db) 
{
	$sql = "SELECT id 
		FROM Dps3c 
		WHERE authNumber = :authNumber ; ";
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	$sth->bindValue(":authNumber", $POST["authNumber"]);
	$sth->execute();
	$res = $sth->fetchColumn();

	return $res;
}





function saveDps3c($POST, $db)
{
	// Compound Variables
	$pName = fullName($POST["pFirstName"],$POST["pMiddleName"], $POST["pLastName"], $POST["pSuffix"]);
	$sName = fullName($POST["sFirstName"],$POST["sMiddleName"], $POST["sLastName"], $POST["sSuffix"]);
	$pAddress = fullAddress($POST["pStreet1"],$POST["pStreet2"], $POST["pCity"], $POST["pState"], $POST["pZip"]);
	$sAddress = fullAddress($POST["sStreet1"],$POST["sStreet2"], $POST["sCity"], $POST["sState"], $POST["sZip"]);
	$pDOB = date("Y-m-d", strtotime($POST["pDOB"]));
	$sDOB = date("Y-m-d", strtotime($POST["sDOB"]));
	$dateOfSale = date("Y-m-d", strtotime($POST["dateOfSale"]));

	$sql = "INSERT INTO Dps3c 
	( authNumber,  manufacturer,  model,  serialNumber,  caliber,  general,  barrel,  frame,  pDOB,  pPOB,  pName,  pPermitNumber,  sName,  sDOB,  sPermitNumber,  dateOfSale, pAddress, sAddress, 
		pFirstName, pMiddleName, pLastName, pSuffix, pStreet1, pStreet2, pCity, pState, pZip,
		sFirstName, sMiddleName, sLastName, sSuffix, sStreet1, sStreet2, sCity, sState, sZip) 
	VALUES 
	(:authNumber, :manufacturer, :model, :serialNumber, :caliber, :general, :barrel, :frame, :pDOB, :pPOB, :pName, :pPermitNumber, :sName, :sDOB, :sPermitNumber, :dateOfSale, :pAddress, :sAddress,
		:pFirstName, :pMiddleName, :pLastName, :pSuffix, :pStreet1, :pStreet2, :pCity, :pState, :pZip,
		:sFirstName, :sMiddleName, :sLastName, :sSuffix, :sStreet1, :sStreet2, :sCity, :sState, :sZip
	)";
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	$sth->bindValue(":authNumber", strtoupper($POST["authNumber"]));
	$sth->bindValue(":manufacturer", strtoupper($POST["manufacturer"]));
	$sth->bindValue(":model", strtoupper($POST["model"]));
	$sth->bindValue(":serialNumber", strtoupper($POST["serialNumber"]));
	$sth->bindValue(":caliber", strtoupper($POST["caliber"]));
	$sth->bindValue(":general", strtoupper($POST["general"]));	
	$sth->bindValue(":barrel", strtoupper($POST["barrel"]));
	$sth->bindValue(":frame", strtoupper($POST["frame"]));

	$sth->bindValue(":pDOB", strtoupper($pDOB));
	$sth->bindValue(":pPOB", strtoupper($POST["pPOB"]));
	$sth->bindValue(":pName", strtoupper($pName));
	$sth->bindValue(":pPermitNumber", strtoupper($POST["pPermitNumber"]));

	$sth->bindValue(":sName", strtoupper($sName));
	$sth->bindValue(":sDOB", strtoupper($sDOB));
	$sth->bindValue(":sPermitNumber", strtoupper($POST["sPermitNumber"]));
	$sth->bindValue(":dateOfSale", strtoupper($dateOfSale));
	$sth->bindValue(":pAddress", strtoupper($pAddress));
	$sth->bindValue(":sAddress", strtoupper($sAddress));

	$sth->bindValue(":pFirstName", 	strtoupper($POST["pFirstName"]));
	$sth->bindValue(":pMiddleName", strtoupper($POST["pMiddleName"]));
	$sth->bindValue(":pLastName", 	strtoupper($POST["pLastName"]));
	$sth->bindValue(":pSuffix", 	strtoupper($POST["pSuffix"]));
	$sth->bindValue(":pStreet1", 	strtoupper($POST["pStreet1"]));
	$sth->bindValue(":pStreet2", 	strtoupper($POST["pStreet2"]));
	$sth->bindValue(":pCity", 		strtoupper($POST["pCity"]));
	$sth->bindValue(":pState", 		strtoupper($POST["pState"]));
	$sth->bindValue(":pZip", 		strtoupper($POST["pZip"]));

	$sth->bindValue(":sFirstName", 	strtoupper($POST["sFirstName"]));
	$sth->bindValue(":sMiddleName", strtoupper($POST["sMiddleName"]));
	$sth->bindValue(":sLastName", 	strtoupper($POST["sLastName"]));
	$sth->bindValue(":sSuffix", 	strtoupper($POST["sSuffix"]));
	$sth->bindValue(":sStreet1", 	strtoupper($POST["sStreet1"]));
	$sth->bindValue(":sStreet2", 	strtoupper($POST["sStreet2"]));
	$sth->bindValue(":sCity", 	 	strtoupper($POST["sCity"]));
	$sth->bindValue(":sState",	 	strtoupper($POST["sState"]));
	$sth->bindValue(":sZip", 	 	strtoupper($POST["sZip"]));

	$res = $sth->execute();
	$res = $db->conn->lastInsertId(); 
	return $res;
}

// function saveDps3c()
// {

// 	 $json = json_encode($POST);
// 	 echo "Save!";
// 	 echo $json;
// }

function updateDps3c($POST, $dps3cId, $db)
{
	// $json = json_encode($_POST);
	// echo "Save!";
	// echo $json;

	// Compound Variables
	$pName = fullName($POST["pFirstName"],$POST["pMiddleName"], $POST["pLastName"], $POST["pSuffix"]);
	$sName = fullName($POST["sFirstName"],$POST["sMiddleName"], $POST["sLastName"], $POST["sSuffix"]);
	$pAddress = fullAddress($POST["pStreet1"],$POST["pStreet2"], $POST["pCity"], $POST["pState"], $POST["pZip"]);
	$sAddress = fullAddress($POST["sStreet1"],$POST["sStreet2"], $POST["sCity"], $POST["sState"], $POST["sZip"]);
	$pDOB = date("Y-m-d", strtotime($POST["pDOB"]));
	$sDOB = date("Y-m-d", strtotime($POST["sDOB"]));
	$dateOfSale = date("Y-m-d", strtotime($POST["dateOfSale"]));

	$sql = "UPDATE Dps3c SET 
		authNumber = :authNumber, 
		manufacturer = :manufacturer, 
		model = :model, 
		serialNumber = :serialNumber, 
		caliber = :caliber, 
		general = :general, 
		barrel = :barrel, 
		frame = :frame, 
		pDOB = :pDOB, 
		pPOB = :pPOB, 
		pName = :pName, 
		pPermitNumber = :pPermitNumber, 
		sName = :sName, 
		sDOB = :sDOB, 
		sPermitNumber = :sPermitNumber, 
		dateOfSale = :dateOfSale, 
		pAddress = :pAddress, 
		sAddress = :sAddress 
		WHERE id = :id;";

//	echo "<br/><br>".$sql;
	$sth = $db->conn->prepare($sql, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_FOUND_ROWS => true));

	$sth->bindValue(":authNumber", strtoupper($POST["authNumber"]));
	$sth->bindValue(":manufacturer", strtoupper($POST["manufacturer"]));
	$sth->bindValue(":model", strtoupper($POST["model"]));
	$sth->bindValue(":serialNumber", strtoupper($POST["serialNumber"]));
	$sth->bindValue(":caliber", strtoupper($POST["caliber"]));
	$sth->bindValue(":general", strtoupper($POST["general"]));
	$sth->bindValue(":barrel", strtoupper($POST["barrel"]));
	$sth->bindValue(":frame", strtoupper($POST["frame"]));

	$sth->bindValue(":pDOB", strtoupper($pDOB));
	$sth->bindValue(":pPOB", strtoupper($POST["pPOB"]));
	$sth->bindValue(":pName", strtoupper($pName));
	$sth->bindValue(":pPermitNumber", strtoupper($POST["pPermitNumber"]));

	$sth->bindValue(":sName", strtoupper($sName));
	$sth->bindValue(":sDOB", strtoupper($sDOB));
	$sth->bindValue(":sPermitNumber", strtoupper($POST["sPermitNumber"]));
	$sth->bindValue(":dateOfSale", strtoupper($dateOfSale));
	$sth->bindValue(":pAddress", strtoupper($pAddress));
	$sth->bindValue(":sAddress", strtoupper($sAddress));
	$sth->bindValue(":id", $dps3cId);

	$res = $sth->execute();
	$res = $sth->rowCount(); 

	return $res;
}


?>