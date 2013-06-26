<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

	<style type="text/css">
		#masonryBlock-<?php echo $controller->bID; ?> {
			position:relative;
			left: -<?php echo $controller->margin; ?>px;
		}
		.masonryItem-<?php echo $controller->bID; ?> {
			width: <?php echo $controller->maxWidth; ?>px;
			margin: <?php echo $controller->margin; ?>px;
			padding: <?php echo $controller->padding; ?>px; 
		}
	</style>

	<?php if( (bool) $controller->showFileSetFilters ): ?>
		<ul id="<?php echo $controller->getFilterListID(); ?>" class="nav nav-pills">
			<li class="active"><a data-set-handle="__all__" data-toggle="pill">All</a></li>
			<?php foreach($fileSetObjects AS $fileSetObj): ?>
				<li><a data-toggle="pill" data-set-handle="<?php echo $textHelper->handle($fileSetObj->getFileSetName()); ?>"><?php echo $fileSetObj->getFileSetName(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<div id="<?php echo $controller->getContainerID(); ?>" class="masonryContainer clearfix">
		<?php foreach($imagesList AS $fileObj){
			Loader::packageElement('masonry_brick', 'masonry_grid', array(
				'fileObj' 		=> $fileObj, 
				'controller' 	=> $controller
			));
		} ?>
	</div>
	
	<script type="text/javascript">
		$(function(){
			new C5Masonry({
				blockID: <?php echo $controller->bID; ?>,
				containerID: '#<?php echo $controller->getContainerID(); ?>',
				itemClass: '.<?php echo $controller->getItemClass(); ?>',
				columnWidth: <?php echo $controller->getColumnWidth(); ?>,
				setFiltersID: '#<?php echo $controller->getFilterListID(); ?>',
				toolsURL: '<?php echo MASONRY_TOOLS_URL; ?>',
				enableModals: <?php echo (bool) $controller->enableModals ? 'true' : 'false'; ?>
			});
		});
	</script>
