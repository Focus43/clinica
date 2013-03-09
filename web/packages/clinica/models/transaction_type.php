<?php

	class ClinicaTransactionRecord {
		
		protected $akcHandle = 'transaction_record';
		
		
		public function __construct( array $properties = array() ){
			$this->setPropertiesFromArray( $properties );
			$this->tableName = __CLASS__;
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
		
		
		public function save(){
			if( $this->validateOnSave() ){
				// record already exists, do an update
				if( $this->id >= 1 ){
					
				}else{
					
				}
				
				// save attributes
				
				return self::getByID( $this->id );
			}
		}
		
		
		public static function getByID( $id ){
			$row = Loader::db()->GetRow("SELECT * FROM {$this->tableName} WHERE id = ?", array( (int)$id ));
			return new self( $row );
		}
		
		
		protected function validateOnSave(){
			
		}
		
	}
