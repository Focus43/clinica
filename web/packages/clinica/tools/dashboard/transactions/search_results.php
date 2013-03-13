<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/transactions') );
	
	if( $permissions->canView() ){
		$controller  = Loader::controller('/dashboard/clinica/transactions/search');
		$listObject  = $controller->transactionListObj();
		$listResults = $listObject->getPage();
		
		Loader::packageElement('dashboard/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		));
	}