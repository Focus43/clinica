<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

	<ul class="unstyled">
		<?php foreach( $pageCollection AS $pageObj ){ ?>
			<li><a href="<?php echo $this->url($pageObj->getCollectionPath()); ?>"><?php echo $pageObj->getCollectionName(); ?></a></li>
		<?php } ?>
	</ul>