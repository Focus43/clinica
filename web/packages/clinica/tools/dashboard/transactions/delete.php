<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/transactions') );
	
	// does caller of this URL have access?
	if( $permissions->canViewPage() ){
        try {
            if(!empty($_POST['transactionID'])){
                foreach($_POST['transactionID'] AS $transactionID){
                    ClinicaTransaction::getByID($transactionID)->delete();
                }
            }

            // Show success
            echo Loader::helper('json')->encode( (object) array(
                'code'	=> 1,
                'msg'	=> 'Success'
            ));
        }catch(Exception $e){
            echo Loader::helper('json')->encode( (object) array(
                'code'  => 0,
                'msg'   => $e->getMessage()
            ));
        }
	}