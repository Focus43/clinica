<?php

	class GivingController extends ClinicaPageController {
		
		public $helpers = array('form');
		
		protected $requireHttps = true;
		
		
		public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
			parent::on_start();
		}
		
		
		public function on_before_render(){
			// never send back the credit card
			$_POST['card_number'] = false;
		}
		
		
		public function process(){
			// run the transaction
			$transaction = new ClinicaTransaction( $_POST, ClinicaTransaction::TYPE_DONATION );
			
			// should exit after this
			if( $transaction->result() ){
				$transaction->saveRecord();
				$this->respond(true, 'Success! Thank you for supporting Clinica.');
				return;
			}
			
			// if we get here, it failed
			$this->respond(false, $transaction->responseMessageText());
		}
		
		
		protected function respond( $okOrFail, $message ){
			$accept = explode( ',', $_SERVER['HTTP_ACCEPT'] );
			$accept = array_map('trim', $accept);
			
			
			// send back a JSON response
			if( in_array($accept[0], array('application/json', 'text/javascript')) || $_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest'){
				header('Content-Type: application/json');
				echo json_encode( (object) array(
					'code'		=> (int) $okOrFail,
					'messages'	=> array($message)
				));
				exit;
			}

			// somehow a plain old html browser request got through, redirect it
			$this->flash( $message, ((bool)$okOrFail === true ? self::FLASH_TYPE_OK : self::FLASH_TYPE_ERROR) );
			$this->redirect('/giving');
			
		}
		
	}
