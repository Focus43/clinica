<?php

	class ClinicaTransactionList extends DatabaseItemList {
		
		const DB_FRIENDLY_DATE = 'Y-m-d H:i:s';
		
		
		protected $autoSortColumns 	= array('createdUTC', 'modifiedUTC', 'typeHandle', 'firstName', 'lastName', 'email', 'city', 'state', 'amount', 'cardLastFour', 'cardExpMonth', 'cardExpYear'),
				  $itemsPerPage		= 20,
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
            $qkeywords = $db->quote('%' . $keywords);
            $keys = ClinicaTransactionAttributeKey::getSearchableIndexedList();
            $attribsStr = '';
            foreach ($keys as $ak) {
                    $cnt = $ak->getController();
                    $attribsStr.=' OR ' . $cnt->searchKeywords($keywords);
            }
            $this->filter(false, "(ct.firstName LIKE $qkeywords OR ct.lastName LIKE $qkeywords OR ct.phone LIKE $qkeywords OR ct.email LIKE $qkeywords OR ct.address1 LIKE $qkeywords OR ct.city LIKE $qkeywords OR $qkeywords {$attribsStr})");
		}
		
		
		/**
		 * Filter by name (checks both first and last name fields)
		 * @param string Name (first or last)
		 */
		public function filterByName( $name ){
            $name = Loader::db()->quote('%'.$name.'%');
            $this->filter(false, "ct.firstName LIKE $name OR ct.lastName LIKE $name");
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
