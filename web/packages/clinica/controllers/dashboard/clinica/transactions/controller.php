<?php

	class DashboardClinicaTransactionsController extends Controller {
	
		public function view( $id = null ) {
			// viewing a specific transaction
			if( !is_null($id) && ((int) $id >= 1) ){
				$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
				$transactionObj = ClinicaTransaction::getByID($id);
				$this->set('transactionObj', $transactionObj);
				$this->set('attributeKeys', AttributeSet::getByHandle($transactionObj->getTypeHandle())->getAttributeKeys() );
				return;
			}
			
			// just redirecting to the search page
			$this->redirect('/dashboard/clinica/transactions/search');
		}
		
		
		public function add(){
			
		}
	
	}