<?php

  /*
	@author: Grant McKenzie (gmckenzie@spatialdev.com)
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: Export to IATI Script 
	This file requires: 
	    - Stringified JSON mapping object (between CSV column headers and IATI elements
	    - Serialized PHP Organization object (includes Org name, reference, etc)
	    - Path to CSV file uploaded to the server (on the previous index.php page)
  */
  session_start();
  if (!session_is_registered('wbuser')) {
    header("location: login.php");
  }
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  if (isset($_GET['id'])) {
    $id = pg_escape_string($_GET['id']);
    require_once('inc/class.inc');
    require "inc/user.inc";
    $wbuser = unserialize($_SESSION['wbuser']);
    
    date_default_timezone_set('UTC');
    $d = date("Y-m-d\TH:i:s");
    $data = fromDB($id, $wbuser->id);
    

    // Get the CSV filename, open it and parse it in to a CSV object.
    $csv = parseCSV($data['filename']);
    
    // Construct the base XML element and add required attributes
    $xml = simplexml_load_string('<iati-activities></iati-activities>');
    
    // $xml = new SimpleXMLElement('<iati-activities/>');
    
    // $xml->addAttribute('encoding','UTF-8');
    // $xml->addAttribute('version', '1.0');
    $xml->addAttribute('generated-datetime', $d);
    

    foreach($csv->data as $key=>$row) {

	// Activity is a required subchild of the Activities element.  There is one activity for each row in the CSV file
	$activity = $xml->addChild('iati-activity');
	$activity->addAttribute('default-currency',$data['org']['orgcurrency']);

	$activity->addAttribute('xml:xml:lang',$data['org']['orglanguage']);
	$activity->addAttribute('last-updated-datetime',$d);
	
	
	// All activities require a reporting agency as well.
	$reportingorg = $activity->addChild('reporting-org',$data['org']['orgname']);
	$reportingorg->addAttribute('ref',$data['org']['orgref']);
	$reportingorg->addAttribute('type',$data['org']['orgtype']);
	
	// Add the additional elements based on the CSV and provided mapping file.
	mapFields($key, $row);
    }

    Header('Content-type: text/xml; charset=utf-8');
    $outputXML = str_replace('<?xml version="1.0"?>', '<?xml version="1.0" encoding="UTF-8"?>', $xml->asXML());
    echo $outputXML;


   } else {
      echo "No IATI object provided.";
   } 
   
   // Function to parse the CSV file and store as CSV object
   function parseCSV($file) {
    require_once('inc/parsecsv.inc');
    $csv = new parseCSV();
    
    $csv->auto($file);
    return $csv;
  }
  
  function mapFields($csvkey, $row) {
    global $data, $activity;
    foreach($data['map'] as $key=>$val) {
      $subkey = explode(".",$key);
      
      // Special Case for complex (nested) xml fields.  Currently these include Budget, Transation and Location.  Could potentially add Result in the future. 
      if ($subkey[0] == "budget" || $subkey[0] == "transaction" || $subkey[0] == "location" ) {
      
	  // Add the base name of the element (no possability for text value here)
	  $prop = $activity->addChild($subkey[0]);
	  foreach($val as $propkey=>$propval) {
	    // Add properties to the base element.
	    if ($propkey == "type" && $propval != "None") {
	      $prop = checkManualEntryAtt($row,$propval,$prop, $propkey);
	    } else {
	      if (is_object($propval)) {
		// Create subelement and add text value
		if (property_exists($propval,"text")) {
		  if ($propval->text != "None") {
		    $subelement = checkManualEntry($prop, $row, $propval->text, $propkey);
		  }
		// Create subelement with no text value
		} else {
		  $subelement = $prop->addChild($propkey);
		}
		// Add properties to the subelement.
		foreach($propval as $subpropkey=>$subpropval) {
		  if ($subpropkey != "text" && $subpropval != "None") {
		    $subelement = checkManualEntryAtt($row,$subpropval,$subelement, $subpropkey);
		  }
		}
		
	      } 
	    }
	  }
      // Not complex (nested) XML Structures
      } else {
	// Check to see if there is a "text" property
	if (property_exists($val,"text")) {

	   // If there is one and it has been assigned a value create the element with a value
	  if($val->text != "None") {
	    $prop = checkManualEntry($activity, $row, $val->text, $subkey[0]);
	    
	  }
	} else {
	
	  // If there is no text value, just create an element with no assigned value
	  $prop = $activity->addChild($subkey[0]);
	}
	if($val->text != "None") {
	  
	  // Add attributes to the xml element
	  foreach($val as $propkey=>$propval) {
	      if ($propkey != "text" && $propval != "None") {
		if (!is_object($propval)) {
		  $prop = checkManualEntryAtt($row, $propval, $prop, $propkey);
		}
	      }
	  }
	}
      }
    }
  }
 
  // Check that the array properties exist before adding a new element.
  function checkManualEntry($parent,$row,$val,$key) {
    global $data;
    if(strlen($val) > 0) {
      if(array_key_exists($val, $row)) {
	// echo check_utf8($row[$val]) . "\t". $row[$val] . "\n";
	 if ($key == "iati-identifier") {
	    $row[$val] = $data['org']['orgref'] . "-" . $row[$val];
	  }
	$prop = $parent->addChild($key, encodeStuff($row[$val]));
      } else {
	$prop = $parent->addChild($key, encodeStuff($val));
      }
    return $prop;
    }
  }
  
  // Check that the array properties exist before adding a new property to an element.
  function checkManualEntryAtt($row,$propval,$prop, $propkey) {
    if(strlen($propval) > 0) {
      if(array_key_exists($propval, $row))
	$prop->addAttribute($propkey, encodeStuff($row[$propval]));
      else
	$prop->addAttribute($propkey, encodeStuff($propval));
      return $prop;
    }
  }
  
  function check_utf8($str) { 
    $len = strlen($str); 
    for($i = 0; $i < $len; $i++){ 
        $c = ord($str[$i]); 
        if ($c > 128) { 
            if (($c > 247)) return false; 
            elseif ($c > 239) $bytes = 4; 
            elseif ($c > 223) $bytes = 3; 
            elseif ($c > 191) $bytes = 2; 
            else return false; 
            if (($i + $bytes) > $len) return false; 
            while ($bytes > 1) { 
                $i++; 
                $b = ord($str[$i]); 
                if ($b < 128 || $b > 191) return false; 
                $bytes--; 
            } 
        } 
    } 
    return true; 
  } // end of check_utf8
  
  function fromDB($id, $userid){
    require_once('inc/dbase.inc');
    
    $sql="SELECT * FROM models WHERE id=".$id." AND userid = ".$userid;

    $result=pg_query($sql);
    $count=pg_num_rows($result);
    if ($count > 0) {
      $data = array();
      while ($row = pg_fetch_array($result)) {
	$data['filename'] = $row['filename'];
	$data['org'] = unserialize($row['orgdata']);
	$data['map'] = json_decode(urldecode($row['map']));
      }
      return $data;
    }
  }
  
  function encodeStuff($val) {
    // $val = html_entity_decode($val, ENT_NOQUOTES, 'UTF-8');
    // echo $val . "<br/>";
    $val = utf8_encode(htmlspecialchars($val));
    return $val;
  }
?>