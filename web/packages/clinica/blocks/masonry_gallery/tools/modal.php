<?php defined('C5_EXECUTE') or die("Access Denied.");
	$imageHelper = Loader::helper('image');
	$fileObj	 = File::getByID( $_REQUEST['fileID'] );
?>

<div id="masonryModal-<?php echo $_REQUEST['bID']; ?>" class="modal hide fade masonryModal" tab-index="-1" role="dialog">
	<div class="modal-header">
		<h4>Large Image View</h4>
	</div>
	<div class="modal-body">
		<a class="carousel-control left">&lsaquo;</a>
		<a class="carousel-control right">&rsaquo;</a>
		<img src="<?php echo $imageHelper->getThumbnail($fileObj, 800, 600)->src; ?>" />
	</div>
	<div class="modal-footer">
		<p><?php echo Loader::helper('text')->autolink( $fileObj->getDescription(), true ); ?></p>
	</div>
</div>
