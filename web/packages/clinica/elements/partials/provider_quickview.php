<a class="provider clearfix" href="<?php echo $this->action('profile', $personnelObj->getPersonnelID()); ?>" data-name="<?php echo "{$personnelObj->getFirstName()} {$personnelObj->getLastName()}"; ?>">
	<?php if( $personnelObj->getPictureFileObj()->getFileID() >= 1 ): ?>
		<img class="thumbnail pull-left" src="<?php echo $image->getThumbnail($personnelObj->getPictureFileObj(), 75, 65, true)->src; ?>" />
	<?php else: ?>
		<span class="thumbnail placeholder pull-left">Unavailable</span>
	<?php endif; ?>
	<strong><?php echo $personnelObj->getLastName(); ?></strong>, <?php echo $personnelObj->getFirstName(); ?> - <?php echo $personnelObj->getTitle(); ?><br /> 
	<?php echo $personnelObj->getProviderHandle(true); ?>
</a>