<?php

	class ClinicaTransaction extends ClinicaBaseObject {
		
		
		const TYPE_DONATION 	= 'donation',
			  TYPE_BILL_PAY 	= 'bill_payment',
			  TYPE_MISS_GREEK	= 'miss_greek';
		
		
		protected $attrCategoryHandle = 'clinica_transaction';
		
		
		public function __construct( array $properties = array() ){
			parent::__construct( $properties );
			$this->tableName = __CLASS__;
		}
		
		
		public function __toString(){
			return (string) 'placeholder';
		}
		
		
		/** @return int Get the serverID */
		public function getTransactionID(){ return $this->id; }
		
		/** @return string Get transaction type handle */
		public function getTypeHandle(){ return $this->typeHandle; }
		
		/** @return string Get person's first name */
		public function getFirstName(){ return $this->firstName; }
		
		/** @return int Get person's middle initial */
		public function getMiddleInitial(){ return $this->middleInitial; }
		
		/** @return int Get person's last name */
		public function getLastName(){ return $this->lastName; }
		
		/** @return int Get person's phone # */
		public function getPhone(){ return $this->phone; }
		
		/** @return int Get person's email */
		public function getEmail(){ return $this->email; }
		
		/** @return int Get address line 1 */
		public function getAddress1(){ return $this->address1; }
		
		/** @return int Get address line 2 */
		public function getAddress2(){ return $this->address2; }
		
		/** @return int Get address city */
		public function getCity(){ return $this->city; }
		
		/** @return int Get address state */
		public function getState(){ return $this->state; }
		
		/** @return int Get address zip */
		public function getZip(){ return $this->zip; }
		
		/** @return int Get transaction amount */
		public function getAmount(){ return $this->amount; }
		
		/** @return int Get authorize.net response code */
		public function getAuthNetResponseCode(){ return $this->authNetResponseCode; }
		
		/** @return int Get authorize.net authorization code */
		public function getAuthNetAuthorizationCode(){ return $this->authNetAuthorizationCode; }
		
		/** @return int Get authorize.net address verification response */
		public function getAuthNetAvsResponse(){ return $this->authNetAvsResponse; }
		
		/** @return int Get authorize.net transaction ID */
		public function getAuthNetTransactionID(){ return $this->authNetTransactionID; }
		
		/** @return int Get authorize.net method */
		public function getAuthNetMethod(){ return $this->authNetMethod; }
		
		/** @return int Get authorize.net transaction type */
		public function getAuthNetTransactionType(){ return $this->authNetTransactionType; }
		
		/** @return int Get authorize.net md5 transaction hash */
		public function getAuthNetMd5Hash(){ return $this->authNetMd5Hash; }
		
		/** @return int Get last 4 digits of credit card */
		public function getCardLastFour(){ return $this->cardLastFour; }
		
		/** @return int Get credit card expiration month */
		public function getCardExpMonth(){ return $this->cardExpMonth; }
		
		/** @return int Get credit card expiration year */
		public function getCardExpYear(){ return $this->cardExpYear; }
		
		
		protected function persistable(){
			$fields = array(
				'typeHandle', 'firstName', 'middleInitial', 'lastName',
				'phone', 'email', 'address1', 'address2', 'city', 'state', 'zip', 'amount',
				'authNetResponseCode', 'authNetAuthorizationCode', 'authNetAvsResponse',
				'authNetTransactionID', 'authNetMethod', 'authNetTransactionType', 'authNetMd5Hash',
				'cardLastFour', 'cardExpMonth', 'cardExpYear'
			);
			return $fields;
		}
		
		
		public function save(){
			if( $this->validateOnSave() ){
				// record already exists, do an update
				if( $this->id >= 1 ){
					
				}else{
					$db 		= Loader::db();
					$fields		= $this->persistable();
					$fieldNames = "createdUTC, modifiedUTC, " . implode(',', $fields);
					$fieldCount	= implode(',', array_fill(0, count($fields), '?'));
					$values		= array();
					foreach($fields AS $property){
						$values[] = $this->{$property};
					}
					$db->Execute("INSERT INTO ClinicaTransaction ($fieldNames) VALUES (UTC_TIMESTAMP(), UTC_TIMESTAMP(), $fieldCount)", $values);
					$this->isNew = true;
					$this->id	 = $db->Insert_ID();
				}
				
				// save attributes
				
				return self::getByID( $this->id );
			}
		}
		
		
		public static function getByID( $id ){
			$self = new self();
			$row = Loader::db()->GetRow("SELECT * FROM {$self->tableName} WHERE id = ?", array( (int)$id ));
			$self->setPropertiesFromArray($row);
			return $self;
		}
		
		
		public function delete(){
			
		}
		
		
		protected function validateOnSave(){
			return true;
		}
		
		
		/* Attribute association stuff
        ----------------------------------------------------------------------*/ 
        public function clearAttribute($ak){
        	parent::clearAttribute($ak);
        }
        
        
        public function setAttribute($ak, $value) {            
            parent::setAttribute($ak, $value);
        }
		
		
		public function getAttribute($ak, $displayMode = false) {
            return parent::getAttribute( $ak, $displayMode );
        }
		
		
		public function getAttributeField($ak){
			parent::getAttributeField( $ak );
		}
		
		
		public function getAttributeValueObject($ak, $createIfNotFound = false) {
        	return parent::getAttributeValueObjectGeneric( $ak, $createIfNotFound, array(
        		'table'			=> 'ClinicaTransactionAttributeValues',
        		'idColumn'		=> 'transactionID',
        		'attrValClass'	=> 'ClinicaTransactionAttributeValue',
        		'setObjMethod'	=> 'setTransaction'
			));
        }

        
        public function reindex() {
        	parent::reindexGeneric(array(
        		'table'		=> 'ClinicaTransactionSearchIndexAttributes',
        		'idColumn'	=> 'transactionID'
			));
        }
		
	}
