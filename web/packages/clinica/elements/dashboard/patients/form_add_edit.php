<?php Loader::element('editor_config');
	$formHelper = Loader::helper('form');
    $dateHelper = Loader::helper('form/date_time');
	$assetLibrary = Loader::helper('concrete/asset_library');
?>
			
<form method="post" action="<?php echo $this->action('save', $patientObj->getID()); ?>">
	<h4>Add Or Update Personnel</h4>

	<div class="row-fluid">
		<div class="span12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="4">Personnel Details</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width:33%;">First Name</td>
						<td style="width:33%;">Last Name</td>
						<td>DOB</td>
                        <td>Paid?</td>
					</tr>
					<tr>
						<td><?php echo $formHelper->text('firstName', $patientObj->getFirstName(), array('class' => 'input-block-level')); ?></td>
						<td><?php echo $formHelper->text('lastName', $patientObj->getLastName(), array('class' => 'input-block-level')); ?></td>
                        <td>
<!--                            --><?php //echo $formHelper->text('dob', $patientObj->getDOB(), array('class' => 'input-block-level')); ?>
                            <?php print $dateHelper->date('dob', $patientObj->getDOB(), true); ?>
                            </td>
                        <td>
                            <label class="radio">
                                <?php echo $formHelper->radio('paid', 0, $patientObj->getPaidNumeric()) . " NO"; ?>
                            </label>
                            <label class="radio">
                                <?php echo $formHelper->radio('paid', 1, $patientObj->getPaidNumeric()) . " YES"; ?>
                            </label>
                        </td>
					</tr>


				</tbody>
			</table>
		</div>
	</div>
	
	<div class="clearfix" style="padding-bottom:0;">
		<button type="submit" class="btn primary pull-right">Save</button>
	</div>
</form>