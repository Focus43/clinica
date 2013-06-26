<?php defined('C5_EXECUTE') or die("Access Denied.");

	$chunks = array_chunk($imagesList, 1); ?>

	<style type="text/css">
		#carousel-<?php echo $controller->bID; ?> {height:240px;padding:0;}
		#carousel-<?php echo $controller->bID; ?> .carousel-inner,
		#carousel-<?php echo $controller->bID; ?> .carousel-inner div.item {height:240px;text-align:center;}
		#carousel-<?php echo $controller->bID; ?> .boxedImage {position:relative;top:48%;}
		#carousel-<?php echo $controller->bID; ?> .carousel-control {top:50%;}
		#carousel-<?php echo $controller->bID; ?> .carousel-control.left {left:3px;}
		#carousel-<?php echo $controller->bID; ?> .carousel-control.right {right:3px;}
	</style>

	<div id="carousel-<?php echo $controller->bID; ?>" class="carousel slide well well-small">
		<!--<ol class="carousel-indicators">
			<?php for( $i = 0; $i <= count($chunks); $i++ ): ?>
				<li data-target="#carousel-<?php echo $controller->bID; ?>" data-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>"></li>
			<?php endfor; ?>
		</ol>-->
		<div class="carousel-inner">
			<?php foreach( $chunks AS $index => $setOfThree ){ ?>
				<div class="<?php echo t('%s', $index === 0 ? 'item active' : 'item'); ?>">
					<?php foreach($setOfThree AS $fileObj):
						$image = $controller->getHelper('image')->getThumbnail($fileObj,250,200); ?>
						<span class="boxedImage" style="margin-top:-<?php echo round($image->height / 2); ?>px;">
							<img src="<?php echo $image->src; ?>" />
						</span>
					<?php endforeach; ?>
				</div>
			<?php } ?>
		</div>
		<!-- Carousel nav -->
		<a class="carousel-control left" href="#carousel-<?php echo $controller->bID; ?>" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#carousel-<?php echo $controller->bID; ?>" data-slide="next">&rsaquo;</a>
	</div>

	<script type="text/javascript">
		$(function(){
			$('#carousel-<?php echo $controller->bID; ?>').carousel({
				interval: 2200
			});
		});
	</script>
