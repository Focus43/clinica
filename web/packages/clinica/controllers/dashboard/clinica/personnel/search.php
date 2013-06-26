<?php defined('C5_EXECUTE') or die("Access Denied.");

	class DashboardClinicaPersonnelSearchController extends Controller {
	
		public $helpers = array('form');
	
		public function on_start() {
			
		}
		
		
		public function view(){
			$searchInstance = 'personnel' . time();
			$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
			$this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
			$this->addFooterItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\''.$searchInstance.'\'); });</script>');
			$this->addFooterItem(Loader::helper('html')->javascript('dashboard/app.dashboard.js', 'clinica'));
			$this->set('listObject', $this->personnelListObj());
			$this->set('listResults', $this->personnelListObj()->getPage());
			$this->set('searchInstance', $searchInstance);
		}
		
		
		public function personnelListObj(){
			if( $this->_personnelListObj === null ){
				$this->_personnelListObj = new ClinicaPersonnelList();
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
			
			return $listObj;
		}
	
	}