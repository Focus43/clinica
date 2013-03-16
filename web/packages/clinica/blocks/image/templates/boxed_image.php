<? defined('C5_EXECUTE') or die("Access Denied."); ?>

<span class="boxedImage showtooltip" title="<?php echo $controller->altText; ?>">
	<?php 
		$controller->maxWidth = !empty($controller->maxWidth) ? $controller->maxWidth : 180;
		$controller->maxHeight = !empty($controller->maxHeight) ? $controller->maxHeight : 120;
		echo $controller->getContentAndGenerate(); 
	?>
</span>