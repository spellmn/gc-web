<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function getOneList($id, $db) 
	{
		$sql = "SELECT * FROM Options WHERE list = :list; ";
		$sth = $db->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->bindValue(":list", $list);
		$result = $sth->execute();
		$result = $sth->fetch();
		return $result;
	}

	function getAllList($db) 
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
?>
