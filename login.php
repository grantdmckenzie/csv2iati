<?php
	/*
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: login page
	*/
	session_start();
	if (session_is_registered('wbuser')) {
	  header("location: index.php");
	} 
	error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $wbuser = null;
	$error = "";
	if (!empty($_POST['username'])) {
		$username = addslashes($_POST['username']);
		$password = md5($_POST['password']);
		
		if (!isset($username) || !isset($password)) {
			header("location: login.php");
		} elseif (empty($username) || empty($password)) {
			header("location: login.php");
		} else{
			require "inc/dbase.inc";
			require "inc/user.inc";
			
			$sql="SELECT * FROM users WHERE username='$username' and password='$password'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			$count=pg_num_rows($result);

			if($count==1) {
				$wbuser = new WBUser($row);
				session_register("wbuser");
				$_SESSION['wbuser'] = serialize($wbuser);
				header("location: index.php");
			} else  {
				$error = "Incorrect username or password. Please try again.<br/>";
			}
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <title>CSV to IATI Converter</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <script type="text/javascript">
	function runScript(e) {
	    if (e.keyCode == 13) {
		document.getElementById('uxlogin').submit();
	    }
	}
  </script>
 </head>
 <body>
    <?php include_once('inc/header.inc'); ?>
    <div><?php echo $error; ?></div>
    <div id="login">
	<form method="POST" action="login.php" name="uxlogin" id="uxlogin">
		<table style="border:0">
		<tr><td style="border:0" colspan="2"><div style="font-size:1.6em;margin-bottom:15px;">SIGN IN</div></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Username:</td><td colspan="2" style="border:0"><input type="text" name="username" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Password:</td><td colspan="2" style="border:0"><input type="password" name="password" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;" onkeypress="return runScript(event)"></td></tr>
		<tr>
			<td style="border:0">&nbsp;</td>
			<td style="border:0">
				<button onclick="document.getElementById('uxlogin').submit();">Sign In ></button>
			</td>
			<td style="border:0">
				<div class="signup" onclick="window.location='register.php'">Don't have an account?<br/>Register here</div>
			</td>
		</tr>
		</table>
	</form>
    </div>
 </body>
</html> 