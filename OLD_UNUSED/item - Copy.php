<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        include './option.php';

	$errCount = 0;
	$manufacturer    = $model    = $serialNumber    = $caliber    = $barrel =    $frame    = $general    = ""; 
        $manufacturerErr = $modelErr = $serialNumberErr = $caliberErr = $barrelErr = $frameErr = $generalErr = "";

#//echo "<script>console.log( 'Debug Objects: A" .$_SERVER["REQUEST_METHOD"]   . "' );</script>";

        if ($_SERVER["REQUEST_METHOD"] == "POST" )  
	{
		$manufacturer = test_input($_POST["manufacturer"]);
		$model = test_input($_POST["model"]);
		$serialNumber = test_input($_POST["serialNumber"]);
		$caliber = test_input($_POST["caliber"]);
		$barrel = test_input($_POST["barrel"]);
		$general = test_input($_POST["general"]);
		$frame = test_input($_POST["frame"]);


        foreach($_POST as $key => $value)
        {
          echo $key."=".$value."<br />";
        }

	if (empty($serialNumber))
	{
		$serialNumberErr = "<br>Serial Number is Required.";
		$errCount++;
	}

	if (empty($model))
	{
		$modelErr = "<br>Model is Required.";
		$errCount++;
	}

	if (empty($manufacturer))
	{
		$manufacturerErr = "<br>Manufacturer is Required.";
		$errCount++;
	}

	if (empty($caliber))
	{
		$caliberErr = "<br>Caliber is Required.";
		$errCount++;
	}

	if (empty($barrel))
	{
		$barrelErr = "<br>Barrel is Required.";
		$errCount++;
	}

	if (empty($frame))
	{
		$frameErr = "<br>Frame is Required.";
		$errCount++;
	}

	if (empty($general))
	{
		$generalErr = "<br>General is Required.";
		$errCount++;
	}

	if ($errCount != 0)
	{
	//echo $errCount . " Errors";
	} else {
		$_SESSION = $_POST;
		//$_SESSION["fileName"] = $_FILES['fileToUpload']['name'];
		//header('location:./routes/dps3c_post.php');

		echo "<a href='item.php'>BACK</a>";
		exit();
	}
    }

function test_input($data) {
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
</head>
</head>
<body>


<div id="mySidenav" class="sidenav">
  <a href="#" id="burger"><img src='img/burger.png' style='height: 28px; width: 28px;' onclick="flipNav()"></a>
  <a href="#" id="xact"><div style='height: 34px;'><span><img src='img/xact.png' style='height: 28px; width: 28px;'></span></div></a>
  <a href="#" id="client"><div style='height: 34px;'><span><img src='img/client.png' style='height: 28px; width: 28px;'></span></div></a>
  <a href="#" id="item"><div style='height: 34px;'><span><img src='img/item.png' style='height: 28px; width: 28px;'></span></div></a>
  <a href="#" id="settings"><div style='height: 34px;'><span><img src='img/settings.png' style='height: 28px; width: 28px;'></span></div></a>
  <a href="#" id="reports"><div style='height: 34px;'><span><img src='img/reports.png' style='height: 28px; width: 28px;'></span></div></a>
</div>

<div id="main">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" id="frmItem"  name="frmItem">
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
          
          <td style="background-color: #6C7B7C; color: black;"><input type="text" class="form-control" id="barrel" name="barrel" value="<?php echo $barrel; ?>"></td>
        </tr>
        <tr>
            <td style="background-color: #6C7B7C; color: black;" >
              <label for="serialNumber">Serial Number</label>
              <span class="error"> <?php echo $serialNumberErr;?></span>
            </td> 
          </tr>
          <tr>
            <td style="background-color: #6C7B7C; color: black;" >
              <input type="text" class="form-control" id="serialNumber" name="serialNumber" value="<?php echo $serialNumber; ?>">
            </td>
        </tr>
      </table>

<br />
      <div style="width:800px;"><center>
      <table>
        <tr>
          <td colspan="2" style="text-align: center; color: #666A00;">Connecticut Specific Non-Sense</td>
        </tr>
          <td style="background-color: #6C7B7C; color: black;">
            <label for="general_description">General Description</label>
            <span class="error"> <?php echo $generalErr;?></span>
          </td> 
                    <td style="background-color: #6C7B7C; color: black;"><label for="frame">Select Type</label>
            <span class="error"> <?php echo $frameErr;?></span>
          </td>

          <tr>
            <td style="background-color: #6C7B7C; width: 200px;">
            <select class="form-control" id="general" name="general">
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
    </center><br>
    <button type="button" id="add_fields" onclick="addFields('frmItem');">Add more fields</button>
<div style="width: 800px;"><center>
  <div class="button_cont" align="center"><a class="example_d" href="#" onclick="document.forms['frmItem'].submit(); return false;" rel="nofollow noopener">Save Item</a></div>
</center>
</div>
    
  </div>
</div>

<script>
function fillPage() 
{

				document.getElementById("manufacturer").selectedIndex = 117;
				document.getElementById("model").value = 'Legion 226';
				document.getElementById("serialNumber").value = 'SIG12345';
				document.getElementById("caliber").selectedIndex = 4;
				document.getElementById("general").selectedIndex = 1;
				document.getElementById("barrel").value = 4.8;
				document.getElementById("frame").selectedIndex = 1;
}
fillPage();	


  function flipNav()
  {
  	//alert(document.getElementById("mySidenav").style.width);
  	if (document.getElementById("mySidenav").style.width == "200px")
  	{
		  document.getElementById("mySidenav").style.width = "50px";
	    document.getElementById("main").style.marginLeft= "30px";
	    document.body.style.backgroundColor = "white";
	    document.getElementById('xact').innerHTML = "<div style='height: 34px;'><span><img src='img/xact.png' style='height: 28px; width: 28px;'></span></div>";
	    document.getElementById('client').innerHTML = "<div style='height: 34px;'><span><img src='img/client.png' style='height: 28px; width: 28px;'></span></div>";
	    document.getElementById('item').innerHTML = "<div style='height: 34px;'><span><img src='img/item.png' style='height: 28px; width: 28px;'></span></div>";
	    document.getElementById('settings').innerHTML = "<div style='height: 34px;'><span><img src='img/settings.png' style='height: 28px; width: 28px;'></span></div>";
	    document.getElementById('reports').innerHTML = "<div style='height: 34px;'><span><img src='img/reports.png' style='height: 28px; width: 28px;'></span></div>";
  	}
  	else
  	{
  		document.getElementById("mySidenav").style.width = "200px";
    	document.getElementById("main").style.marginLeft = "180px";
   	 	document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    	document.getElementById('xact').innerHTML = "<div style='height: 34px;'><span><img src='img/xact.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Transaction</span></div>";
    	document.getElementById('client').innerHTML = "<div style='height: 34px;'><span><img src='img/client.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Client</span></div>";
    	document.getElementById('item').innerHTML = "<div style='height: 34px;'><span><img src='img/item.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Item</span></div>";
    	document.getElementById('settings').innerHTML = "<div style='height: 34px;'><span><img src='img/settings.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Settings</span></div>";
    	document.getElementById('reports').innerHTML = "<div style='height: 34px;'><span><img src='img/reports.png' style='height: 28px; width: 28px;'></span><span>  &nbsp;Reports</span></div>";
  	}
  }
  var new_fields_counter = 0;
  function addFields(formID){
    new_fields_counter++;
    var new_file = document.createElement("input");
    new_file.setAttribute("type", "file");
    new_file.setAttribute("name", "new_file_" + new_fields_counter);
    document.getElementById(formID).appendChild(new_file);
    var new_select = document.createElement("select");
    new_select.setAttribute("name", "new_select_" + new_fields_counter);
    var new_option1 = document.createElement("option");
    new_option1.value = "JPG";
    new_option1.text = "JPG";
    var new_option2 = document.createElement("option");
    new_option2.value = "PNG";
    new_option2.text = "PNG";
    var new_option3 = document.createElement("option");
    new_option3.value = "GIF";
    new_option3.text = "GIF";
    new_select.add(new_option1);
    new_select.add(new_option2);
    new_select.add(new_option3);
    document.getElementById(formID).appendChild(new_select);
    var new_br = document.createElement("br");
    document.getElementById(formID).appendChild(new_br);
  }

</script>
     </form>
</body>
</html> 
