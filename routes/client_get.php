<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function getOneClient($id, $db) 
	{
		$sql = "SELECT * FROM Client WHERE id = :id; ";
		$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->bindValue(":id", $id);
		$result = $sth->execute();
		$result = $sth->fetch();
		return $result;
	}

	function getAllClientsInRows($db) 
	{
		$sql = "SELECT * FROM Client ORDER BY lastName, firstName, middleName, dba; ";
		$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$str = "";
		while ($row = $sth->fetch()) {
			$str = $str . "<tr>";
			$str = $str . "<td>".$row["id"]."</td>";
	   		$str = $str . "<td>".fullName($row)."</td>";
	   		$str = $str . "<td>".address($row)."</td>";
	   		$str = $str . "<td>".$row["permitNumber"]."</td>";
	   		$str = $str . "<td><a href='client_edit.php?id=".$row["id"]."'>Edit</a></td>";
	   		$str = $str . "</tr>";
		}
		return $str;
	}

	function fullName($row)
	{
		$first = $row["firstName"];
		$middle = $row["middleName"];
		$last = $row["lastName"];
		$suffix = $row["suffix"];
		$dba = $row["DBA"];

		if (!empty($dba))
		{
			$fullName = $dba;
		}
		else if (empty($middle))
		{
			$fullName = $last . ", " .$first . " " . $suffix;
		}
		else
		{
			$fullName = $last . ", " . $first . " " . $middle . " " . $suffix;
		}

		return $fullName;
	}

	function address($row)
	{
		return $row["city"] . ", " . $row["state"] . " " . $row["zip"];
	}
?>
