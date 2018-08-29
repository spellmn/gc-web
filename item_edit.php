<?php
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include './option.php';
  include './routes/item_get.php';

  $errCount = $id = 0;
  $manufacturer    = $model    = $serialNumber    = $caliber    = $barrel =    $frame    = $general    = ""; 
  $manufacturerErr = $modelErr = $serialNumberErr = $caliberErr = $barrelErr = $frameErr = $generalErr = "";

  $leftImage    = $rightImage    = $frontImage    = $rearImage    = $notes = "";
  $leftImageErr = $rightImageErr = $frontImageErr = $rearImageErr = $notesErr = "";

#//echo "<script>console.log( 'Debug Objects: A" .$_SERVER["REQUEST_METHOD"]   . "' );</script>";
$action = "inserting a new item.";
  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['id']))  
  {
    $action = "updating an existing item.";
    $RET = getOneItem($_GET["id"], $db);
    $id  = test_input($RET["id"]);
    $manufacturer = test_input($RET["manufacturer"]);
    $model = test_input($RET["model"]);
    $serialNumber = test_input($RET["serialNumber"]);
    $caliber = test_input($RET["caliber"]);
    $barrel = test_input($RET["barrel"]);
    $general = test_input($RET["general"]);
    $frame = test_input($RET["frame"]);
    $leftImage = test_input($RET["imgLeft"]);
    $rightImage = test_input($RET["imgRight"]);
    $rearImage = test_input($RET["imgRear"]);
    $frontImage = test_input($RET["imgFront"]);
    $notes = test_input($RET["notes"]);
  } 
  else if ($_SERVER["REQUEST_METHOD"] == "POST" )  
	{

    $manufacturer = test_input($_POST["manufacturer"]);
    $model = test_input($_POST["model"]);
    $serialNumber = test_input($_POST["serialNumber"]);
    $caliber = test_input($_POST["caliber"]);
    $barrel = test_input($_POST["barrel"]);
    $general = test_input($_POST["general"]);
    $frame = test_input($_POST["frame"]);
    $leftImage = test_input($_POST["leftImage"]);
    $rightImage = test_input($_POST["rightImage"]);
    $rearImage = test_input($_POST["rearImage"]);
    $frontImage = test_input($_POST["frontImage"]);
    $notes = test_input($_POST["notes"]);

    // foreach($_POST as $key => $value)
    // {
    //   echo $key."=".$value."<br />";
    // }

  	if (empty($serialNumber))
  	{
  		$serialNumberErr = "Serial Number is Required.";
  		$errCount++;
  	}

  	if (empty($model))
  	{
  		$modelErr = "Model is Required.";
  		$errCount++;
  	}

  	if (empty($manufacturer))
  	{
  		$manufacturerErr = "Manufacturer is Required.";
  		$errCount++;
  	}

  	if (empty($caliber))
  	{
  		$caliberErr = "Caliber is Required.";
  		$errCount++;
  	}

  	if (empty($barrel))
  	{
  		$barrelErr = "Barrel is Required.";
  		$errCount++;
  	}

  	if (empty($frame))
  	{
  		$frameErr = "Frame is Required.";
  		$errCount++;
  	}

  	if (empty($general))
  	{
  		$generalErr = "General is Required.";
  		$errCount++;
  	}

  	if ($errCount != 0)
  	{
  	//echo $errCount . " Errors";
  	} else {
  		$_SESSION = $_POST;
      // $_SESSION["leftImage"] = $_FILES['leftImage']['name'];
  		header('location:./routes/item_post.php');
  		//echo "<a href='item.php'>BACK</a>";
  		exit();
  	}  
  }

  function test_input($data) {
    if ($data == null)
      $data = "";
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

  <?php include('sidebar.php'); ?>

<div id="main">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" id="frmItem"  name="frmItem">
    <!--  *************************************************************************************** -->
    <!--  ****************************  Main Table ********************************************** -->
    <!--  *************************************************************************************** -->
    <div style="width: 800px; text-align: center; font-weight: bold;">You are currently <?php echo $action ?></div>
  <table width="800px">
    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;">
        <label for="manufacturer">Manufacturer</label>
        <span class="error"> <?php echo $manufacturerErr;?></span>
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <label for="model">Exact Model</label>
        <span class="error"> <?php echo $modelErr;?></span>
      </td> 
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;">
      <select class="form-control" id="manufacturer" name="manufacturer">
        <?php foreach(fillListByValue('MANUFACTURER', true, $manufacturer) as $i => $item) { print $item; } ?>
      </select>
    </td>
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="model" name="model" value="<?php echo $model; ?>">
      </td>

    </tr>
    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;">
        <label for="caliber_gauge">Caliber/Gauge</label>
        <span class="error"> <?php echo $caliberErr;?></span>
      </td>

      <td style="background-color: #6C7B7C; color: black;">
        <label for="barrel_length">Barrel Length</label>
        <span class="error"> <?php echo $barrelErr;?></span>
      </td>
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;">
      <select class="form-control" id="caliber" name="caliber">
        <?php foreach(fillListByValue('CALIBER', true, $caliber) as $i => $item) { print $item; } ?>
      </select>
      </td> 
      <td style="background-color: #6C7B7C; color: black;">
          <input type="text" class="form-control" id="barrel" name="barrel" value="<?php echo $barrel; ?>">
      </td>
    </tr>

    <tr class="title">
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="serialNumber">Serial Number</label>
          <span class="error"> <?php echo $serialNumberErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="notes">Note</label>
          <span class="error"> <?php echo $notesErr;?></span>
        </td>
    </tr>
    <tr class="title-form">
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="serialNumber" name="serialNumber" value="<?php echo $serialNumber; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="notes" name="notes" value="<?php echo $notes; ?>">
        </td>
    </tr>
  </table>

<br />
<!--  *************************************************************************************** -->
<!--  ****************************  Ct Non-Sense ******************************************** -->
<!--  *************************************************************************************** -->
      <div style="width:800px;" id="centered">
        <center>
      <table>
        <tr>
          <td colspan="2" style="text-align: center; color: #666A00;">Connecticut Specific Non-Sense</td>
        </tr>
          <td style="background-color: #6C7B7C; color: black;">
            <label for="general_description">General Description</label>
            <span class="error"> <?php echo $generalErr;?></span>
          </td> 
            <td style="background-color: #6C7B7C; color: black;"><label for="frame">Select Frame</label>
            <span class="error"> <?php echo $frameErr;?></span>
          </td>

          <tr>
            <td style="background-color: #6C7B7C; width: 200px;">
            <select class="form-control" id="general" name="general"  onchange="generalChange(this);">
            <?php foreach(fillListByValue('DESCRIPTION', true, $general) as $i => $item) { print $item; } ?>
            </select>
          </td> 
                    <td style="background-color: #6C7B7C; width: 200px;">
            <select class="form-control" id="frame" name="frame">
                <?php foreach(fillListByValue('FRAME', true, $frame) as $i => $item) { print $item; } ?>
            </select>
          </td>
          </tr>
      </table>
    <br>
<!--  *************************************************************************************** -->
<!--  ****************************  Images ************************************************** -->
<!--  *************************************************************************************** -->
    <table>
        <tr>
          <td colspan="2" style="text-align: center; color: #666A00;">Images</td>
        </tr>
        <tr>
          <td style="background-color: #6C7B7C; color: black;">
            <label for="general_description">Left</label>
            <span class="error"> <?php echo $leftImageErr;?></span>
          </td> 
          <td style="background-color: #6C7B7C; color: black;">
            <label for="frame">Right</label>
            <span class="error"> <?php echo $rightImageErr;?></span>
          </td>
        </tr>

          <tr>
            <td style="background-color: #6C7B7C; width: 200px;">
              <input type="file" accept="image/png, image/jpeg" class="form-control" id="leftImage" name="leftImage" value="<?php echo $leftImage; ?>">
          </td> 
          <td style="background-color: #6C7B7C; width: 200px;">
              <input type="file" accept="image/png, image/jpeg" class="form-control" id="rightImage" name="rightImage" value="<?php echo $rightImage; ?>">
          </td>
          </tr>
          <tr>
          <td style="background-color: #6C7B7C; color: black;">
            <label for="frame">Front</label>
            <span class="error"> <?php echo $frontImageErr;?></span>
          </td>
          <td style="background-color: #6C7B7C; color: black;">
            <label for="frame">Rear</label>
            <span class="error"> <?php echo $rearImageErr;?></span>
          </td>
        </tr>

        <tr>
          <td style="background-color: #6C7B7C; width: 200px;">
              <input type="file" accept="image/png, image/jpeg" class="form-control" id="frontImage" name="frontImage" value="<?php echo $frontImage; ?>">
          </td>
          <td style="background-color: #6C7B7C; width: 200px;">
              <input type="file" accept="image/png, image/jpeg" class="form-control" id="rearImage" name="rearImage" value="<?php echo $rearImage; ?>">
          </td>
          </tr>
      </table>
    <br />

<!--  *************************************************************************************** -->
<!--  ****************************  Save Button********************************************** -->
<!--  *************************************************************************************** -->
    <div class="button_cont" align="center">
      <a class="example_d" href="item_list.php" rel="nofollow noopener">Cancel</a>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a class="example_d" href="#" onclick="document.forms['frmItem'].submit(); return false;" rel="nofollow noopener">Save Item</a>
      <br /><br /><br /><br /><br />
      
      <a class="example_d" href="#" onclick="javascript:fillPage(); return false;" rel="nofollow noopener">Fill Page</a>
      <a class="example_d" href="#" onclick="javascript:emptyPage(); return false;" rel="nofollow noopener">Empty Page</a>
      <a class="example_d" href="#" onclick="javascript:zippy(); return false;" rel="nofollow noopener">Address</a>
    </div>
    </center>
  </div>  <!-- DIV CENTERED -->
</div>  <!-- DIV MAIN -->
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
</form>
</body>
<script type="text/javascript" src="./script/item_script.js"></script>  

</html> 
