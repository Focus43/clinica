<?php
	$formHelper 		= Loader::helper('form');
	$dateHelper			= Loader::helper('form/date_time');
	$transactionHelper 	= Loader::helper('clinica_transaction', 'clinica');
?>

	<div id="clinicaSearchBaseElements" style="display:none;">
		
	</div>

	<form method="get" id="ccm-transactions-advanced-search" action="<?php echo CLINICA_TOOLS_URL . 'dashboard/transactions/search_results'; ?>">
		
		<a href="javascript:void(0)" onclick="ccm_paneToggleOptions(this)" class="ccm-icon-option-closed"><?php echo t('Advanced Search')?></a>
		
		<div class="ccm-pane-options-permanent-search">
			<div class="span2">
				<?php echo $formHelper->text('keywords', $_REQUEST['keywords'], array('class' => 'input-block-level', 'placeholder' => t('Keyword Search'))); ?>
			</div>
			<div class="span1">
				<?php echo $formHelper->text('amount', $_REQUEST['amount'], array('class' => 'input-block-level', 'placeholder' => t('Amount'))); ?>
			</div>
			<div class="span2">
				<?php echo $formHelper->select('typeHandle', ClinicaTransactionHelper::typeHandles(), $_REQUEST['typeHandle'], array('class' => 'input-block-level')); ?>
			</div>
			<div class="span2">
				<?php echo $formHelper->select('numResults', array('10' => 'Show 10 (Default)', '25' => 'Show 25', '50' => 'Show 50', '100' => 'Show 100', '500' => 'Show 500'), $_REQUEST['numResults'], array('class' => 'input-block-level')); ?>
			</div>
			<!--<div class="span4">
				<span style="display:inline-block;position:relative;top:2px;padding-right:2px;">Date Range</span>
				<?php echo $dateHelper->date('dateRangeStart'); ?>
				<?php echo $dateHelper->date('dateRangeEnd'); ?>
			</div>-->
			<div class="span1">
				<button type="submit" class="btn info pull-right">Search</button>
			</div>
		</div>
		
	</form>
