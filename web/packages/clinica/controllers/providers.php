<?php

	class ProvidersController extends ClinicaPageController {
		
		public $helpers = array('form', 'image');
		
		
		public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
			parent::on_start();
		}
		
		
		public function view(){
			$perColumn = round( ($this->personnelListObj()->getTotal() / 2), 0) ;
			$this->set('listColumn1', $this->personnelListObj()->get($perColumn));
			$this->set('listColumn2', $this->personnelListObj()->get($perColumn, $perColumn));
		}
		
		
		public function profile( $id ){
			$this->set('personnelObj', ClinicaPersonnel::getByID($id));
		}
		
		
		private function personnelListObj(){
			if( $this->_personnelListObj === null ){
				$this->_personnelListObj = new ClinicaPersonnelList();
				$this->_personnelListObj->sortByLastName();
				$this->applySearchFilters( $this->_personnelListObj );
			}
			return $this->_personnelListObj;
		}
		
		
		private function applySearchFilters( ClinicaPersonnelList $listObj ){
			if( !empty($_REQUEST['numResults']) ){
				$listObj->setItemsPerPage( $_REQUEST['numResults'] );
			}
			
			if( !empty($_REQUEST['keywords']) ){
				$listObj->filterByKeywords( $_REQUEST['keywords'] );
			}
			
			if( !empty($_REQUEST['providerHandle']) ){
				$listObj->filterByProviderHandle( $_REQUEST['providerHandle'] );
			}
		}
		
	}
