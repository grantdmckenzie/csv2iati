  <!--
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: Header File
  -->
<div id="header">
  <!-- <img src="img/iati-standard.png" style="float:left;margin-top:-3px;"/> -->
  <table style="float:left"><tr><td><h2>CSV 2 IATI</h2></td></tr>
  <tr><td class='subheader'>Converter Toolbox</td></tr></table>
  <?php 
    if ($wbuser && is_object($wbuser)) { 
  ?>
  <div id="menu">
    Welcome <?php echo $wbuser->first; ?> | 
    <a href="user.php">User Profile</a> | 
    <a href="index.php">New Model</a> | 
    <a href="models.php">Saved Models</a> | 
    <a href="logout.php">Logout</a>
  </div>
  
  <?php } ?>
</div>
