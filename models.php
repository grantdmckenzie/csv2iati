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
  <script src="js/jquery.min.js"></script>
  <script src="js/models.js"></script>
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
   
?>
 </head>
 <body>
  
    <?php include_once('inc/header.inc'); ?>
    <div id="frontform">
    <div class="firstGroups">
<?php
  require "inc/dbase.inc";
  
  $sql="SELECT id, modelname, filename FROM models WHERE userid='".$wbuser->id."'";
  $result=pg_query($sql);
  $count=pg_num_rows($result);
  
  if ($count > 0 ) {
    echo "<b>Your saved Models</b><br/><br/>";
    $count = 1;
    while ($row = pg_fetch_array($result)) {
      echo "<div style='width:300px;float:left'>".$count . ". <a style='color:#333333' href='edit.php?id=".$row['id']."'>".urldecode($row['modelname'])."</a></div>";
      echo "<div style='float:left;width:100px;'><a style='color:#333333' href='".$row['filename']."' target='_blank'>CSV</a></div>";
      echo "<div class='removeModel' title='Delete Model from database' onclick='removeModel(".$row['id'].");'>x</div>";
      $count++;
    }
  }
?>
  
    </div>
  </div>
</body>
</html>