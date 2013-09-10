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

  if (isset($_POST['map']) && isset($_POST['filename']) && isset($_POST['modelname']) && isset($_POST['previousname'])) { 
    $sql="SELECT * FROM models WHERE userid='".$wbuser->id."' and modelname='".$_POST['modelname']."'";
    $result=pg_query($sql);
    $count=pg_num_rows($result);
    $vars = array('orgdata'=>$_POST['orgdata'], 'map'=>$_POST['map'],'filename'=>addslashes($_POST['filename']),'modelname'=>addslashes($_POST['modelname']),'userid'=>$wbuser->id,'updatets'=>'NOW()');
    if ($count == 0) { 
      $query = "INSERT INTO models (";
      foreach($vars as $key=>$val) {
	$query .= $key . ",";
      }
      $query = substr($query,0,-1);
      $query .= ") VALUES (";
      foreach($vars as $key=>$val) {
	$query .= "'".$val . "',";
      }
      $query = substr($query,0,-1);
      $query .= ") RETURNING id";
      
      $result=pg_query($query);
      
      if ($result) {
	$r = pg_fetch_array($result);
	if($r[0])
	  echo intVal($r[0]);
      } else {
	echo "Error";
      }
    } else if ($count > 0 && $_POST['modelname'] == $_POST['previousname'])  {
	$condition = array('modelname' => addslashes($_POST['modelname']), 'userid' => $wbuser->id);
	$res = pg_update($db, 'models', $vars, $condition);
	if ($res) {
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

