<?php defined('C5_EXECUTE') or die("Access Denied.");
	$pageSelector = Loader::helper('form/page_selector');
?>

	<style type="text/css">
		#pageChoozer {}
		#clonableWrap {display:none;}
		#pageChoozer .ccm-summary-selected-item {cursor:move;:4px;-moz-border-radius:4px;border-radius:4px;}
	</style>

	<div id="pageChoozer" class="ccm-ui">
		
		<p>Click <strong>Add Page</strong> below to add one or more pages, which can be selected from the sitemap.</p>
		
		<div id="chosenPagesList">
			<?php foreach($pageCollection AS $pageObj):
				echo $pageSelector->selectPage('chosenPages[]', $pageObj->getCollectionID());	
			endforeach; ?>
		</div>
		
		<a id="pageChoozerAdd" class="btn info btn-block">Add Page</a>
		
		<!-- every page added uses jquery to just clone the selector output in here -->
		<div id="clonableWrap">
			<?php echo $pageSelector->selectPage('chosenPages[]'); ?>
		</div>
	</div>
