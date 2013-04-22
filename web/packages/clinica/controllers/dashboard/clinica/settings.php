<?php

    class DashboardClinicaSettingsController extends Controller {
        
        const PACKAGE_HANDLE    = 'clinica',
              FLASH_TYPE_OK     = 'success',
              FLASH_TYPE_ERROR  = 'error';
        
        /**
         * Ruby on Rails "flash" functionality ripoff.
         * @param string $msg Optional, set the flash message
         * @param string $type Optional, set the class for the alert
         * @return void
         */
        public function flash( $msg = 'Success', $type = self::FLASH_TYPE_OK ){
            $_SESSION['flash_msg'] = array(
                'msg'  => $msg,
                'type' => $type
            );
            
            return $this;
        }
        
        
        public function on_start(){
            $this->set('formHelper', Loader::helper('form'));
            $this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', self::PACKAGE_HANDLE));
            
            // message flash
            if( isset($_SESSION['flash_msg']) ){
                $this->set('flash', $_SESSION['flash_msg']);
                unset($_SESSION['flash_msg']);
            }
        }
        
        
        public function save_ecommerce_settings(){
            Config::save('CLINICA_TRXN_MINIMUM_AMOUNT', (int) $_POST['CLINICA_TRXN_MINIMUM_AMOUNT']);
            // respond
            $this->flash('E-commerce settings saved!')
                 ->redirect('dashboard/clinica/settings');
        }
        
    }
