<?php $columns = ClinicaPatientColumnSet::getCurrent(); ?>

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
                <a class="btn" href="<?php echo CLINICA_TOOLS_URL . 'dashboard/patients/excel_export'; ?>">Excel Export</a>
            </div>
		</div>
		
		<table id="clinicaSearchTable" border="0" cellspacing="0" cellpadding="0" class="group-left ccm-results-list">
			<thead>
				<tr>
					<th><input id="checkAllBoxes" type="checkbox" /></th>
					<?php foreach($columns->getColumns() as $col) {
                        echo "<th>{$col->getColumnName()}</th>";
	                } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listResults AS $patient): ?>
					<tr>
						<td><input type="checkbox" name="patientID[]" value="<?php echo $patient->getID(); ?>" /></td>

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
