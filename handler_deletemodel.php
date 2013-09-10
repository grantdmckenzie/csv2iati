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

  if (isset($_POST['id'])) { 
    $sql="DELETE FROM models WHERE userid='".$wbuser->id."' and id='".$_POST['id']."'";
    $result=pg_query($sql);
    echo "TRUE";
  } else {
    echo "No parameters";
  }

?>

