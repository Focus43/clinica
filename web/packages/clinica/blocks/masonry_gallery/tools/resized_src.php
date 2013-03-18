<?php defined('C5_EXECUTE') or die("Access Denied.");

	$fileObj	 = File::getByID( $_REQUEST['fileID'] );
	$imageObj	 = Loader::helper('image')->getThumbnail($fileObj, 800, 600);

	echo Loader::helper('json')->encode( (object) array(
		'code'		=> 1,
		'src'   	=> $imageObj->src,
		'width' 	=> $imageObj->width,
		'height'	=> $imageObj->height
	));
