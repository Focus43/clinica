<?php

	/** @var $block MasonryGalleryBlockController */
	$block 		= Block::getByID( $_REQUEST['blockID'] )->getInstance();
	$listObj 	= $block->masonryFileList();
	$results	= $listObj->get($block->pagingResults, ((int)$_REQUEST['offset'] * $block->pagingResults));

	// output results
	foreach($results AS $fileObj){
		Loader::packageElement('masonry_brick', 'masonry_grid', array(
			'fileObj' 		=> $fileObj, 
			'controller' 	=> $block
		));
	}
