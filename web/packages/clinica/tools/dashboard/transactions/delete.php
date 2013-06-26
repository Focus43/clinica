<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/transactions') );
	
	// does caller of this URL have access?
	if( $permissions->canViewPage() ){
		if(!empty($_POST['transactionID'])){
			foreach($_POST['transactionID'] AS $transactionID){
				ClinicaTransaction::getByID($transactionID)->delete();
			}
		}
		
		echo Loader::helper('json')->encode( (object) array(
			'code'	=> 1,
			'msg'	=> 'Success'
		));
	}