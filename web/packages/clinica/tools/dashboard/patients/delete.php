<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/patients') );
	
	// does caller of this URL have access?
	if( $permissions->canViewPage() ){
		if(!empty($_POST['patientID'])){
			foreach($_POST['patientID'] AS $patientID){
				ClinicaPatient::getByID($patientID)->delete();
			}
		}
		
		echo Loader::helper('json')->encode( (object) array(
			'code'	=> 1,
			'msg'	=> 'Success'
		));
	}