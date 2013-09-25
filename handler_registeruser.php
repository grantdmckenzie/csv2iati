<?php
  require "inc/dbase.inc";
  
  if (isset($_POST['username'])) { 
    $sql="SELECT * FROM users WHERE username='".pg_escape_string($_POST['username'])."'";
    $result=pg_query($sql);
    $count=pg_num_rows($result);

    if ($count == 0) { 
      $_POST['password'] = md5($_POST['password']);
      $result=pg_insert($db, 'users', $_POST);
      if ($result) {
	echo "TRUE";
      } else {
	echo "Sorry, there was an error completing your request";
      }
    } else {
      echo "Sorry, this email address is already registered";
    }
  } else {
      echo "No parameters sent";
  }

?>