<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

	<style type="text/css">
		.masonryItem-<?php echo $controller->bID; ?> {width:<?php echo $controller->maxWidth; ?>px;}
	</style>

	<div id="masonryBlock-<?php echo $controller->bID; ?>" class="masonryContainer clearfix">
		<?php foreach($imagesList AS $fileObj){ ?>
			<div class="masonryItem masonryItem-<?php echo $controller->bID; ?>">
				<div class="masonryInner">
					<?php 
						$imageHelper->outputThumbnail($fileObj, $controller->maxWidth, 0);
						if( (bool) $controller->showTitleOverlay ){
							echo '<span class="titleOverlay">'.$fileObj->getTitle().'</span>';
						}
					?>
				</div>
			</div>
		<?php } ?>
	</div>
	
	<script type="text/javascript">
		$(function(){
			var $masonryContainer = $('#masonryBlock-<?php echo $controller->bID; ?>');
			$masonryContainer.imagesLoaded(function(){
				$masonryContainer.masonry({
					itemSelector: '.masonryItem',
					columnWidth: <?php echo $controller->maxWidth + 32; ?>,
					isAnimated: (typeof(Modernizr) !== 'undefined' ? !Modernizr.csstransitions : true),
					animationOptions: {
						duration: 500,
						easing: 'linear',
						queue: false
					}
				});
			});
		});
	</script>
