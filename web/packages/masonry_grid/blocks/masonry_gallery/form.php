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
				<td>File Set(s)</td>
				<td colspan="5" class="chosenParent">
					<select class="input-block-level" name="fileSetIDs[]" multiple data-placeholder="Choose one or more File Set">
						<?php foreach($availableFileSets AS $fsObj): ?>
							<option value="<?php echo $fsObj->getFileSetID(); ?>"<?php if(in_array($fsObj->getFileSetID(), $selectedFileSetIDs)){ echo ' selected="selected"'; } ?>><?php echo $fsObj->getFileSetName(); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Image Width</td>
				<td><?php echo $formHelper->text('maxWidth', $controller->maxWidth, array('class' => 'input-block-level')); ?></td>
				<td><strong>Margin</strong></td>
				<td><?php echo $formHelper->text('margin', $controller->margin, array('class' => 'input-block-level')); ?></td>
				<td><strong>Padding</strong></td>
				<td><?php echo $formHelper->text('padding', $controller->padding, array('class' => 'input-block-level')); ?></td>
			</tr>
			<tr>
				<td>Show File Set Filters</td>
				<td colspan="5"><?php echo $formHelper->checkbox('showFileSetFilters', 1, $controller->showFileSetFilters); ?></td>
			</tr>
			<tr>
				<td>Enable Modals</td>
				<td colspan="5"><?php echo $formHelper->checkbox('enableModals', 1, $controller->enableModals); ?></td>
			</tr>
			<tr>
				<td>Paging</td>
				<td colspan="5"><?php echo $formHelper->select('pagingResults', MasonryGalleryBlockController::$pagingOptions, $controller->pagingResults, array('class' => 'span2')); ?> &nbsp; Images Per Page</td>
			</tr>
		</table>
	</div>

	<script type="text/javascript">
		$('select', '.chosenParent').chosen();
	</script>
