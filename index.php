<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <!--
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: Primary index page
  -->
 
 <head> 
  <title>CSV to IATI Conversion Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="css/main.css" rel="stylesheet" type="text/css">
  
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.js"></script>
<?php
  session_start();
  if (!session_is_registered('wbuser')) {
    header("location: login.php");
  }
  
  // Load user object from session
  require "inc/user.inc";
  require "inc/languages.inc";

  $wbuser = unserialize($_SESSION['wbuser']);
  
  // Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  // Check if this is a postback (look for the u param).
  if (isset($_POST['u']) && $_POST['u'] == 1) {
  
    
    
    // Create an organization object from the post parameters
    require_once('inc/class.inc');
    $org = new org($_POST);
?>

  
  <script src="js/iati_template.js"></script>
  <script src="js/json.js"></script>
<?php
    $allowedExts = array("csv", "txt");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if (($_FILES["file"]["type"] != "text/csv") || ($_FILES["file"]["size"] > 15000000) || !in_array($extension, $allowedExts)) {
	  if ($_FILES["file"]["error"] > 0) {
	      header("location: index.php?e=8");
	  } else {
	      header("location: index.php?e=9");
	  }
    } else {
	if (strlen($_POST['orgname']) < 2)
	  header("location: index.php?e=1");
	  
	// Parse the CSV to get column headers (to load select)
	parseCSV($_FILES["file"]["tmp_name"]);
	// Move CSV to known directory for access later.  CSV labeled by date and a random integer.
	$filepath = "upload/" . date('U')."-".rand().".csv";
	move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
	// Serialize the POST params to send it to the export.php page
	$a = serialize($_POST);
	
?>
  <script src="js/main.js"></script>
 </head>
 <body>
  
    <?php include_once('inc/header.inc'); ?>
    <div id="frontform">
    <div class="firstGroups">
      <div class="label" style="width:100px">Model Name</div><input type="text" id="modelname"/>
    </div>
    <!-- <div class="firstGroups">
      Organization Name: <?php echo $org->orgname; ?><br/>
      Organization Reference: <?php echo $org->orgref; ?>
    </div> -->
    <div class="firstGroups">
      <div style="font-size:13px">Select an IATI Field from the drop-down menu to view CSV mappping options<br/><br/>
    <select id="iati_fields"><option value="">Add new IATI field</select></div>
    </div>
    <div id="workspace"></div>
    <div class="firstGroups" style="border:0;background-color:#ffffff;">
    <div class="bigbutton" onclick="saveMapping();" id="saveModel" style="float:left" title="Save Model">Save Model</div>
    <input type='hidden' value='' name='map' id='map'/>
    <input type='hidden' value='<?php echo $a; ?>' name='serializeorg' id="serializeorg"/>
    <input type='hidden' value='<?php echo $filepath; ?>' name='filename' id='filename'/>
    <form action='export.php' method='get' target='_blank'>
      <input type='hidden' value='' name='id' id='id'/>
      <input class="bigbutton" type='submit' value='Export as IATI' id="exportIATI" />
    </form>
    </div>
  </div>
<?php
    }
  } else {
    // If the is not a postback, load the following content:
?>
  <script src="js/loadiati.js"></script>
  <link rel="stylesheet" href="css/jquery.css" />
  </head>
    <body>
    <?php include_once('inc/header.inc'); ?>
     <div id="frontform">
      <div class="firstGroups" style="border:0;text-align:justify">
	Welcome to the <i>CSV 2 IATI</i> converter. To create a new IATI file (and mapping file), complete the information below.  By default these fields are populated by data from your <i>User Profile</i>.  Changing this information here will simply change it for the IATI file you are generating.
	<br/><br/>The only required information here are the fields in the first block and a CSV file (last block).
      </div>
      <?php if(isset($_GET['e'])) echo "<div class='error'>".errorCode($_GET['e'])."</div>"; ?>
      <form action="index.php" method="post" enctype="multipart/form-data">
       <div class="firstGroups">
	<div class="label">Organization Name:</div><div class="entry"><input type="text" id="orgname" name="orgname" value="<?php echo urldecode($wbuser->org); ?>" /></div>
	<div class="label">Organization Reference:</div><div class="entry"><input type="text" id="orgref" name="orgref" value="<?php echo urldecode($wbuser->ref); ?>" /></div>
	<div class="label">Organization Type:</div><div class="entry"><input type="text" style="width:306px" id="orgtypenames"/><input style="margin-left:4px;width:18px" type="text" id="orgtype" name="orgtype" value="<?php echo urldecode($wbuser->orgtype); ?>" /></div>
       </div>
       <div class="firstGroups">
	<div class="label">Currency:</div><div class="entry"><select name="orgcurrency"><?php printCurrency($wbuser->currency, $currency); ?></select></div><br/><br/>
	<div class="label">Language:</div><div class="entry"><select name="orglanguage"><?php printCurrency($wbuser->currency, $language); ?></select></div>
       </div>
       <div class="firstGroups">
	<div class="label">Contact Person:</div><div class="entry"><input type="text" name="orgcontact" value="<?php echo urldecode($wbuser->first) . " " . urldecode($wbuser->last); ?>" /></div>
	<div class="label">Contact Telephone:</div><div class="entry"><input type="text" name="orgphone" value="<?php echo urldecode($wbuser->phone); ?>"/></div>
	<div class="label">Email Address:</div><div class="entry"><input type="text" name="orgemail" value="<?php echo urldecode($wbuser->username); ?>" /></div>
	<div class="label">Address:</div><div class="entry"><input type="text" name="orgaddress" value="<?php echo urldecode($wbuser->address); ?>"/></div>
       </div>
       <div class="firstGroups">
	<div class="label">CSV File:</div>
	<div class="entry">
	<input type="file" name="file" id="file"></div>
	<input type="hidden" name="u" value="1"/>
	<input type="hidden" name="MAX_FILE_SIZE" value="15000000"/>
       </div>
	<div id="wrapperNext">
	<br/>
	<input class="bigbutton" type="submit" name="submit" value="Next"/>
	</div>
      </form>
     </div><div class="entry">
<?php 
  } // End final if else.


  // Extract column headers from uploaded CSV.  Print these headers as a JavaScript Array in the header of the php file.
  function parseCSV($file) {
    require_once('inc/parsecsv.inc');
    $csv = new parseCSV();
    $csv->auto($file);
    echo "\t<script language='javascript'>\n\tvar csvcolumns = new Array('None','Manual Entry',";
    for($i=0;$i<count($csv->titles);$i++) {
      echo "'".$csv->titles[$i]."'";
      if ($i<count($csv->titles)-1) {
	echo ",";
      }
    }
    echo ");\n\t</script>\n";
  }
  
  function errorCode($error) {
    if ($error == 4) {
      return "Please supply a comma delimited (CSV) file for upload;";
    } else if ($error == 1) {
      return "Please provide an Organization Name.";
    } else if ($error == 8) {
      return "There was an error parsing the CSV file.";
    } else if ($error == 9) {
      return "The CSV file does not match the required criteria (CSV and < 15M)";
    } else {
      return "";
    }
  }
  
  function printCurrency($c, $a) {
    foreach($a as $key=>$val) {
      if($key == urldecode($c))
	echo "<option value='".$key."' selected>".$val."</option>\n";
      else
	echo "<option value='".$key."'>".$val."</option>\n";
    }
  }
 

?>
</body>
</html>