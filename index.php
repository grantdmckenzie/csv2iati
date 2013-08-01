<html>
 <head> 
  <title>CSV to IATI Converter</title>
  <link href="css/main.css" rel="stylesheet" type="text/css">
<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if (isset($_POST['u']) && $_POST['u'] == 1) {
    require_once('org.class');
    $org = new org($_POST);
?>


  <script src="js/jquery.min.js"></script>
  <script src="js/iati_template.js"></script>
  <script src="js/json.js"></script>
<?php
    if ($_FILES["file"]["error"] > 0) {
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else {
	// echo "File Name: " . $_FILES["file"]["name"] . "<br>";
	// echo "Type: " . $_FILES["file"]["type"] . "<br>";
	// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	parseCSV($_FILES["file"]["tmp_name"]);
	$filepath = "upload/" . date('U')."-".rand().".csv";
	move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);
	$a = serialize($_POST);
	// showIATIFields();
?>
  <script src="js/main.js"></script>
 </head>
 <body>
  Organization Name: <?php echo $org->orgname; ?><br/>
  Organization Reference: <?php echo $org->orgref; ?><hr/>
  Select an IATI Field from the list below to view CSV mappping options:<br/>
  <select id="iati_fields"><option value="">Add new IATI field</select>
  <hr/>
  <div id="workspace"></div>
  <hr/>
  Select "Save Model" before exporting.<br/>
  <button onclick="saveMapping();">Save Model</button>
  <form action='export.php' method='post' target='_blank'>
    <input type='hidden' value='' name='map' id='map'/>
    <input type='hidden' value='<?php echo $a; ?>' name='serializeorg'/>
    <input type='hidden' value='<?php echo $filepath; ?>' name='filename'/>
    <input type='submit' value='Export as IATI'/>
  </form>

<?php
  }
    // exportXML()
  } else {
  
?>
  </head>
    <body>
     <div id="frontform">
      <form action="index.php" method="post" enctype="multipart/form-data">
	<div class="label">Organization Name:</div><div class="entry"><input type="text" name="orgname"/></div>
	<div class="label">Organization Reference:</div><div class="entry"><input type="text" name="orgref"/></div>
	<div class="label">Organization Type:</div><div class="entry"><input type="text" name="orgtype"/></div>

	<div class="label">Currency:</div><div class="entry"><input type="text" name="orgcurrency"/></div>
	<div class="label">Language:</div><div class="entry"><input type="text" name="orglanguage"/></div>
	
	<div class="label">Contact Person:</div><div class="entry"><input type="text" name="orgcontact"/></div>
	<div class="label">Contact Telephone:</div><div class="entry"><input type="text" name="orgphone"/></div>
	<div class="label">Email Address:</div><div class="entry"><input type="text" name="orgemail"/></div>
	<div class="label">Address:</div><div class="entry"><input type="text" name="orgaddress"/></div>

	<div class="label">CSV File:</div><div class="entry">
	<input type="file" name="file" id="file"></div>
	<input type="hidden" name="u" value="1"/>

	<div style="float: left;clear: both">
	<br/>
	<input type="submit" name="submit" value="Next Step >">
	</div>
      </form>
     </div><div class="entry">
<?php } 


  function parseCSV($file) {
    require_once('parsecsv.lib.php');

    $csv = new parseCSV();

    $csv->auto($file);
    echo "<script language='javascript'>\nvar csvcolumns = new Array('None','Manual Entry',";
    for($i=0;$i<count($csv->titles);$i++) {
      echo "'".$csv->titles[$i]."'";
      if ($i<count($csv->titles)-1) {
	echo ",";
      }
    }
    echo ");\n</script>";
    // var_dump($csv->titles);
  }
 

?>
</body>
</html>