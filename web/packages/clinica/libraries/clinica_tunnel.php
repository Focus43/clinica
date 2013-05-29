<?php

    class ClinicaTunnel {
        
        private $transactions;
        
        public function __construct( array $transactions ){
            if( !empty($transactions) ){
                $this->transactions = $transactions;
                return;
            }
            
            // if $transactions is empty, throw exception
            throw new Exception('No transactions were selected to be reconciled.');
        }
        
        
        public function send(){
            
        }
        
    }
