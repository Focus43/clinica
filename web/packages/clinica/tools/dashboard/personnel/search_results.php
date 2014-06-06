<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/personnel') );
	
	if( $permissions->canViewPage() ){
		$controller  = Loader::controller('/dashboard/clinica/personnel/search');
		$listObject  = $controller->personnelListObj();
		$listResults = $listObject->getPage();

		Loader::packageElement('dashboard/personnel/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		));
	}