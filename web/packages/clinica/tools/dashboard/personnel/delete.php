<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/personnel') );
	
	// does caller of this URL have access?
	if( $permissions->canViewPage() ){
		if(!empty($_POST['personnelID'])){
			foreach($_POST['personnelID'] AS $personnelID){
				ClinicaPersonnel::getByID($personnelID)->delete();
			}
		}
		
		echo Loader::helper('json')->encode( (object) array(
			'code'	=> 1,
			'msg'	=> 'Success'
		));
	}