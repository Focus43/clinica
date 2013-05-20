<?php

	class ClinicaPersonnel {
		
		
		const PROVIDER_FEDERAL_HEIGHTS 	= 'federal_heights',
			  PROVIDER_LAFAYETTE		= 'lafayette',
			  PROVIDER_PECOS			= 'pecos',
			  PROVIDER_PEOPLES			= 'peoples',
			  PROVIDER_THORNTON			= 'thornton',
			  
              // dental
              PROVIDER_PECOS_DENTAL     = 'pecos_dental',
              PROVIDER_THORNTON_DENTAL  = 'thornton_dental';
		
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
			self::PROVIDER_PECOS_DENTAL     => 'Pecos Dental',
			self::PROVIDER_THORNTON_DENTAL  => 'Thornton Dental'
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
        
		/** @return string Get provider location handle(s) as array or formatted string */		
		public function getProviderLocations($formatted = false){
		    if( $formatted === true ){
		        // if no locations, return 'unassigned'
		        if( empty($this->locations) ){ return 'Unassigned'; }
                // otherwise, implode the array and concatenate
		        return implode(', ', array_map(function( $locationHandle ){
		            return ucwords(str_replace(array('_', '-', '/'), ' ', $locationHandle));
		        }, $this->locations));
		    }
            return $this->locations;
		}
        
        
        /**
         * Test if the personnel object is a member of a certain location
         * @param string $locationHandle
         * @return bool
         */
        public function memberOfLocation( $locationHandle ){
            return in_array($locationHandle, (array) $this->getProviderLocations());
        }
        
		
        /**
         * @return File
         */
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
			return array('firstName', 'lastName', 'title', 'picID', 'description');
		}
		
		
		public function save(){
			$db = Loader::db();
            
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
				$db->Execute("UPDATE {$this->tableName} SET {$updateStr} WHERE id = ?", array($values));
			}else{
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

            // update provider locations
            $db->Execute("DELETE FROM ClinicaPersonnelLocations WHERE personnelID = ?", array($this->id));
            if( !empty($this->providerHandle) && is_array($this->providerHandle) ){
                foreach($this->providerHandle AS $providerHandle){
                    $db->Execute("INSERT INTO ClinicaPersonnelLocations (personnelID, providerHandle) VALUES(?,?)", array(
                        $this->id, $providerHandle
                    ));
                }
            }
			
			return self::getByID( $this->id );
		}
		
		
        /**
         * To handle multiple provider locations, we use a subquery and group_concat one or more
         * locations into a string as "locations" column. If that column is *not* null, we automatically
         * split it by commas and transform it into an array (saves on multiple queries).
         */
		public static function getByID( $id ){
			$self = new self();
			$row = Loader::db()->GetRow("select cp.*, (select group_concat(providerHandle SEPARATOR ',') from ClinicaPersonnelLocations where personnelID = ?) AS locations from ClinicaPersonnel cp where id = ?", array(
                $id, $id
            ));
			$self->setPropertiesFromArray($row);
            
            // transform locations from string into array
            if( isset($self->locations) && is_string($self->locations) ){
                $self->locations = explode(',', $self->locations);
            }else{
                $self->locations = array();
            }
            
			return $self;
		}
		
		
		/**
		 * Delete the record, and any attribute values associated w/ it
		 * @return void
		 */
		public function delete(){
		    $db = Loader::db();
			$db->Execute("DELETE FROM {$this->tableName} WHERE id = ?", array($this->id));
            $db->Execute("DELETE FROM ClinicaPersonnelLocations WHERE personnelID = ?", array($this->id));
		}
		
	}