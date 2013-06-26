<?php defined('C5_EXECUTE') or die("Access Denied.");

	class ProvidersController extends ClinicaPageController {
		
		public $helpers = array('form', 'image');
		
        protected $includeThemeAssets = true,
                  $supportsPageCache  = true;
		
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
			$personnelObj = ClinicaPersonnel::getByID($id);
			$this->set('personnelObj', $personnelObj);
		}
		
		
		public function location( $providerHandle ){
			$this->personnelListObj()->filterByProviderHandle($providerHandle);
			$this->set('providerHandle', $providerHandle);
			$this->view();
		}
		
		
		private function personnelListObj(){
			if( $this->_personnelListObj === null ){
				$this->_personnelListObj = new ClinicaPersonnelList();
				$this->_personnelListObj->sortByLastName();
			}
			return $this->_personnelListObj;
		}
		
	}
