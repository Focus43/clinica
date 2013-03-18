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
			<div class="masonryItem masonryItem-<?php echo $controller->bID; ?>" data-file-id="<?php echo $fileObj->getFileID(); ?>">
				<?php
					$urlPath = Page::getByID( $fileObj->getAttribute('page_link') )->getCollectionPath();
					if( !empty($urlPath) ){
						echo '<a class="masonryInner" href="'.$this->url($urlPath).'">';
					}else{
						echo '<a class="masonryInner">';
					}
					
					$imageHelper->outputThumbnail($fileObj, $controller->maxWidth, 0);
					if( (bool) $controller->showTitleOverlay ){
						echo '<span class="titleOverlay">'.$fileObj->getTitle().'</span>';
					}
				?>
				</a>
			</div>
		<?php } ?>
	</div>
	
	<script type="text/javascript">
		$(function(){
			// initialize masonry layout
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
			
			function updateImageSrc( $modal, fileID, onComplete ){
				$.get('<?php echo $controller->getBlockToolsURL('resized_src'); ?>', {fileID: fileID}, function( data ){
					$('img', $modal).attr('src', data.src);
					if( $.isFunction(onComplete) ){
						onComplete();
					}  
				}, 'json');
			}
			
			// modal gallery
			$('.masonryItem-<?php echo $controller->bID; ?>').on('click', function(){
				var $this  = $(this),
					$modal = $('#masonryModal-<?php echo $controller->bID; ?>'),
					fileID = $this.attr('data-file-id');
					
				$this.addClass('active').siblings('.masonryItem').removeClass('active');
					
				if( !$modal.length ){
					$.get('<?php echo $controller->getBlockToolsURL('modal'); ?>', {fileID: fileID, bID: <?php echo $controller->bID; ?>}, function( html ){
						$(html).modal();
					}, 'html');
				}else{
					updateImageSrc($modal, fileID, function(){
						$modal.modal();
					});
				}
			});
			
			$(document).on('click', '#masonryModal-<?php echo $controller->bID; ?> a.carousel-control', function(){
				var $clicked = $(this),
					$modal	 = $('#masonryModal-<?php echo $controller->bID; ?>'),
					$current = $('.masonryItem.active', '#masonryBlock-<?php echo $controller->bID; ?>');
				
				// going back?
				if( $clicked.hasClass('left') ){
					var $target = $current.prev('.masonryItem');
				}else{
					var $target = $current.next('.masonryItem');
				}
				
				// set as the new active one
				$target.addClass('active').siblings('.masonryItem').removeClass('active');
				
				// nope, going forward...
				updateImageSrc($modal, $target.attr('data-file-id'));
			});
		});
	</script>
