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
  // Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Load user object from session
  require "inc/user.inc";
  $wbuser = unserialize($_SESSION['wbuser']);

  // Check if this is a postback (look for the u param).
  if (isset($_GET['id'])) {
    require_once('inc/class.inc');
    require_once('inc/dbase.inc');
    
    $sql="SELECT * FROM models WHERE id=".$_GET['id'];

    $result=pg_query($sql);
    $count=pg_num_rows($result);
    if ($count > 0) {
      while ($row = pg_fetch_array($result)) {
	$filename = $row['filename'];
	$raworg = $row['orgdata'];
	$org = unserialize($row['orgdata']);
	echo "<script language='javascript'>\nvar map = ".urldecode($row['map'])."\n</script>";
	$modelname = $row['modelname'];
      }
?>

  <script src="js/jquery.min.js"></script>
  <script src="js/iati_template.js"></script>
  <script src="js/json.js"></script>
  <?php parseCSV($filename); ?>
  <script src="js/main.js"></script>
  <script src="js/edit.js"></script>
 </head>
 <body>
    <?php include_once('inc/header.inc'); ?>
    <div id="frontform">
    <div class="firstGroups">
      Model Name: <input type="text" id="modelname" value="<?php echo urldecode($modelname); ?>"/>
    </div>
    <div class="firstGroups">
    Select an IATI Field from the list below to view CSV mappping options:<br/>
    <select id="iati_fields"><option value="">Add new IATI field</select>
    </div>
    <div id="workspace"></div>
    <div class="firstGroups" style="border:0;background-color:#ffffff;">
    <div class="bigbutton" onclick="saveMapping();" id="saveModel" style="float:left" title="Save Model">Save Model</div>
    <input type='hidden' value='' name='map' id='map'/>
    <input type='hidden' value='<?php echo $filename; ?>' name='filename' id='filename'/>
    <input type='hidden' value='<?php echo $raworg; ?>' name='serializeorg' id='serializeorg'/>
    <form action='export.php' method='get' target='_blank'>
      <input type='hidden' value='<?php echo $_GET['id']; ?>' name='id' id='id'/>
      <input class="bigbutton" type='submit' value='Export as IATI' id="exportIATI" />
    </form>
    </div>
  </div>
<?php
  } else {
?>
   </head>
 <body>
  No model with the provided ID
<?php
  }}
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