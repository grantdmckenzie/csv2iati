<?php
	/*
	@author: Grant McKenzie
	@client: World Bank
	@project: csv2iati
	@date: August 2013
	@description: User Object
	*/
	
	class WBUser {
		
		public $username;
		public $first;
		public $last;
		public $ref;
		public $org;
		public $orgtype;
		public $currency;
		public $phone;
		public $language;
		public $address;
		public $id;
		
		public function __construct($row) {
			$this->username=$row['username'];
			$this->first=$row['first'];
			$this->last=$row['last'];
			$this->org=$row['organization'];
			$this->ref=$row['reference'];
			$this->orgtype=$row['orgtype'];
			$this->address=$row['address'];
			$this->phone=$row['phone'];
			$this->currency=$row['currency'];
			$this->language=$row['language'];
			$this->id=$row['id'];
		}	
	}	
?>