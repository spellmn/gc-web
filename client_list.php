<?php
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include './routes/client_get.php';
  require './pdo/mysql.php';    // Connect to the database
  $db = new Db();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
<link rel="manifest" href="icon/site.webmanifest">
<link rel="mask-icon" href="icon/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="icon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="icon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<script type="text/javascript" src="./script/menu.js"></script>  

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
}
</style>
</head>
<body>
  <?php include('sidebar.php'); ?>

  <div id="main">
<?php include('header.php'); ?>
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" id="frmItem"  name="frmItem">


<a href="client_edit.php">New</a>
<table border="1'">
  <tr>
  <th>Id</th>
  <th>Name</th>
  <th>Address</th>
  <th>Permit Number</th>
  <th>Action</th>
</tr>
  <?php echo getAllClientsInRows($db); ?>
</table>
</form>

</div>
</body>
</html>
