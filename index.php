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
  <link href="css/main.css" rel="stylesheet" type="text/css">
<?php
  session_start();
  if (!session_is_registered('wbuser')) {
    header("location: login.php");
  }
  
  // Load user object from session
  require "inc/user.inc";
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

  <script src="js/jquery.min.js"></script>
  <script src="js/iati_template.js"></script>
  <script src="js/json.js"></script>
<?php
    if ($_FILES["file"]["error"] > 0) {
	// echo "Error uploading file: " . $_FILES["file"]["error"] . "<br>";
	header("location: index.php?e=".$_FILES["file"]["error"]);
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
      Organization Name: <?php echo $org->orgname; ?><br/>
      Organization Reference: <?php echo $org->orgref; ?>
    </div>
    <div class="firstGroups">
    Select an IATI Field from the list below to view CSV mappping options:<br/>
    <select id="iati_fields"><option value="">Add new IATI field</select>
    </div>
    <div id="workspace"></div>
    <div class="firstGroups" style="border:0;background-color:#ffffff;">
    <div class="bigbutton" onclick="saveMapping();" id="saveModel" style="float:left" title="Save Model">Save Model</div>
    <form action='export.php' method='post' target='_blank'>
      <input type='hidden' value='' name='map' id='map'/>
      <input type='hidden' value='<?php echo $a; ?>' name='serializeorg'/>
      <input type='hidden' value='<?php echo $filepath; ?>' name='filename'/>
      <input class="bigbutton" type='submit' value='Export as IATI' id="exportIATI" />
    </form>
    </div>
  </div>
<?php
    }
  } else {
    // If the is not a postback, load the following content:
?>

  </head>
    <body>
    <?php include_once('inc/header.inc'); ?>
     <div id="frontform">
      <div class="firstGroups" style="border:0">
	Instructions here
      </div>
      <?php if(isset($_GET['e'])) echo "<div class='error'>".errorCode($_GET['e'])."</div>"; ?>
      <form action="index.php" method="post" enctype="multipart/form-data">
       <div class="firstGroups">
	<div class="label">Organization Name:</div><div class="entry"><input type="text" name="orgname" value="<?php echo $wbuser->org; ?>" /></div>
	<div class="label">Organization Reference:</div><div class="entry"><input type="text" name="orgref" value="<?php echo $wbuser->ref; ?>" /></div>
	<div class="label">Organization Type:</div><div class="entry"><input type="text" name="orgtype" value="<?php echo $wbuser->orgtype; ?>" /></div>
       </div>
       <div class="firstGroups">
	<div class="label">Currency:</div><div class="entry"><input type="text" name="orgcurrency"/></div>
	<div class="label">Language:</div><div class="entry"><input type="text" name="orglanguage"/></div>
       </div>
       <div class="firstGroups">
	<div class="label">Contact Person:</div><div class="entry"><input type="text" name="orgcontact" value="<?php echo $wbuser->first . " " . $wbuser->last; ?>" /></div>
	<div class="label">Contact Telephone:</div><div class="entry"><input type="text" name="orgphone"/></div>
	<div class="label">Email Address:</div><div class="entry"><input type="text" name="orgemail" value="<?php echo $wbuser->email; ?>" /></div>
	<div class="label">Address:</div><div class="entry"><input type="text" name="orgaddress"/></div>
       </div>
       <div class="firstGroups">
	<div class="label">CSV File:</div>
	<div class="entry">
	<input type="file" name="file" id="file"></div>
	<input type="hidden" name="u" value="1"/>
       </div>
	<div id="wrapperNext">
	<br/>
	<input class="bigbutton" type="submit" name="submit" value="Next Step >"/>
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
    } else {
      return "";
    }
  }
 

?>
</body>
</html>