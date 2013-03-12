<?php

	class DashboardClinicaTransactionsSearchController extends Controller {
	
		public function on_start() {
			$this->set('transactionListObj', $this->transactionListObj());
			$this->set('listResults', $this->transactionListObj()->get());
		}
		
		
		protected function transactionListObj(){
			if( $this->_transactionListObj === null ){
				$this->_transactionListObj = new ClinicaTransactionList();
			}
			return $this->_transactionListObj;
		}
	
	}