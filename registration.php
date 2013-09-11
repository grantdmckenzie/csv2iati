<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <!--
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: Registration page
  -->
 
 <head> 
  <title>CSV to IATI Conversion Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="css/main.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/jquery.css" />
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.js"></script>
  <script type="text/javascript" src="js/registration"></script>
  <script type="text/javascript" src="js/loadiati.js"></script>
 </head>
 <body>
  <?php include_once('inc/header.inc'); ?>
    <div id="registerNotification"></div>
    <div id="register">
		<table class="wrapperLogin" style="top:80px">
		<tr><td style="border:0" colspan="2"><div style="font-size:1.6em;margin-bottom:15px;">REGISTRATION</div></td></tr>
		<tr><td></td><td style='color:#ff0000' id="error"></td></tr>
		<tr><td class='lbl'>First Name*</td><td><input type="text" name="first" value="First"></td></tr>
		<tr><td class='lbl'>Last Name*</td><td><input type="text" name="last" value="Last"></td></tr>
		<tr><td class='lbl'>Email*</td><td><input type="text" name="username" value="email@spatialdev.com"></td></tr>
		<tr><td class='lbl'>Password*</td><td><input type="password" name="password" value=""></td></tr>
		<tr><td style="padding-top:10px;">&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='lbl'>Organization Name*</td><td><input type="text" id="orgname" name="organization" value=""></td></tr>
		<tr><td class='lbl'>Organization Reference*</td><td><input type="text" id="orgref" name="reference" value=""></td></tr>
		<tr><td class='lbl'>Organization Type*</td><td><input type="text" name="orgtype" value="21"></td></tr>
		<tr><td class='lbl'>Default Currency</td><td><input type="text" name="currency" value="USD"></td></tr>
		<tr><td class='lbl'>Default Language</td><td><input type="text" name="language" value="en"></td></tr>
		<tr><td class='lbl'>Telephone Number</td><td><input type="text" name="phone"></td></tr>
		<tr><td class='lbl'>Mailing Address</td><td><input type="text" name="address"></td></tr>
		<tr><td></td><td>* Required for Registration</td></tr>
		<tr>
			<td style="padding-top:10px">&nbsp;</td>
			<td style="padding-top:10px">
				<div class="bigbutton" title="Register" onclick="validate();">Register</div>
			</td>
			<td style="border:0"></td>
		</tr>
		</table>
    </div>
    
 </body>
</html>