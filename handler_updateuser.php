<?php
  session_start();
  if (!session_is_registered('wbuser')) {
    header("location: login.php");
  }
  // Error Reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  require "inc/user.inc";
  require "inc/dbase.inc";
  $wbuser = unserialize($_SESSION['wbuser']);
  
  if (isset($_POST['username'])) { 
 
      $_POST['password'] = md5($_POST['password']);
      $condition = array('id' => $wbuser->id);
      $res = pg_update($db, 'users', $_POST, $condition);
      if ($res) {
	echo "TRUE";
	$_POST['id'] = $wbuser->id;
	$wbuser = new WBUser($_POST);
	$_SESSION['wbuser'] = serialize($wbuser);
      } else {
	echo "Sorry, there was an error completing your request";
      }
  } else {
      echo "No parameters sent";
  }

?>