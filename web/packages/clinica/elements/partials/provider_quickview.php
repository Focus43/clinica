<a class="provider clearfix" href="<?php echo $this->action('profile', $personnelObj->getPersonnelID()); ?>" data-provider="<?php echo $personnelObj->getProviderHandle(); ?>" data-name="<?php echo "{$personnelObj->getFirstName()} {$personnelObj->getLastName()}"; ?>">
	<?php if( $personnelObj->getPictureFileObj()->getFileID() >= 1 ): ?>
		<img class="thumbnail pull-left" src="<?php echo $image->getThumbnail($personnelObj->getPictureFileObj(), 75, 90, true)->src; ?>" />
	<?php else: ?>
		<span class="thumbnail placeholder pull-left">Unavailable</span>
	<?php endif; ?>
	<strong class="plus"><?php echo $personnelObj->getFirstName() . ' ' . $personnelObj->getLastName(); ?></strong>, <?php echo $personnelObj->getTitle(); ?><br /> 
	<em><?php echo $personnelObj->getProviderHandle(true); ?></em>
</a>