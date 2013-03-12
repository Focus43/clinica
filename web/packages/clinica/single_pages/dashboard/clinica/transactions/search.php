<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clinica Transaction Search'), t('View e-commerce transactions conducted on clinica.org.'), false, false ); ?>
	
	<div id="ctManager">
		<div class="ccm-pane-options">
			<?php Loader::packageElement('dashboard/search_form_advanced', 'clinica', array('columns' => $columns, 'searchInstance' => $searchInstance, 'searchRequest' => $searchRequest)); ?>
		</div>
		
		<?php Loader::packageElement('dashboard/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		)); ?>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>