<?php defined('C5_EXECUTE') or die("Access Denied.");

	class GivingController extends ClinicaPageController {
		
		public $helpers = array('form');
		
		protected $requireHttps = true;
        protected $includeThemeAssets = true;
		
		
		public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
			$this->set('transactionHelper', Loader::helper('clinica_transaction', 'clinica'));
			parent::on_start();
		}
        
        
        public function test_mode(){
            $this->addFooterItem( $this->getHelper('html')->javascript('test_helpers/giving.js', self::PACKAGE_HANDLE) );
        }
		
		
		public function process(){
			// first, validate all the form data not checked by auth.net
			if( !$this->validator()->test() ){
				$this->formResponder(false, $this->validator()->getError()->getList());
				return;
			}
			
			// run the transaction
			$transactionHandler = new ClinicaTransactionHandler( $_POST, ClinicaTransaction::TYPE_DONATION );
            $transactionHandler->setMailTemplate('donation');
            $transactionHandler->execute();
			
			// should exit after this
			if( (bool) $transactionHandler->getAuthnetResponse()->approved ){
				$this->formResponder(true, 'Thank you for supporting Clinica! A receipt has been sent to your email address.');
				return;
			}
			
			// if we get here, it failed
			$this->formResponder(false, $transactionHandler->getAuthnetResponse()->response_reason_text);
		}
		
		
		/**
		 * Setup the validator, but *don't* execute the test() method yet
		 * @return ValidationFormHelper
		 */
		protected function validator(){
			if( $this->_formValidator === null ){
				$this->_formValidator = Loader::helper('validation/form');
				$this->_formValidator->setData( $_POST );
				$this->_formValidator->addRequiredEmail('email', 'A valid email address is required.');
				$this->_formValidator->addRequired('firstName', 'Missing required field first name.');
				$this->_formValidator->addRequired('lastName', 'Missing required field last name.');
				$this->_formValidator->addRequired('address1', 'Missing required field address 1.');
				$this->_formValidator->addRequired('city', 'Missing required field city.');
				$this->_formValidator->addRequired('state', 'Missing required field state.');
				$this->_formValidator->addRequired('zip', 'Missing required field zip.');
                
                // if minimum amount is set in dashboard clinica config...
                $minTrxnAmount = (int) Config::get('CLINICA_TRXN_MINIMUM_AMOUNT');
                if( $minTrxnAmount > 0 ){
                    $this->_formValidator->addRequiredMinimum('amount', $minTrxnAmount, t('The minimum donation amount is $%s', $minTrxnAmount));
                }
			}
			return $this->_formValidator;
		}
		
	}
