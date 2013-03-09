<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clinica Transaction Records'), t('Search/View/Modify E-commerce Transactions'), false, false ); ?>
	
	<div id="ctManager" class="ccm-pane-body">
		
	</div>
	
	<div class="ccm-pane-footer"></div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>