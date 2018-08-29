<?php
    require('db.php');
    
    function getInventory($which)
    {
        global $dbh;
        $result = $dbh->query("SELECT d.name as dealer, d.time as dTime, d.distance as dDistance, 
            d.*, r.*
            FROM inventoryView iv
            INNER JOIN dealership d ON tc.dealershipIdx = d.id
            INNER JOIN routeDealership rd ON d.id = rd.dealershipIdx
            INNER JOIN route r ON rd.routeNumber = r.routeNumber
            ORDER BY d.id");
        while($row = $result->fetch ()) {
            $address2 = $row["city"].", ".$row["state"]." ".$row["zip"];
            $element = '{';
            $element = $element . 'dealer:"'.$row["dealer"].'",';
            $element = $element . 'address1:"'.$row["address"].'",';
            $element = $element . 'address2:"'.$address2.'",';
            $element = $element . 'website:"'.$row["website"].'",';
            $element = $element . 'phone:"'.$row["phone"].'",';
            $element = $element . 'distance:"'.$row["dDistance"].'",';
            $element = $element . 'time:"'.$row["dTime"].'",';
            $element = $element . 'completed:"'.$row["completed"].'",';
            $element = $element . 'routeNumber:"'.$row["routeNumber"].'",';
            $element = $element . 'routeName:"'.$row["name"].'",';
            $element = $element . '},';
            $results = $results . $element;  // This builds the array for JavaScript to access
        }
        return $results;
    }
?>