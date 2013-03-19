<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Masonry Grid Settings'), t('Masonry Grid Settings and Configuration.'), false, false ); ?>
	
	<div id="masonryGridSettings">
		<div class="ccm-pane-body">
			<div class="row-fluid">
				<div class="span6">
					<form method="post" class="horizontal" action="<?php echo $this->action('save_developer_settings'); ?>">
						<h4>Developer Settings</h4>
						<div class="well">
							<div class="control-group">
								<label class="checkbox">
									Include Modernizr For Animation Test
									<?php echo $form->checkbox('MASONRY_CONFIG_INCLUDE_MODERNIZR', 1, Config::get('MASONRY_CONFIG_INCLUDE_MODERNIZR')); ?>
								</label>
							</div>
							<div class="control-group">
								<label class="checkbox">
									Include Twitter Bootstrap Modal
									<?php echo $form->checkbox('MASONRY_CONFIG_INCLUDE_BOOTSTRAP_MODAL', 1, Config::get('MASONRY_CONFIG_INCLUDE_BOOTSTRAP_MODAL')); ?>
								</label>
							</div>
							<div class="clearfix" style="padding:0;">
								<button type="submit" class="btn primary pull-right">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="ccm-pane-footer"></div>
	</div>
	
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>