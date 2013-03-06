<?php

	class ClinicaTransaction {
		
		private $data,
				$transactionType,
				$response;
				
		
		const TYPE_DONATION = 'donation',
			  TYPE_BILL_PAY = 'bill_payment';
		
		
		/**
		 * Helper to easily render list of available card types
		 */
		public static $cardTypes = array(
			''				=> 'Type',
			'visa' 			=> 'Visa',
			'mastercard'	=> 'Mastercard'
		);
		
		
		/**
		 * Helper to render expiration months
		 */
		public static function expiryMonths(){
			$months = array_combine(range(1,12),range(1,12));
			return (array('' => 'Month') + $months);
		}
		
		
		/**
		 * Helpers for expiration years
		 */
		public static function expiryYears(){
			$curYear = (int) date('Y');
			$inEight = $curYear + 8;
			$years = array_combine(range($curYear, $inEight),range($curYear, $inEight));
			return (array('' => 'Year') + $years);
		}
		
		
		/**
		 * Run a transaction against authorize.net. Always use this class so its
		 * properly processed and logged to the database.
		 * @param array $data ['amount', 'card_number', 'exp_month', 'exp_year']; usually $_POST
		 */
		public function __construct( array $data, $transactionType ){
			$this->data 			= $data;
			$this->transactionType 	= $transactionType;
			$this->response 		= $this->preValidate()->authorizeNetObj()->authorizeAndCapture();
		}
		
		
		/**
		 * Was the transaction successful or not?
		 * @return bool True on success, false on failure
		 */
		public function result(){
			return (bool) $this->response->approved;
		}
		
		
		/**
		 * Log the transaction, according to its type (eg. donation, bill_payment). Tests
		 * for if null to make sure the record is only saved once.
		 * @param string
		 * @return void
		 */
		public function saveRecord(){
			if( $this->_hasBeenSaved === null ){
				
				$this->_hasBeenSaved = true;
			}
			return $this->_hasBeenSaved;
		}
		
		
		/**
		 * Do any validation stuff.
		 * @return ClinicaTransaction
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
			}
			return $this->_authNetObj;
		}
		
	}
