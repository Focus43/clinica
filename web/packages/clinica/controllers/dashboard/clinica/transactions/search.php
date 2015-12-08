<?php defined('C5_EXECUTE') or die("Access Denied.");

	class DashboardClinicaTransactionsSearchController extends ClinicaPageController {
	
        protected $requireHttps = true;
		
		public function view(){
			$searchInstance = 'transaction' . time();
			$this->addHeaderItem(Loader::helper('html')->css('clinica.dashboard.css', 'clinica'));
			$this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
			$this->addFooterItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\''.$searchInstance.'\'); });</script>');
			$this->addFooterItem(Loader::helper('html')->javascript('dashboard/app.dashboard.js', 'clinica'));
			$this->set('listObject', $this->transactionListObj());
			$this->set('listResults', $this->transactionListObj()->getPage());
			$this->set('searchInstance', $searchInstance);
		}
		
		
		public function transactionListObj(){
			if( $this->_transactionListObj === null ){
				$this->_transactionListObj = new ClinicaTransactionList();
				$this->applySearchFilters( $this->_transactionListObj );
			}
			return $this->_transactionListObj;
		}
		
		
		private function applySearchFilters( ClinicaTransactionList $listObj ){
			if( !empty($_REQUEST['numResults']) ){
				$listObj->setItemsPerPage( $_REQUEST['numResults'] );
			}
			
			if( !empty($_REQUEST['keywords']) ){
				$listObj->filterByKeywords( $_REQUEST['keywords'] );
			}
			
			if( !empty($_REQUEST['typeHandle']) ){
				$listObj->filterByTypeHandle( $_REQUEST['typeHandle'] );
			}
			
			if( !empty($_REQUEST['amount']) ){
				$listObj->filterByAmount($_REQUEST['amount']);
			}
			
			// if *both* date range start and end are set
			if( !empty($_REQUEST['dateRangeStart']) && !empty($_REQUEST['dateRangeEnd']) ){
				$dateStart = date('Y-m-d H:i:s', strtotime($_REQUEST['dateRangeStart']));
				$dateEnd   = date('Y-m-d H:i:s', strtotime($_REQUEST['dateRangeEnd'] . ' +1 days'));
				$listObj->filterByBetweenDates($dateStart, $dateEnd);
			}
			
			// if *only* start date is set
			if( !empty($_REQUEST['dateRangeStart']) && empty($_REQUEST['dateRangeEnd'])){
				$dateStart = date('Y-m-d H:i:s', strtotime($_REQUEST['dateRangeStart']));
				$listObj->filterByDateCreated($dateStart, '>=');
			}
			
			// if *only* end date is set
			if( !empty($_REQUEST['dateRangeEnd']) && empty($_REQUEST['dateRangeStart'])){
				$dateEnd   = date('Y-m-d H:i:s', strtotime($_REQUEST['dateRangeEnd'] . ' +1 days'));
				$listObj->filterByDateCreated($dateEnd, '<=');
			}

			// card expiration month matches
			if( !empty($_REQUEST['cardExpMonth']) ){
				$listObj->filterByCreditCardMonth( $_REQUEST['cardExpMonth'] );
			}
			
			// card expiration year
			if( !empty($_REQUEST['cardExpYear']) ){
				$listObj->filterByCreditCardYear( $_REQUEST['cardExpYear'] );
			}
			
			// address components
			if( !empty($_REQUEST['address1']) ){
				$listObj->filterByAddress1($_REQUEST['address1']);
			}
			
			if( !empty($_REQUEST['city']) ){
				$listObj->filterByCity($_REQUEST['city']);
			}
			
			if( !empty($_REQUEST['state']) ){
				$listObj->filterByState($_REQUEST['state']);
			}
			
			if( !empty($_REQUEST['zip']) ){
				$listObj->filterByZip($_REQUEST['zip']);
			}
			
			return $listObj;
		}
	
	}