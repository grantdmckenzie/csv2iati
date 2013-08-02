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
		public $email;
		public $ref;
		public $org;
		public $orgtype;
		
		public function __construct($row) {
			$this->username=$row['username'];
			$this->first=$row['first'];
			$this->last=$row['last'];
			$this->org=$row['organization'];
			$this->ref=$row['reference'];
			$this->orgtype=$row['orgtype'];
			$this->email=$row['email'];
		}	
	}	
?>