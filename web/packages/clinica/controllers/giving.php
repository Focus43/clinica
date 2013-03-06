<?php

	class GivingController extends ClinicaPageController {
		
		public $helpers = array('form');
		
		
		public function on_before_render(){
			// never send back the credit card
			$_POST['card_number'] = false;
		}
		
		
		public function process(){
			// run the transaction
			$transaction = new ClinicaTransaction( $_POST, ClinicaTransaction::TYPE_DONATION );
			
			// what happened?
			if( $transaction->result() ){
				$transaction->saveRecord();
			}else{
				echo 'failed';
			}
			exit;
		}
		
	}
