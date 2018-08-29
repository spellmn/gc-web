<?php  
class Db {

    public $conn;

    // ********************************************************* //
    // This initiations the database connection                  //
    // ********************************************************* //
    function __construct() {
        $ini_array = parse_ini_file("settings.ini");
        $myPass   = $ini_array["myPass"];
        $myUser   = $ini_array["myUser"];
        $myDb     = $ini_array["myDb"];
        $myServer = $ini_array["myServer"];
        // echo $myServer."<br />";
        // echo $myDb."<br />";
        // echo $myUser."<br />";
        // echo $myPass."<br />";
        try {
            $dbh = new PDO ("mysql:host=$myServer;dbname=$myDb","$myUser","$myPass");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        $this->conn = $dbh;
    }
}

?>


