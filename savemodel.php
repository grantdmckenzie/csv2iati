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
    $sql="SELECT * FROM models WHERE username='".$wbuser->username."' and modelname='".$_POST['modelname']."'";
    $result=pg_query($sql);
    $count=pg_num_rows($result);
    $vars = array('map'=>$_POST['map'],'filename'=>addslashes($_POST['filename']),'modelname'=>addslashes($_POST['modelname']),'username'=>$wbuser->username,'updatets'=>'NOW()');
    if ($count == 0) { 
      $result=pg_insert($db, 'models', $vars);
      if ($result) {
	echo "TRUE";
      } else {
	echo "Error";
      }
    } else if ($count > 0 && $_POST['modelname'] == $_POST['previousname'])  {
	$condition = array('modelname' => addslashes($_POST['modelname']), 'username' => $wbuser->username);
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

