<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  if (isset($_POST['map'])) {
    require_once('inc/class.inc');
    date_default_timezone_set('UTC');
    $d = date("Y-m-d\TH:i:s");
    $org = unserialize($_POST['serializeorg']);
 
    $map = json_decode(urldecode($_POST['map']));
    //var_dump($map);
    $csv = parseCSV($_POST['filename']);
    
    $xml = new SimpleXMLElement('<iati-activities/>');
    $xml->addAttribute('generated-datetime', $d);
    $xml->addAttribute('version', '1.0');
    // $xml->addAttribute('encoding', 'ISO-8859-2');
    $count = 0;
    foreach($csv->data as $key=>$row) {
	$count++;
	$activity = $xml->addChild('iati-activity');
	$activity->addAttribute('default-currency',$org['orgcurrency']);
	$activity->addAttribute('xml:lang',$org['orglanguage']);
	$reportingorg = $activity->addChild('reporting-org',$org['orgname']);
	$reportingorg->addAttribute('ref',$org['orgref']);
	$reportingorg->addAttribute('type',$org['orgtype']);
	mapFields($key, $row);
    }

   Header('Content-type: text/xml; charset=ISO-8859-2');
   print($xml->asXML());

   } else {
      echo "No IATI object provided.";
   } 
   
   
   function parseCSV($file) {
    require_once('inc/parsecsv.inc');

    $csv = new parseCSV();

    $csv->auto($file);
    
    return $csv;
  }
  
  function mapFields($csvkey, $row) {
    global $map, $activity;
    foreach($map as $key=>$val) {
      $subkey = explode(".",$key);
      
      // Special Case for  Budget 
      if ($subkey[0] == "budget" || $subkey[0] == "transaction" || $subkey[0] == "location" ) {
	  $prop = $activity->addChild($subkey[0]);
	  
	  foreach($val as $propkey=>$propval) {
	    if ($propkey == "type" && $propval != "None") {
	      $prop = checkManualEntryAtt($row,$propval,$prop, $propkey);
	    } else {
	      if (is_object($propval)) {
		if (property_exists($propval,"text")) {
		  if ($propval->text != "None") {
		    $subelement = checkManualEntry($prop, $row, $propval->text, $propkey);
		  }
		} else {
		  $subelement = $prop->addChild($propkey);
		}
		foreach($propval as $subpropkey=>$subpropval) {
		  if ($subpropkey != "text" && $subpropval != "None") {
		    $subelement = checkManualEntryAtt($row,$subpropval,$subelement, $subpropkey);
		  }
		}
		
	      } 
	    }
	  }
      // None Complex (nested) XML Structures
      } else {
	if (property_exists($val,"text")) {
	  if($val->text != "None")
	    $prop = checkManualEntry($activity, $row, $val->text, $subkey[0]);
	} else {
	  $prop = $activity->addChild($subkey[0]);
	}
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
 
  function checkManualEntry($parent,$row,$val,$key) {
    if(strlen($val) > 0) {
      if(array_key_exists($val, $row))
	$prop = $parent->addChild($key, utf8_decode(htmlspecialchars($row[$val])));
      else
	$prop = $parent->addChild($key, utf8_decode(htmlspecialchars($val)));
    return $prop;
    }
  }
  
  function checkManualEntryAtt($row,$propval,$prop, $propkey) {
    if(strlen($propval) > 0) {
      if(array_key_exists($propval, $row))
	$prop->addAttribute($propkey, utf8_decode(htmlspecialchars($row[$propval])));
      else
	$prop->addAttribute($propkey, utf8_decode(htmlspecialchars($propval)));
      return $prop;
    }
  }
?>