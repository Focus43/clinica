<?php defined('C5_EXECUTE') or die("Access Denied.");

	$permissions = new Permissions( Page::getByPath('/dashboard/clinica/transactions') );
	
	if( $permissions->canViewPage() ){
		$controller  = Loader::controller('/dashboard/clinica/transactions/search');
		$listObject  = $controller->transactionListObj();
		$listResults = $listObject->getPage();
		
		Loader::packageElement('dashboard/transactions/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		));
	}