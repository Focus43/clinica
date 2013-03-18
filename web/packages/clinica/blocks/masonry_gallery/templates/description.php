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

	<div id="masonryBlock-<?php echo $controller->bID; ?>" class="masonryContainer clearfix">
		<?php foreach($imagesList AS $fileObj){ ?>
			<div class="masonryItem masonryItem-<?php echo $controller->bID; ?>">
				<?php
					$urlPath = Page::getByID( $fileObj->getAttribute('page_link') )->getCollectionPath();
					echo t('<a class="masonryInner" href="%s">', (!empty($urlPath) ? $urlPath : 'javascript:void(0)'));
					
					$imageHelper->outputThumbnail($fileObj, $controller->maxWidth, 0);
					
					if( (bool) $controller->showTitleOverlay ){
						echo '<span class="titleOverlay">'.$fileObj->getTitle().'</span>';
					}
					
					echo '</a>';
				?>
			</div>
		<?php } ?>
	</div>
	
	<script type="text/javascript">
		$(function(){
			if( $.isFunction( $.fn.masonry ) ){
				var $masonryContainer = $('#masonryBlock-<?php echo $controller->bID; ?>');
				$masonryContainer.imagesLoaded(function(){
					$masonryContainer.masonry({
						itemSelector: '.masonryItem',
						columnWidth: <?php echo $controller->maxWidth + ($controller->margin * 2) + ($controller->padding * 2); ?>,
						isAnimated: (typeof(Modernizr) !== 'undefined' ? !Modernizr.csstransitions : true),
						animationOptions: {
							duration: 500,
							easing: 'linear',
							queue: false
						}
					});
				});
			}
		});
	</script>
