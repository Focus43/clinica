<?php Loader::packageElement('flash_message', 'clinica', array('flash' => $flash)); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Clinica Personnel Search'), t('View clinica personnel (mostly providers).'), false, false ); ?>
	
	<div id="clinicaWrap">
		<div class="ccm-pane-options">
			<form method="get" id="ccm-<?php echo $searchInstance; ?>-advanced-search" action="<?php echo CLINICA_TOOLS_URL . 'dashboard/personnel/search_results'; ?>">
				<!-- default search options -->
				<div class="ccm-pane-options-permanent-search">
					<div class="pull-left">
						<div class="span2">
							<?php echo $form->text('keywords', $_REQUEST['keywords'], array('class' => 'input-block-level helpTooltip', 'placeholder' => t('Keyword Search'), 'title' => 'First or last name')); ?>
						</div>
						<div class="span2">
							<?php echo $form->select('providerHandle', (array('' => 'Provider') + ClinicaPersonnel::$providerLocations), '', array('class' => 'span2 helpTooltip', 'title' => 'Filter by provider location')); ?>
						</div>
						<div class="span2">
							<?php echo $form->select('numResults', array('10' => 'Show 10 (Default)', '25' => 'Show 25', '50' => 'Show 50', '100' => 'Show 100', '500' => 'Show 500'), $_REQUEST['numResults'], array('class' => 'input-block-level helpTooltip', 'title' => '# of results to display')); ?>
						</div>
						<div class="span1">
							<button type="submit" class="btn info pull-right">Search</button>
							<img src="<?php echo ASSETS_URL_IMAGES?>/loader_intelligent_search.gif" width="43" height="11" class="ccm-search-loading" id="ccm-locales-search-loading" />
						</div>
					</div>
					<div class="pull-right">
						<a class="btn success" href="<?php echo View::url('dashboard/clinica/personnel/add'); ?>">Add Personnel</a>
					</div>
				</div>
			</form>
		</div>
		
		<?php Loader::packageElement('dashboard/personnel/search_results', 'clinica', array(
			'searchInstance'	=> $searchInstance,
			'listObject'		=> $listObject,
			'listResults'		=> $listResults,
			'pagination'		=> $pagination
		)); ?>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>