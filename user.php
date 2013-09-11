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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <!--
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: Update User page
  -->
 
 <head> 
  <title>CSV to IATI Conversion Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.js"></script>
  <script type="text/javascript" src="js/user"></script>
  <script type="text/javascript" src="js/loadiati.js"></script>
  <link rel="stylesheet" href="css/jquery.css" />
 </head>
 <body>
  <?php include_once('inc/header.inc'); ?>
    <div id="registerNotification"></div>
    <div id="register">
		<table class="wrapperLogin" style="top:80px">
		<tr><td style="border:0" colspan="2"><div style="font-size:1.6em;margin-bottom:15px;">USER PROFILE</div></td></tr>
		<tr><td></td><td style='color:#ff0000' id="error"></td></tr>
		<tr><td class='lbl'>First Name*</td><td><input type="text" name="first" value="<?php echo urldecode($wbuser->first); ?>"></td></tr>
		<tr><td class='lbl'>Last Name*</td><td><input type="text" name="last" value="<?php echo urldecode($wbuser->last); ?>"></td></tr>
		<tr><td class='lbl'>Email*</td><td><input type="text" name="username" value="<?php echo urldecode($wbuser->username); ?>"></td></tr>
		<tr><td class='lbl'>Password*</td><td><input type="password" name="password" value=""></td></tr>
		<tr><td style="padding-top:10px;">&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='lbl'>Organization Name*</td><td><input type="text" id="orgname" name="organization" value="<?php echo urldecode($wbuser->org); ?>"></td></tr>
		<tr><td class='lbl'>Organization Reference*</td><td><input type="text" id="orgref" name="reference" value="<?php echo urldecode($wbuser->ref); ?>"></td></tr>
		<tr><td class='lbl'>Organization Type*</td><td><input type="text" name="orgtype" value="<?php echo urldecode($wbuser->orgtype); ?>"></td></tr>
		<tr><td class='lbl'>Default Currency</td><td><input type="text" name="currency" value="<?php echo urldecode($wbuser->currency); ?>"></td></tr>
		<tr><td class='lbl'>Default Language</td><td><input type="text" name="language" value="<?php echo urldecode($wbuser->language); ?>"></td></tr>
		<tr><td class='lbl'>Telephone Number</td><td><input type="text" name="phone" value="<?php echo urldecode($wbuser->phone); ?>"></td></tr>
		<tr><td class='lbl'>Mailing Address</td><td><input type="text" name="address" value="<?php echo urldecode($wbuser->address); ?>"></td></tr>
		<tr><td></td><td>* Required</td></tr>
		<tr>
			<td style="padding-top:10px">&nbsp;</td>
			<td style="padding-top:10px">
				<div class="bigbutton" title="Register" onclick="validate();">Update</div>
			</td>
			<td style="border:0"></td>
		</tr>
		</table>
    </div>
    
 </body>
</html>