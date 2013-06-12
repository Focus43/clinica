<?php $columns = ClinicaPatientColumnSet::getCurrent();
	$imageHelper = Loader::helper('image');
?>

<div id="ccm-<?php echo $searchInstance; ?>-search-results">
	<div class="ccm-pane-body">
		<div class="clearfix">
			<div class="pull-left">
				<select id="actionMenu" class="span3" disabled="disabled" data-action-delete="<?php echo 'dashboard/patients/delete'; ?>">
					<option value="">** With Selected</option>
					<option value="delete">Delete Patient</option>
				</select>
			</div>
            <div class="pull-right">
                <a class="btn success" href="<?php echo View::url('dashboard/clinica/patients/add'); ?>">Add Patient</a>
            </div>
		</div>
		
		<table id="clinicaSearchTable" border="0" cellspacing="0" cellpadding="0" class="group-left ccm-results-list">
			<thead>
				<tr>
					<th><input id="checkAllBoxes" type="checkbox" /></th>
					<?php foreach($columns->getColumns() as $col) { ?>
		                <?php if ($col->isColumnSortable()) { ?>
<!--		                	<th class="--><?php //echo $listObject->getSearchResultsClass($col->getColumnKey())?><!--"><a href="--><?php //echo $listObject->getSortByURL($col->getColumnKey(), $col->getColumnDefaultSortDirection(), (CLINICA_TOOLS_URL . 'dashboard/patients/search_results'), array())?><!--">--><?php //echo $col->getColumnName()?><!--</a></th>-->
                            <th><?php echo $col->getColumnName()?></th>
		                <?php } else { ?>
		                	<th><?php echo $col->getColumnName()?></th>
		                <?php } ?>
	                <?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listResults AS $patient): ?>
					<tr>
						<td><input type="checkbox" name="personnelID[]" value="<?php echo $patient->getID(); ?>" /></td>

						<?php foreach($columns->getColumns() AS $colObj){ ?>
							<td class="<?php echo strtolower($colObj->getColumnName()); ?>"><?php echo $colObj->getColumnValue($patient); ?></td>
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
		<?php $listObject->displayPagingV2((CLINICA_TOOLS_URL . 'dashboard/patients/search_results'), array()) ?>
	</div>
</div>
