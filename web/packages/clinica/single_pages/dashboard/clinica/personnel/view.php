<?php /** @var $transactionObj ClinicaTransaction */ ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Personnel'), t(''), false, false ); ?>
	
	<div id="clinicaWrap">
		<div class="ccm-pane-body">
			
			<?php Loader::packageElement('dashboard/personnel/form_add_edit', 'clinica', array('personnelObj' => $personnelObj)); ?>
	
		</div>
		<div class="ccm-pane-footer"></div>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>