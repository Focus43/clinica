<?php

	class DashboardClinicaTransactionsController extends Controller {
	
		public function view( $id = null ) {
			// viewing a specific transaction
			if( !is_null($id) && ((int) $id >= 1) ){
				$transaction = ClinicaTransaction::getByID($id);
				$this->set('transactionObj', $transaction);
				$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
				return;
			}
			
			// just redirecting to the search page
			$this->redirect('/dashboard/clinica/transactions/search');
		}
		
		
		public function add(){
			
		}
	
	}