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
			$this->addColumn(new DatabaseItemListColumn('typeHandle', t('Type'), array('ClinicaTransactionDefaultColumnSet', 'getTypeHandle')));
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
		
		
		public function getTypeHandle( ClinicaTransaction $transaction ){
			$url  = View::url('dashboard/clinica/transactions/', $transaction->getTransactionID());
			$name = ucwords(str_replace(array('_', '-', '/'), ' ', $transaction->getTypeHandle()));
			return '<a href="'.$url.'">'.$name.'</a>';
		}
		
		
		public function getAmount( ClinicaTransaction $transaction ){
			return number_format( $transaction->getAmount(), 2 );
		}
		
	}
	
	
	class ClinicaTransactionColumnSet extends DatabaseItemListColumnSet {
		
		protected $attributeClass = 'ClinicaTransactionAttributeKey';
		
		public function getCurrent(){
			return new ClinicaTransactionDefaultColumnSet;
		}
		
	}
