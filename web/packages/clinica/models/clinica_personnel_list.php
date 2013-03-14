<?php

	class ClinicaPersonnelList extends DatabaseItemList {
		
		const DB_FRIENDLY_DATE = 'Y-m-d H:i:s';
		
		
		protected $autoSortColumns 	= array('createdUTC', 'modifiedUTC', 'firstName', 'lastName', 'title'),
				  $itemsPerPage		= 10;
		
		
		public function filterByKeywords($keywords) {
            $db = Loader::db();
            $this->searchKeywords = $db->quote($keywords);
            $qkeywords = $db->quote('%' . $keywords . '%');
            $this->filter(false, "(cp.firstName LIKE $qkeywords OR cp.lastName LIKE $qkeywords)");
		}
		
		
		/**
		 * Filter by name (checks both first and last name fields)
		 * @param string Name (first or last)
		 */
		public function filterByName( $name ){
            $name = Loader::db()->quote('%'.$name.'%');
            $this->filter(false, "cp.firstName LIKE $name OR cp.lastName LIKE $name");
        }
		
		
		public function filterByProviderHandle( $provider ){
			$this->filter('cp.providerHandle', $provider, '=');
		}
		
		
		public function sortByLastName(){
			parent::sortBy('cp.lastName', 'asc');
		}
		
		
		public function get( $itemsToGet = 100, $offset = 0 ){
            $personnel = array();
            $this->createQuery();
            $r = parent::get($itemsToGet, $offset);
            foreach($r AS $row){
                $personnel[] = ClinicaPersonnel::getByID( $row['id'] );
            }
            return $personnel;
        }
        
        
        public function getTotal(){
            $this->createQuery();
            return parent::getTotal();
        }
        
        
        protected function createQuery(){
            if( !$this->queryCreated ){
                $this->setBaseQuery();
                $this->queryCreated = true;
            }
        }
        
        public function setBaseQuery(){
            $queryStr = "SELECT cp.id FROM ClinicaPersonnel cp";
            $this->setQuery( $queryStr );
        }
		
	}


	class ClinicaPersonnelColumnSet extends DatabaseItemListColumnSet {
		
		public function __construct(){
			$this->addColumn(new DatabaseItemListColumn('lastName', t('Name'), array('ClinicaPersonnelColumnSet', 'getNameAsLast')));
			$this->addColumn(new DatabaseItemListColumn('title', t('Title'), 'getTitle'));
			$this->addColumn(new DatabaseItemListColumn('provider', t('Provider'), array('ClinicaPersonnelColumnSet', 'getProvider')));
		}
		
		public function getNameAsLast( ClinicaPersonnel $personnelObj ){
			$name = "{$personnelObj->getLastName()}, {$personnelObj->getFirstName()}";
			return '<a href="'.View::url('dashboard/clinica/personnel/edit', $personnelObj->getPersonnelID()).'">'.$name.'</a>';
		}
		
		public function getProvider( ClinicaPersonnel $personnelObj ){
			return $personnelObj->getProviderHandle(true);
		}
		
		public function getCurrent(){
			return new self;
		}
		
	}

