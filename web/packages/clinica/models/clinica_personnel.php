<?php

	class ClinicaPersonnel {
		
		
		const PROVIDER_FEDERAL_HEIGHTS 	= 'federal_heights',
			  PROVIDER_LAFAYETTE		= 'lafayette',
			  PROVIDER_PECOS			= 'pecos',
			  PROVIDER_PEOPLES			= 'peoples',
			  PROVIDER_THORNTON			= 'thornton',
			  PROVIDER_DENTAL			= 'dental';
		
		protected $tableName,
				  $id,
				  $createdUTC,
				  $modifiedUTC;

		// helper for generating lists
		public static $providerLocations = array(
			self::PROVIDER_FEDERAL_HEIGHTS 	=> 'Federal Heights',
			self::PROVIDER_LAFAYETTE		=> 'Lafayette',
			self::PROVIDER_PECOS			=> 'Pecos',
			self::PROVIDER_PEOPLES			=> 'People\'s',
			self::PROVIDER_THORNTON			=> 'Thornton',
			self::PROVIDER_DENTAL			=> 'Dental'
		);
		
		
		/**
		 * @param array $properties Set object property values with key => value array
		 */	
		public function __construct( array $properties = array() ){
			$this->setPropertiesFromArray($properties);
			$this->tableName = __CLASS__;
		}
		
		
		public function __toString(){
			return "{$this->lastName}, {$this->firstName}";
		}
		
		/** @return int Get the personnelID */
		public function getPersonnelID(){ return $this->id; }
		/** @return string Date the object was first created */
		public function getDateCreated(){ return $this->createdUTC; }
		/** @return string Date the object was last modified */
		public function getDateModified(){ return $this->modifiedUTC; }
		/** @return string Get first name */
		public function getFirstName(){ return ucfirst($this->firstName); }
		/** @return string Get last name */
		public function getLastName(){ return ucfirst($this->lastName); }
		/** @return string Get title */
		public function getTitle(){ return $this->title; }
		/** @return string Get picture ID (File object ID) */
		public function getPicID(){ return $this->picID; }
		/** @return string Get description */
		public function getDescription(){ return $this->description; }
		/** @return string Get provider location handle */
		public function getProviderHandle($formatted = false){
			if( $formatted === true ){
				return ucwords(str_replace(array('_', '-', '/'), ' ', $this->providerHandle));
			}
			return $this->providerHandle; 
		 }
		
		public function getPictureFileObj(){
			if( $this->_fileObj === null ){
				$this->_fileObj = File::getByID( $this->picID );
			}
			return $this->_fileObj;
		}
		
		/**
		 * Set properties of the current instance
		 * @param array $arr Pass in an array of key => values to set object properties
		 * @return void
		 */
		public function setPropertiesFromArray( array $properties = array() ) {
			foreach($properties as $key => $prop) {
				$this->{$key} = $prop;
			}
		}
		
		
		protected function persistable(){
			return array('firstName', 'lastName', 'title', 'picID', 'description', 'providerHandle');
		}
		
		
		public function save(){
			// record already exists, do an update
			if( $this->id >= 1 ){
				$fields		= $this->persistable();
				$updateStr  = 'modifiedUTC = UTC_TIMESTAMP()';
				$values		= array();
				foreach($fields AS $property){
					$updateStr .= ", {$property} = ?";
					$values[] = $this->{$property};
				}
				$values[] = $this->id;
				Loader::db()->Execute("UPDATE {$this->tableName} SET {$updateStr} WHERE id = ?", array($values));
			}else{
				$db 		= Loader::db();
				$fields		= $this->persistable();
				$fieldNames = "createdUTC, modifiedUTC, " . implode(',', $fields);
				$fieldCount	= implode(',', array_fill(0, count($fields), '?'));
				$values		= array();
				foreach($fields AS $property){
					$values[] = $this->{$property};
				}
				$db->Execute("INSERT INTO {$this->tableName} ($fieldNames) VALUES (UTC_TIMESTAMP(), UTC_TIMESTAMP(), $fieldCount)", $values);
				$this->id	 = $db->Insert_ID();
			}
			
			return self::getByID( $this->id );
		}
		
		
		public static function getByID( $id ){
			$self = new self();
			$row = Loader::db()->GetRow("SELECT * FROM {$self->tableName} WHERE id = ?", array( (int)$id ));
			$self->setPropertiesFromArray($row);
			return $self;
		}
		
		
		/**
		 * Delete the record, and any attribute values associated w/ it
		 * @return void
		 */
		public function delete(){
			Loader::db()->Execute("DELETE FROM {$this->tableName} WHERE id = ?", array($this->id));
		}
		
	}