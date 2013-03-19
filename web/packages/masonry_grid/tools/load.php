<?php

	/** @var $block MasonryGalleryBlockController */
	$block 		= Block::getByID( $_REQUEST['blockID'] )->getInstance();
	$listObj 	= $block->masonryFileList();
	$results	= $listObj->get(20, ((int)$_REQUEST['offset'] * 20));

	// output results
	foreach($results AS $fileObj){
		Loader::packageElement('masonry_brick', 'masonry_grid', array(
			'fileObj' 		=> $fileObj, 
			'controller' 	=> $block
		));
	}
