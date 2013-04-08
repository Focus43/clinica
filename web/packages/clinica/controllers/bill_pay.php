<?php

	class BillPayController extends ClinicaPageController {
		
		public $helpers = array('form');
		
		protected $requireHttps = true;
		
		
		public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
			$this->set('transactionHelper', Loader::helper('clinica_transaction', 'clinica'));
			parent::on_start();
		}
		
		
		public function view(){
			$attrKeysList = AttributeSet::getByHandle(ClinicaTransaction::TYPE_BILL_PAY)->getAttributeKeys();
			
			// extract the account number attribute key first
			$acctAttrKey = array_filter($attrKeysList, function($attrKey){
				if( $attrKey->akHandle == 'clinica_account_number' ){
					return true;
				}
			});
			
			// pass to the view
			$this->set('accountAttrKey', $acctAttrKey[0]);
			
			// unset it from keys list
			if( ($key = array_search($acctAttrKey[0], $attrKeysList)) !== false ){
				unset($attrKeysList[$key]);
			}
			
			// pass rest of keys list to the view
			$this->set('attrKeysList', $attrKeysList);
		}
		
		
		public function process(){
			// first, validate all the form data not checked by auth.net
			if( !$this->validator()->test() ){
				$this->formResponder(false, $this->validator()->getError()->getList());
				return;
			}
			
			// run the transaction
			$transaction = new ClinicaTransactionHandler( $_POST, ClinicaTransaction::TYPE_BILL_PAY );
			
			// should exit after this
			if( (bool) $transaction->getResponse()->approved ){
				$this->formResponder(true, 'Success! Your payment has been received by Clinica.');
				return;
			}
			
			// if we get here, it failed
			$this->formResponder(false, $transaction->getResponse()->response_reason_text);
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
				
				// validating attribute fields
				$this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('clinica_account_number'));
				$this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_first_name'));
				$this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_last_name'));
				$this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_birthdate'));
                
                // if minimum amount is set in dashboard clinica config...
                $minTrxnAmount = (int) Config::get('CLINICA_TRXN_MINIMUM_AMOUNT');
                if( $minTrxnAmount > 0 ){
                    $this->_formValidator->addRequiredMinimum('amount', $minTrxnAmount, t('The minimum payment amount is $%s', $minTrxnAmount));
                }
			}
			return $this->_formValidator;
		}
		
	}
