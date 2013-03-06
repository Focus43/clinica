<?php

	class GivingController extends ClinicaPageController {
		
		public $helpers = array('form');
		
		
		public function view(){
			if( !( isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on') ) ){
				header("Location: " . $this->secureAction(''));
			}
		}
		
		
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
				$this->flash('Success! Thank you for supporting Clinica.');
				$this->redirect('/giving');
			}else{
				$this->flash('Transaction failed.', self::FLASH_TYPE_ERROR);
				$this->redirect('/giving');
			}
		}
		
	}
