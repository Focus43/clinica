<?php

	class DashboardClinicaTransactionsSearchController extends Controller {
	
		public function on_start() {
			
		}
		
		
		public function view(){
			$this->addHeaderItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\'transactions\'); });</script>');
			$this->set('listObject', $this->transactionListObj());
			$this->set('listResults', $this->transactionListObj()->getPage());
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
			
			return $listObj;
		}
	
	}