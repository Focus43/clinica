<?php
	$formHelper 		= Loader::helper('form');
	$dateHelper			= Loader::helper('form/date_time');
	$transactionHelper 	= Loader::helper('clinica_transaction', 'clinica');
?>
	<div id="clinicaSearchBaseElements" style="display:none;">
		
	</div>

	<form method="get" id="clinicaSearchAdvanced" action="<?php echo $this->action('search_results'); ?>">
		<div class="ccm-pane-options-permanent-search">
			<div class="span2">
				<?php echo $formHelper->text('keywords', $_REQUEST['keywords'], array('class' => 'input-block-level','placeholder' => t('Keyword Search'))); ?>
			</div>
			<div class="span2">
				<?php echo $formHelper->select('typeHandle', ClinicaTransactionHelper::typeHandles(), $_REQUEST['typeHandle'], array('class' => 'input-block-level')); ?>
			</div>
			<div class="span4">
				<span>Between</span>
				<?php echo $dateHelper->date('dateRangeStart'); ?>
				<?php echo $dateHelper->date('dateRangeEnd'); ?>
			</div>
		</div>
	</form>
