<?php

	class ClinicaTransactionList extends DatabaseItemList {
		
		const DB_FRIENDLY_DATE = 'Y-m-d H:i:s';
		
		
		protected $autoSortColumns 	= array('createdUTC', 'modifiedUTC', 'typeHandle', 'firstName', 'lastName', 'email', 'city', 'state', 'amount', 'cardLastFour', 'cardExpMonth', 'cardExpYear'),
				  $itemsPerPage		= 10,
				  $attributeClass	= 'ClinicaTransactionAttributeKey',
				  $attributeFilters = array();
		
		
		// MAGIC METHOD FOR FILTERING BY ATTRIBUTES
        public function __call($nm, $a) {
            if (substr($nm, 0, 8) == 'filterBy') {
                $txt = Loader::helper('text');
                $attrib = $txt->uncamelcase(substr($nm, 8));
                if (count($a) == 2) {
                        $this->filterByAttribute($attrib, $a[0], $a[1]);
                } else {
                        $this->filterByAttribute($attrib, $a[0]);
                }
            }
		}
		
		
		public function filterByKeywords($keywords) {
            $db = Loader::db();
            $this->searchKeywords = $db->quote($keywords);
            $qkeywords = $db->quote('%' . $keywords . '%');
            $keys = ClinicaTransactionAttributeKey::getSearchableIndexedList();
            $attribsStr = '';
            foreach ($keys as $ak) {
                    $cnt = $ak->getController();
                    $attribsStr.=' OR ' . $cnt->searchKeywords($keywords);
            }
            $this->filter(false, "(ct.firstName LIKE $qkeywords OR ct.lastName LIKE $qkeywords OR ct.phone LIKE $qkeywords OR ct.email LIKE $qkeywords OR ct.address1 LIKE $qkeywords OR ct.city LIKE $qkeywords OR ct.zip LIKE $qkeywords OR $qkeywords {$attribsStr})");
		}
		
		
		/**
		 * Filter by name (checks both first and last name fields)
		 * @param string Name (first or last)
		 */
		public function filterByName( $name ){
            $name = Loader::db()->quote('%'.$name.'%');
            $this->filter(false, "ct.firstName LIKE $name OR ct.lastName LIKE $name");
        }
		
		
		public function filterByTypeHandle( $typeHandle ){
			$this->filter('ct.typeHandle', $typeHandle, '=');
		}
		
		
		public function filterByAmount( $amount ){
			$this->filter('ct.amount', $amount, '=');
		}
		
		
		public function filterByDateCreated($date, $comparison = '='){
			$this->filter('ct.createdUTC', $date, $comparison);
		}
		
		
		public function filterByBetweenDates( $dateStart, $dateEnd ){
			$this->filter(false, "(ct.createdUTC between '$dateStart' and '$dateEnd')");
		}
		
		
		public function filterByCreditCardMonth( $numericMonth, $comparison = '=' ){
			$this->filter('ct.cardExpMonth', (int) $numericMonth, $comparison);
		}
		
		
		public function filterByCreditCardYear( $numericYear, $comparison = '=' ){
			$this->filter('ct.cardExpYear', (int) $numericYear, $comparison);
		}
		
		
		public function filterByAddress1( $address1 ){
			$this->filter('ct.address1', "{$address1}%", 'LIKE');
		}
		
		
		public function filterByCity( $city ){
			$this->filter('ct.city', "{$city}%", 'LIKE');
		}
		
		
		public function filterByState( $state ){
			$this->filter('ct.state', $state, '=');
		}
		
		
		public function filterByZip( $zip ){
			$this->filter('ct.zip', "{$zip}%", 'LIKE');
		}
		
		
		public function get( $itemsToGet = 100, $offset = 0 ){
            $transactions = array();
            $this->createQuery();
            $r = parent::get($itemsToGet, $offset);
            foreach($r AS $row){
                $transactions[] = ClinicaTransaction::getByID( $row['id'] );
            }
            return $transactions;
        }
        
        
        public function getTotal(){
            $this->createQuery();
            return parent::getTotal();
        }
        
        
        protected function createQuery(){
            if( !$this->queryCreated ){
                $this->setBaseQuery();
                $this->setupAttributeFilters("LEFT JOIN ClinicaTransactionSearchIndexAttributes ctattrsearch ON (ctattrsearch.transactionID = ct.id)");
                $this->queryCreated = true;
            }
        }
        
        public function setBaseQuery(){
            $queryStr = "SELECT ct.id FROM ClinicaTransaction ct";
            $this->setQuery( $queryStr );
        }
		
	}


	class ClinicaTransactionDefaultColumnSet extends DatabaseItemListColumnSet {
		
		protected $attributeClass = 'ClinicaTransactionAttributeKey';
		
		
		public function __construct(){
			$this->addColumn(new DatabaseItemListColumn('createdUTC', t('Added'), array('ClinicaTransactionDefaultColumnSet', 'getDateCreated')));
			$this->addColumn(new DatabaseItemListColumn('firstName', t('First Name'), 'getFirstName'));
			$this->addColumn(new DatabaseItemListColumn('lastName', t('Last Name'), 'getLastName'));
			$this->addColumn(new DatabaseItemListColumn('cardLastFour', t('Card Last 4'), array('ClinicaTransactionDefaultColumnSet', 'getCardLastFour')));
			$this->addColumn(new DatabaseItemListColumn('amount', t('Amount ($)'), array('ClinicaTransactionDefaultColumnSet', 'getAmount')));
			$added = $this->getColumnByKey('createdUTC');
			$this->setDefaultSortColumn($added, 'desc');
		}
		
		
		public function getDateCreated( ClinicaTransaction $transaction ){
			return date('M d, Y', strtotime($transaction->getDateCreated()));
		}
		
		
		public function getCardLastFour( ClinicaTransaction $transaction ){
			return "**** {$transaction->getCardLastFour()}";
		}
		
		
		public function getAmount( ClinicaTransaction $transaction ){
			return number_format( $transaction->getAmount(), 2 );
		}
		
	}


	class ClinicaTransactionAvailableColumnSet extends ClinicaTransactionDefaultColumnSet {
		public function __construct(){
			$this->addColumn(new DatabaseItemListColumn('email', t('Email'), 'getEmail'));
			$this->addColumn(new DatabaseItemListColumn('phone', t('Phone'), 'getPhone'));
			$this->addColumn(new DatabaseItemListColumn('city', t('City'), 'getCity'));
			$this->addColumn(new DatabaseItemListColumn('state', t('State'), 'getState'));
			$this->addColumn(new DatabaseItemListColumn('zip', t('Zip'), 'getZip'));
			$this->addColumn(new DatabaseItemListColumn('message', t('Message'), 'getMessage'));
            $this->addColumn(new DatabaseItemListColumn('cardExpMonth', t('Card Exp.'), array('ClinicaTransactionAvailableColumnSet', 'getCardExp')));
            $this->addColumn(new DatabaseItemListColumn('userID', t('Transaction Run By'), array('ClinicaTransactionAvailableColumnSet', 'getTransactionRunBy')));
			parent::__construct();
		}
        
        
        public function getCardExp( ClinicaTransaction $transaction ){
            return str_pad($transaction->getCardExpMonth(), 2, "0", STR_PAD_LEFT) . "/{$transaction->getCardExpYear()}";
        }
        
        
        public function getTransactionRunBy( ClinicaTransaction $transaction ){
            if( $transaction->getUserID() >= 1 ){
                $userInfoObj = UserInfo::getByID( $transaction->getUserID() );
                return ucwords( t('%s, %s', $userInfoObj->getAttribute('last_name'), $userInfoObj->getAttribute('first_name')) );
            }
            return 'Visitor';
        }
	}
	
	
	class ClinicaTransactionColumnSet extends DatabaseItemListColumnSet {
		
		protected $attributeClass = 'ClinicaTransactionAttributeKey';
		
		public function getCurrent(){
			$userObj = new User();
			$columns = $userObj->config('CLINICA_TRANSACTION_DEFAULT_COLUMNS');
			if( $columns != '' ){
				$columns = @unserialize($columns);
			}
			if( !($columns instanceof DatabaseItemListColumnSet) ){
				$columns = new ClinicaTransactionDefaultColumnSet;
			}
			return $columns;
		}
		
	}
