<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/patients') );
	
	if( $permissions->canViewPage() ){
		$controller  = Loader::controller('/dashboard/clinica/patients');
		$listObject  = $controller->patientListObj();
		$listResults = $listObject->getPage();

		Loader::packageElement('dashboard/patients/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		));
	}