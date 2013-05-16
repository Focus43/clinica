<div class="masonryItem <?php echo $controller->getItemClass(); ?>" data-original="<?php echo $fileObj->getRelativePath(); ?>" data-file-id="<?php echo $fileObj->getFileID(); ?>" data-sets="<?php echo $controller->getFileSetsString($fileObj); ?>">
	<div class="masonryInner">
		<?php
			$controller->getHelper('image')->outputThumbnail($fileObj, $controller->maxWidth, 0);
			
			if( (bool) $controller->showTitleOverlay ){
				echo '<span class="titleOverlay">'.$fileObj->getTitle().'</span>';
			}
			
			$description = $fileObj->getDescription();
			if( !empty($description) ){
				echo t('<p>%s</p>', $controller->getHelper('text')->autolink( $description, true ));
			}
		?>
	</div>
</div>