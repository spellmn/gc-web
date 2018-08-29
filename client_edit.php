<?php
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  include './option.php';
  include './routes/client_get.php';

  date_default_timezone_set('America/New_York');

	$errCount = $id = 0;

  $identity = $DBA = $firstName = $middleName = $lastName = $suffix = $street1 = $street2 = "";
  $identityErr = $DBAErr = $firstNameErr = $middleNameErr = $lastNameErr = $suffixErr = $street1Err = $street2Err =  "";

  $city = $state = $zip = $permitNumber = $DOB = $POB = $emailAddress = $website = $phoneNumber = "";
  $cityErr = $stateErr = $zipErr = $permitNumberErr = $DOBErr = $POBErr = $emailAddressErr = $websiteErr = $phoneNumberErr = "";

#//echo "<script>console.log( 'Debug Objects: A" .$_SERVER["REQUEST_METHOD"]   . "' );</script>";
  $action = "inserting a new client.";
  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['id']))  
  {
    $action = "updating an existing client.";
    $RET = getOneClient($_GET["id"], $db);
    $id  = test_input($RET["id"]);
    $DBA = test_input($RET["DBA"]);
    $firstName = test_input($RET["firstName"]);
    $middleName = test_input($RET["middleName"]);
    $lastName = test_input($RET["lastName"]);
    $suffix = test_input($RET["suffix"]);
    $street1 = test_input($RET["street1"]);
    $street2 = test_input($RET["street2"]);
    $city = test_input($RET["city"]);
    $state = test_input($RET["state"]);
    $zip = test_input($RET["zip"]);
    $permitNumber = test_input($RET["permitNumber"]);
    $DOB = test_input($RET["DOB"]);
    $POB = test_input($RET["POB"]);
    $emailAddress = test_input($RET["emailAddress"]);
    $website = test_input($RET["website"]);
    $phoneNumber = test_input($RET["phoneNumber"]);
    $identity = test_input($RET["identity"]);
    if ($identity == "1")
      $identity = "YES";
    else
      $identity = "NO";

    if ($DOB == '0000-00-00')
    {
      $DOB = "";
    }
    else
    {
      $date = new DateTime($DOB);
      $DOB = $date->format('m/d/Y'); // 31.07.2012
      //echo $date->format('d-m-Y'); // 31-07-2012
      }
  } 
  else if ($_SERVER["REQUEST_METHOD"] == "POST" )  
	{
    $DOB = null;
    try {
      // echo $POST["DOB"];
      $date = new DateTime($POST["DOB"]);
      $DOB = $date->format('m/d/Y'); // 31.07.2012
    } catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
    } 
    $DBA = test_input($_POST["DBA"]);
		$firstName = test_input($_POST["firstName"]);
		$middleName = test_input($_POST["middleName"]);
		$lastName = test_input($_POST["lastName"]);
		$suffix = test_input($_POST["suffix"]);
		$street1 = test_input($_POST["street1"]);
		$street2 = test_input($_POST["street2"]);
		$city = test_input($_POST["city"]);
    $state = test_input($_POST["state"]);
    $zip = test_input($_POST["zip"]);
    $permitNumber = test_input($_POST["permitNumber"]);
    $DOB = test_input($DOB);
    $POB = test_input($_POST["POB"]);
    $emailAddress = test_input($_POST["emailAddress"]);
    $website = test_input($_POST["website"]);
    $phoneNumber = test_input($_POST["phoneNumber"]);
    $identity = test_input($_POST["identity"]);
    foreach($_POST as $key => $value)
    {
      echo $key."=".$value."<br />";
    }

    if (empty($DBA) && (empty($firstName) || empty($lastName)) )
    {
      $firstNameErr = "First and Last Name are Required.";
      $lastNameErr = "First and Last Name are Required.";
      $errCount++;
    }

    if (empty($DBA) && (empty($firstName) && empty($lastName)) )
    {
      $firstNameErr = "First and Last Name or DBA is Required.";
      $lastNameErr = "First and Last Name or DBA is Required.";
      $DBAErr = "First and Last Name or DBA is Required.";
      $errCount++;
    }


    if (empty($street1))
    {
      $street1Err = "Street 1 is Required.";
      $errCount++;
    }

  	if (empty($city))
  	{
  		$cityErr = "City is Required.";
  		$errCount++;
  	}

  	if (empty($state))
  	{
  		$stateErr = "State is Required.";
  		$errCount++;
  	}

  	if (empty($zip))
  	{
  		$zipErr = "Zip Code is Required.";
  		$errCount++;
  	}

    if (empty($permitNumber))
    {
      $permitNumberErr = "Permit Number is Required.";
      $errCount++;
    }

    if (empty($DBA) && empty($DOB))
    {
      $DOBErr = "Date of Birth is Required.";
      $errCount++;
    }

// TODO:  HERE, check more fields for errors

  	if ($errCount != 0)
  	{
  	//echo $errCount . " Errors";
  	} else {
  		$_SESSION = $_POST;
      // $_SESSION["leftImage"] = $_FILES['leftImage']['name'];
  		header('location:./routes/client_post.php');
  		echo "<a href='client_list.php'>BACK</a>";
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

<div id="main" style="width: 800px">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" id="frmClient"  name="frmClient">
    <!--  *************************************************************************************** -->
    <!--  ****************************  Main Table ********************************************** -->
    <!--  *************************************************************************************** -->
    <div style="width: 800px; text-align: center; font-weight: bold;">You are currently <?php echo $action ?></div>
  <table width="800px">
    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;" colspan="4">
        <label for="DBA">Business Name</label>
        <span class="error"> <?php echo $DBAErr;?></span>
      </td>
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;" colspan="4">
        <input type="text" class="form-control" id="DBA" name="DBA" value="<?php echo $DBA; ?>" size="100">
      </td>
    </tr>

    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;">
        <label for="firstName">First Name</label>
        <span class="error"> <?php echo $firstNameErr;?></span>
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <label for="middleName">Middle Name</label>
        <span class="error"> <?php echo $middleNameErr;?></span>
      </td> 
      <td style="background-color: #6C7B7C; color: black;">
        <label for="lastName">Last Name</label>
        <span class="error"> <?php echo $lastNameErr;?></span>
      </td> 
      <td style="background-color: #6C7B7C; color: black;">
        <label for="suffix">Suffix</label>
        <span class="error"> <?php echo $suffixErr;?></span>
      </td> 
    </tr>

    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo $middleName; ?>">
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <select class="form-control" id="suffix" name="suffix">
        <?php foreach(fillListByValue('SUFFIX', true, $suffix) as $i => $suffixRow) { print $suffixRow; } ?>
        </select>
      </td>
    </tr>
    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;" colspan = 4>
        <label for="street3">Free Form Address</label>
      </td> 
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;" colspan=3>
        <input type="text" class="form-control" id="street3" name="street3" value="" size=100>
      </td>
      <td>
        <input type="button" value="Verify Address" onclick="validateAddress();" >
      </td>
    </tr>
    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;" colspan=2>
        <label for="stree1">Street 1</label>
        <span class="error"> <?php echo $street1Err;?></span>
      </td> 
      <td style="background-color: #6C7B7C; color: black;" colspan=2>
        <label for="street2">Street 2</label>
        <span class="error"> <?php echo $street2Err;?></span>
      </td> 
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;" colspan=2>
        <input type="text" class="form-control" id="street1" name="street1" size="50" value="<?php echo $street1; ?>">
      </td>
       <td style="background-color: #6C7B7C; color: black;" colspan=2>
        <input type="text" class="form-control" id="street2" name="street2" size="50" value="<?php echo $street2; ?>">
      </td>
    </tr>

    <tr class="title">
      <td style="background-color: #6C7B7C; color: black;">
        <label for="city">City</label>
        <span class="error"> <?php echo $cityErr;?></span>
      </td>

      <td style="background-color: #6C7B7C; color: black;"> 
        <label for="state">State </label> 
        <span class="error"> <?php echo $stateErr;?></span>
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <label for="zip">Zip</label>
        <span class="error"> <?php echo $zipErr;?></span>
      </td>
    </tr>
    <tr class="title-form">
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
      </td>
      <td style="background-color: #6C7B7C; color: black;">
        <select class="form-control" id="state" name="state">
          <?php foreach(fillListByValue('STATE', true, $state) as $i => $client) { print $client; } ?>
        </select>
      </td> 
      <td style="background-color: #6C7B7C; color: black;">
        <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $zip; ?>">
      </td>
    </tr>
    <tr class="title">
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="permitNumber">Permit Number</label>
          <span class="error"> <?php echo $permitNumberErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="DOB">Date of Birth</label>
          <span class="error"> <?php echo $DOBErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="POB">Place of Birth</label>
          <span class="error"> <?php echo $POBErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="POB">Identity</label>
          <span class="error"> <?php echo $identityErr;?></span>
        </td> 
      </tr>
      <tr class="title-form">
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="permitNumber" name="permitNumber" value="<?php echo $permitNumber; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="DOB" name="DOB" value="<?php echo $DOB; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="POB" name="POB" value="<?php echo $POB; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <select class="form-control" id="identity" name="identity">
            <?php foreach(fillListByValue('YESNO', true, $identity) as $i => $client) { print $client; } ?>
          </select>
        </td>
    </tr>

      <tr class="title">
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="phoneNumber">Phone Number</label>
          <span class="error"> <?php echo $phoneNumberErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="emailAddress">Email Address</label>
          <span class="error"> <?php echo $emailAddressErr;?></span>
        </td> 
        <td style="background-color: #6C7B7C; color: black;" >
          <label for="website">Website</label>
          <span class="error"> <?php echo $websiteErr;?></span>
        </td> 
      </tr>
      <tr class="title-form">
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="emailAddress" name="emailAddress" value="<?php echo $emailAddress; ?>">
        </td>
        <td style="background-color: #6C7B7C; color: black;" >
          <input type="text" class="form-control" id="website" name="website" value="<?php echo $website; ?>">
        </td>
      </tr>
  </table>

<br />



<!--  *************************************************************************************** -->
<!--  ****************************  Save Button********************************************** -->
<!--  *************************************************************************************** -->
    <div class="button_cont" align="center">
      <a class="example_d" href="client_list.php" rel="nofollow noopener">Cancel</a>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a class="example_d" href="#" onclick="document.forms['frmClient'].submit(); return false;" rel="nofollow noopener">Save Client</a>
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
<script type="text/javascript" src="./script/client_script.js"></script>  

</html> 
