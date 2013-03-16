<?php defined('C5_EXECUTE') or die("Access Denied.");
	$formHelper = Loader::helper('form');
?>

	<style type="text/css">
		#masonryBlock table td {white-space:nowrap;vertical-align: middle;}
		#masonryBlock table tr td:first-child {width:2%;font-weight:bold;}
	</style>

	<div id="masonryBlock" class="ccm-ui">
		<table class="table table-bordered">
			<tr>
				<td>File Set</td>
				<td><?php echo $formHelper->select('fileSetID', $availableFileSets, $controller->fileSetID, array('class' => 'input-block-level')); ?></td>
			</tr>
			<tr>
				<td>Title Overlay?</td>
				<td><?php echo $formHelper->checkbox('showTitleOverlay', 1, $controller->showTitleOverlay); ?></td>
			</tr>
			<tr>
				<td>Image Widths</td>
				<td><?php echo $formHelper->text('maxWidth', $controller->maxWidth); ?></td>
			</tr>
		</table>
	</div>
