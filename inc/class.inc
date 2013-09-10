<?php

class org {

  public $orgname;
  public $orgref;
  public $orgcurrency;
  public $orgcontact;
  public $orglanguage;
  public $orgphone;
  public $orgemail;
  public $orgaddress;
  
  function org($posts) {
    foreach($posts as $key=>$val) {
      foreach(get_object_vars($this) as $varkey=>$varval) {
	if ($key == $varkey) {
	  $this->$varkey = $val;
	}
      }
    }
  }
}


?>