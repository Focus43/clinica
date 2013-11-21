<?php

	/**
	 * All this class does is (basically) wrap the AuthorizeNet AIM api, and bundle in some
	 * validation and persistence of records (via the ClinicaTransaction class).
	 */
	class ClinicaTransactionHandler {
		
		private $data, $transactionType;
		
		
		/**
		 * Prepare an authorize.net transactions. Always use this class so its
		 * properly processed and logged to the database.
		 * @param array $data ['amount', 'card_number', 'exp_month', 'exp_year']; usually $_POST
		 */
		public function __construct( array $data, $transactionType ){
			$this->data 			= $data;
			$this->transactionType 	= $transactionType;

		}


        /**
         * Pass a string representing the name of the mail template to use.
         * @param $templateHandle
         */
        public function setMailTemplate( $templateHandle ){
            $this->_emailTemplateHandle = $templateHandle;
        }


        /**
         * Execute the transaction. This should only occur after a mail template has been set.
         */
        public function execute(){
            $this->_authNetResponse = $this->preValidate()->authorizeNetObj()->authorizeAndCapture();
            $this->onComplete();
        }
		
		
		/**
		 * Was the transaction successful or not? This is the response data from the AUTHORIZE.NET
         * API!
		 * @return AuthorizeNetAIM_Response object
		 */
		public function getAuthnetResponse(){
			return $this->_authNetResponse;
		}


        /**
         * Get the object as it was persisted to the database!
         * @return ClinicaTransaction
         */
        public function getTransactionRecordObj(){
            return $this->_transactionRecordObj;
        }
		
		
		/**
		 * Log the transaction to the database, according to its type (eg. donation, bill_payment),
         * and take care of issuing an email. Tests for if null to make sure the record is only saved once.
		 * @param string
		 * @return void
		 */
		private function onComplete(){
			// if payment processed ok...
			if( (bool) $this->_authNetResponse->approved ){
				$data = $this->data;
				$data['typeHandle']					= $this->transactionType;
				$data['authNetResponseCode'] 		= $this->_authNetResponse->response_code;
				$data['authNetAuthorizationCode']	= $this->_authNetResponse->authorization_code;
				$data['authNetAvsResponse']			= $this->_authNetResponse->avs_response;
				$data['authNetTransactionID']		= $this->_authNetResponse->transaction_id;
				$data['authNetMethod']				= $this->_authNetResponse->method;
				$data['authNetTransactionType']		= $this->_authNetResponse->transaction_type;
				$data['authNetMd5Hash']				= $this->_authNetResponse->md5_hash;
				$data['cardLastFour']				= substr( preg_replace('/[^0-9]/', '', $this->data['card_number']), -4 );
				$data['cardExpMonth']				= $this->data['exp_month'];
				$data['cardExpYear']				= $this->data['exp_year'];
				
				// unset unused data
				unset($data['card_number']);
				unset($data['card_type']);
				unset($data['exp_month']);
				unset($data['exp_year']);
				
				// create the transaction record, then save it and set it as a class property
				$this->_transactionRecordObj = new ClinicaTransaction($data);
                $this->_transactionRecordObj = $this->_transactionRecordObj->save();
				
				// send mail receipt
                $this->issueEmail($this->_transactionRecordObj);
			}
		}


        /**
         * Issue an outgoing email. This depends on a template being set; if its not, just
         * log some of the details to the standard C5 log.
         * @param ClinicaTransaction $transactionRecord
         * @return void
         */
        private function issueEmail( ClinicaTransaction $transactionRecord ){
            if( $this->_emailTemplateHandle === null ){
                $logger = new Log('transaction', true);
                $logger->write('TRANSACTION OCCURRED WITH NO EMAIL RECEIPT SENT:');
                $logger->write("To: {$transactionRecord->firstName} {$transactionRecord->lastName}");
                $logger->write("Email: {$transactionRecord->email}");
                $logger->write("Phone: {$transactionRecord->phone}");
                $logger->write("Amount: {$transactionRecord->amount}");
                $logger->write("Type: {$transactionRecord->typeHandle}");
                $logger->close();
                return;
            }

            // if we get here, template handle is available so run it
            $mailerObj = Loader::helper('mail');
            $mailerObj->to( $transactionRecord->getEmail() );
            $mailerObj->from(OUTGOING_MAIL_ISSUER_ADDRESS);
            $mailerObj->addParameter('transaction', $transactionRecord);
            $mailerObj->load( $this->_emailTemplateHandle, 'clinica' );
            $mailerObj->sendMail();
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
