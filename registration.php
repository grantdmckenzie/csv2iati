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
  <link href="css/main.css" rel="stylesheet" type="text/css">
   <script type="text/javascript">
	function runScript(e) {
	    if (e.keyCode == 13) {
		document.getElementById('uxreg').submit();
	    }
	}
  </script>
 </head>
 <body>
  <?php include_once('inc/header.inc'); ?>
    <div id="register">
	<form method="POST" action="registration.php" name="uxreg" id="uxreg">
		<table style="border:0">
		<tr><td style="border:0" colspan="2"><div style="font-size:1.6em;margin-bottom:15px;">REGISTRATION</div></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Username:</td><td colspan="2" style="border:0"><input type="text" name="username" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">First Name:</td><td colspan="2" style="border:0"><input type="text" name="first" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;" onkeypress="return runScript(event)"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Last Name:</td><td colspan="2" style="border:0"><input type="text" name="last" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Password:</td><td colspan="2" style="border:0"><input type="password" name="password" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;" onkeypress="return runScript(event)"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Username:</td><td colspan="2" style="border:0"><input type="text" name="username" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;"></td></tr>
		<tr><td style="border:0" style="padding-bottom:15px;">Password:</td><td colspan="2" style="border:0"><input type="password" name="password" class="txtbox" style="margin-left:20px;font-size:0.9em;width:350px;margin-bottom:15px;" onkeypress="return runScript(event)"></td></tr>
		<tr>
			<td style="border:0">&nbsp;</td>
			<td style="border:0">
				<button onclick="document.getElementById('uxreg').submit();">Register ></button>
			</td>
			<td style="border:0"></td>
		</tr>
		</table>
	</form>
    </div>
 </body>
</html>