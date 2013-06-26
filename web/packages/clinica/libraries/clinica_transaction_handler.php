<?php

	/**
	 * All this class does is (basically) wrap the AuthorizeNet AIM api, and bundle in some
	 * validation and persistence of records (via the ClinicaTransaction class).
	 */
	class ClinicaTransactionHandler {
		
		private $data,
				$transactionType,
				$response;
		
		
		/**
		 * Run a transaction against authorize.net. Always use this class so its
		 * properly processed and logged to the database.
		 * @param array $data ['amount', 'card_number', 'exp_month', 'exp_year']; usually $_POST
		 */
		public function __construct( array $data, $transactionType ){
			$this->data 			= $data;
			$this->transactionType 	= $transactionType;
			$this->response 		= $this->preValidate()->authorizeNetObj()->authorizeAndCapture();
			$this->onSuccess();
		}
		
		
		/**
		 * Was the transaction successful or not?
		 * @return AuthorizeNetAIM_Response object
		 */
		public function getResponse(){
			return $this->response;
		}
		
		
		/**
		 * Log the transaction, according to its type (eg. donation, bill_payment). Tests
		 * for if null to make sure the record is only saved once.
		 * @param string
		 * @return void
		 */
		private function onSuccess(){
			// if payment processed ok...
			if( (bool) $this->response->approved ){
				$data = $this->data;
				$data['typeHandle']					= $this->transactionType;
				$data['authNetResponseCode'] 		= $this->response->response_code;
				$data['authNetAuthorizationCode']	= $this->response->authorization_code;
				$data['authNetAvsResponse']			= $this->response->avs_response;
				$data['authNetTransactionID']		= $this->response->transaction_id;
				$data['authNetMethod']				= $this->response->method;
				$data['authNetTransactionType']		= $this->response->transaction_type;
				$data['authNetMd5Hash']				= $this->response->md5_hash;
				$data['cardLastFour']				= substr( preg_replace('/[^0-9]/', '', $this->data['card_number']), -4 );
				$data['cardExpMonth']				= $this->data['exp_month'];
				$data['cardExpYear']				= $this->data['exp_year'];
				
				// unset unused data
				unset($data['card_number']);
				unset($data['card_type']);
				unset($data['exp_month']);
				unset($data['exp_year']);
				
				// create the transaction record, then save it
				$transaction = new ClinicaTransaction($data);
				$transaction = $transaction->save();
				
				// send mail receipt
				$mailHelper = Loader::helper('mail');
				$mailHelper->to($transaction->getEmail());
				$mailHelper->from(OUTGOING_MAIL_ISSUER_ADDRESS);
				$mailHelper->addParameter('transaction', $transaction);
				$mailHelper->addParameter('amount', number_format($transaction->getAmount(), 2));
				$mailHelper->load('transaction', 'clinica');
				$mailHelper->sendMail();
			}
		}
		
		
		/**
		 * Do any validation stuff.
		 * @return ClinicaTransactionHandler
		 */
		private function preValidate(){
			return $this;
		}
		
		
		/**
		 * Get, or setup for the first time the authorize.net transaction class.
		 * @return AuthorizeNetAIM
		 */
		private function authorizeNetObj(){
			if( $this->_authNetObj === null ){
				$this->_authNetObj = new AuthorizeNetAIM;
				$this->_authNetObj->amount 		= $this->data['amount'];
				$this->_authNetObj->card_num	= $this->data['card_number'];
				$this->_authNetObj->exp_date	= "{$this->data['exp_month']}/{$this->data['exp_year']}";
				$this->_authNetObj->first_name	= $this->data['firstName'];
				$this->_authNetObj->last_name	= $this->data['lastName'];
				$this->_authNetObj->address		= $this->data['address1'];
				$this->_authNetObj->city		= $this->data['city'];
				$this->_authNetObj->state		= $this->data['state'];
				$this->_authNetObj->zip			= $this->data['zip'];
				$this->_authNetObj->phone		= $this->data['phone'];
				$this->_authNetObj->email		= $this->data['email'];
			}
			return $this->_authNetObj;
		}
		
	}
