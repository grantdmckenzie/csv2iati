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

  if (isset($_POST['map']) && isset($_POST['filename']) && isset($_POST['modelname'])) { 
    $sql="SELECT * FROM models WHERE username='".$wbuser->username."' and modelname='".$_POST['modelname']."'";
    $result=pg_query($sql);
    $count=pg_num_rows($result);
    if ($count == 0) { 
      $_POST['username'] = $wbuser->username;
      $result=pg_insert($db, 'models', $_POST);
      if ($result) {
	echo "TRUE";
      } else {
	echo "Error";
      }
    } else {
      echo "A model already exists with the name ".$_POST['modelname'];
    }
  } else {
    echo "No parameters";
  }

?>

