<?php defined('C5_EXECUTE') or die("Access Denied.");

    $permissions = new Permissions( Page::getByPath('/dashboard/clinica/transactions') );

    try {
        // does caller of this URL have access?
        if( $permissions->canViewPage() ){
            $transactionsList = array();
            
            // load the transactions into the array
            if(!empty($_POST['transactionID'])){
                foreach($_POST['transactionID'] AS $transactionID){
                    $transactionsList[] = ClinicaTransaction::getByID($transactionID);
                }
            }
            
            // send to Clinica
            $secureTunnel = new ClinicaTunnel( $transactionsList );
            $secureTunnel->send();
            
            // if we get here, it all worked like a charm
            echo Loader::helper('json')->encode( (object) array(
                'code'  => 1,
                'msg'   => 'Completed OK'
            ));
        
        // caller of the URL doesn't have permission to perform action
        }else{
            throw new Exception('Insufficient permissions');
        }
        
    }catch(Exception $e){
        echo Loader::helper('json')->encode( (object) array(
            'code'  => 0,
            'msg'   => $e->getMessage()
        ));
    }