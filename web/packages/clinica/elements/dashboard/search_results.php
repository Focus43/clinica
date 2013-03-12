<?php $columns = ClinicaTransactionColumnSet::getCurrent(); ?>

<div id="ccm-transactions-search-results">
	<div class="ccm-pane-body">
		<div class="clearfix">
			<div class="pull-left">
				<select class="span3">
					<option value="">** With Selected</option>
				</select>
			</div>
			<div class="pull-right">
				<a class="btn success">Manually Add Transaction</a>
			</div>
		</div>
		
		<table id="transactionList" border="0" cellspacing="0" cellpadding="0" class="ccm-results-list">
			<thead>
				<tr>
					<th><input id="checkAllBoxes" type="checkbox" /></th>
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
						<td><input type="checkbox" /></td>
						<?php foreach($columns->getColumns() AS $colObj){ ?>
							<td><?php echo $colObj->getColumnValue($transaction); ?></td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<!-- paging and # of results -->
		<?php $listObject->displaySummary(); ?>
	</div>
	
	<div class="ccm-pane-footer">
		<?php $listObject->displayPagingV2((CLINICA_TOOLS_URL . 'dashboard/transactions/search_results'), array()) ?>
	</div>
</div>
