<?php

    class DashboardClinicaSettingsController extends Controller {
        
        public function on_start(){
            $this->set('formHelper', Loader::helper('form'));
            $this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
        }
        
        
        public function save_ecommerce_settings(){
            Config::save('CLINICA_TRXN_MINIMUM_AMOUNT', (int) $_POST['CLINICA_TRXN_MINIMUM_AMOUNT']);
        }
        
    }
