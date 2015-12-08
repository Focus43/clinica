<?php defined('C5_EXECUTE') or die("Access Denied.");

	class DashboardClinicaTransactionsController extends ClinicaPageController {
	
        protected $requireHttps = true;
    
        
        /**
         * @return void
         */
		public function view( $id = null ) {
			// viewing a specific transaction
			if( !is_null($id) && ((int) $id >= 1) ){
				$this->addHeaderItem(Loader::helper('html')->css('clinica.dashboard.css', 'clinica'));
				$transactionObj = ClinicaTransaction::getByID($id);
				$this->set('transactionObj', $transactionObj);
				$this->set('attributeKeys', AttributeSet::getByHandle($transactionObj->getTypeHandle())->getAttributeKeys() );
				return;
			}
			
			// just redirecting to the search page
			$this->redirect('/dashboard/clinica/transactions/search');
		}
		
		
        /**
         * /add Action. Displays the form to manually add a transaction.
         * @return void
         */
		public function add(){
		    Loader::helper('clinica_transaction', 'clinica');
		    $this->set('form', $this->getHelper('form'));
            $this->addHeaderItem($this->getHelper('html')->css('clinica.dashboard.css', 'clinica'));
            $this->addFooterItem($this->getHelper('html')->javascript('libs/ajaxify.form.js', 'clinica'));
            $this->addFooterItem($this->getHelper('html')->javascript('dashboard/app.dashboard.js', 'clinica'));
            
			parent::render("{$this->c->cPath}/{$this->getTask()}");
		}
        
        
        /**
         * Process the transaction: should only be accessed via POST. Renders a
         * JSON formatted response.
         * @return void
         */
        public function create(){
            // first, validate all the form data not checked by auth.net
            if( !$this->validator()->test() ){
                $this->formResponder(false, $this->validator()->getError()->getList());
                return;
            }

            // run the transaction
            $userObj        = new User;
            $data           = $_POST;
            $data['userID'] = $userObj->getUserID();
            $transactionHandler = new ClinicaTransactionHandler( $data, $_POST['typeHandle'] );
            $transactionHandler->setMailTemplate( $_POST['typeHandle'] );
            $transactionHandler->execute();

            // should exit after this
            if( (bool) $transactionHandler->getAuthnetResponse()->approved ){
                $this->formResponder(true, 'Success! Your payment has been received by Clinica.');
                return;
            }
            
            // if we get here, it failed
            $this->formResponder(false, $transactionHandler->getAuthnetResponse()->response_reason_text);
        }
        
        
        /**
         * Validate all the input fields (make sure everything required is present and ok),
         * before passing the data to the transaction handler.
         * @return ValidationFormHelper
         */
        private function validator(){
            if( $this->_formValidator === null ){
                $this->_formValidator = $this->getHelper('validation/form');
                $this->_formValidator->setData( $_POST );
                $this->_formValidator->addRequired('typeHandle', 'A transaction type must be selected.');
                //$this->_formValidator->addRequiredEmail('email', 'A valid email address is required.');
                $this->_formValidator->addRequired('firstName', 'Missing required field first name.');
                $this->_formValidator->addRequired('lastName', 'Missing required field last name.');
                $this->_formValidator->addRequired('address1', 'Missing required field address 1.');
                $this->_formValidator->addRequired('city', 'Missing required field city.');
                $this->_formValidator->addRequired('state', 'Missing required field state.');
                $this->_formValidator->addRequired('zip', 'Missing required field zip.');
                
                if( $_POST['typeHandle'] == ClinicaTransaction::TYPE_BILL_PAY ){
                    $this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('clinica_account_number'));
                    $this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_first_name'));
                    $this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_last_name'));
                    $this->_formValidator->addRequiredAttribute(ClinicaTransactionAttributeKey::getByHandle('patient_birthdate'));
                }
                
                // since this is being processed in the dashboard, we don't validate for minimum
                // transaction amount (would normally go here)
            }
            return $this->_formValidator;
        }
	
	}