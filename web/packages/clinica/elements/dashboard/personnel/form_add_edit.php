<?php Loader::element('editor_config');
	$formHelper = Loader::helper('form');
	$assetLibrary = Loader::helper('concrete/asset_library');
?>
			
<form method="post" action="<?php echo $this->action('save', $personnelObj->getPersonnelID()); ?>">
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
						<td>Title</td>
					</tr>
					<tr>
						<td><?php echo $formHelper->text('firstName', $personnelObj->getFirstName(), array('class' => 'input-block-level')); ?></td>
						<td><?php echo $formHelper->text('lastName', $personnelObj->getLastName(), array('class' => 'input-block-level')); ?></td>
						<td><?php echo $formHelper->text('title', $personnelObj->getTitle(), array('class' => 'input-block-level')); ?></td>
					</tr>
					<tr>
						<td colspan="2">Picture</td>
						<td>Provider Location</td>
					</tr>
					<tr>
						<td colspan="2"><?php echo $assetLibrary->image('pictureID', 'picID', 'Personnel Photo', File::getByID($personnelObj->getPicID())); ?></td>
						<td><?php echo $formHelper->select('providerHandle', ClinicaPersonnel::$providerLocations, $personnelObj->getProviderHandle()); ?></td>
					</tr>
					<tr>
						<td colspan="3">Description</td>
					</tr>
					<tr class="no-stripe">
						<td colspan="3">
							<div style="background:#fff;">
								<?php Loader::element('editor_controls'); ?>
								<?php echo $formHelper->textarea('description', $personnelObj->getDescription(), array('class' => 'ccm-advanced-editor')); ?>
							</div>
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