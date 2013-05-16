<?php $columns = ClinicaTransactionColumnSet::getCurrent(); ?>

<div id="ccm-<?php echo $searchInstance; ?>-search-results">
	<div class="ccm-pane-body">
		<div class="clearfix">
			<div class="pull-left">
				<select id="actionMenu" class="span3" disabled="disabled" data-action-delete="<?php echo 'dashboard/transactions/delete'; ?>">
					<option value="">** With Selected</option>
					<option value="delete">Delete Transaction(s)</option>
				</select>
			</div>
			<div class="pull-right">
				<a class="btn success" href="<?php echo View::url('dashboard/clinica/transactions/add'); ?>">Manually Add Transaction</a>
			</div>
		</div>
		
		<table id="clinicaSearchTable" border="0" cellspacing="0" cellpadding="0" class="ccm-results-list">
			<thead>
				<tr>
					<th><input id="checkAllBoxes" type="checkbox" /></th>
					<th>Transaction Type</th>
					<?php foreach($columns->getColumns() as $col) { ?>
		                <?php if ($col->isColumnSortable()) { ?>
		                	<th class="<?php echo $listObject->getSearchResultsClass($col->getColumnKey())?>"><a href="<?php echo $listObject->getSortByURL($col->getColumnKey(), $col->getColumnDefaultSortDirection(), (CLINICA_TOOLS_URL . 'dashboard/transactions/search_results'), array())?>"><?php echo $col->getColumnName()?></a></th>
		                <?php } else { ?>
		                	<th><?php echo $col->getColumnName()?></th>
		                <?php } ?>
	                <?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listResults AS $transaction): ?>
					<tr>
						<td><input type="checkbox" name="transactionID[]" value="<?php echo $transaction->getTransactionID(); ?>" /></td>
						<td><a href="<?php echo View::url('dashboard/clinica/transactions/', $transaction->getTransactionID()); ?>"><?php echo ucwords(str_replace(array('_', '-', '/'), ' ', $transaction->getTypeHandle())) ?></a></td>
						<?php foreach($columns->getColumns() AS $colObj){ ?>
							<td><?php echo $colObj->getColumnValue($transaction); ?></td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<!-- # of results -->
		<?php $listObject->displaySummary(); ?>
	</div>
	
	<!-- paging stuff -->
	<div class="ccm-pane-footer">
		<?php $listObject->displayPagingV2((CLINICA_TOOLS_URL . 'dashboard/transactions/search_results'), array()) ?>
	</div>
</div>
