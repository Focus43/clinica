<?php

	class DashboardMasonryGridSettingsController extends Controller {
		
		public $helpers = array('form');
		
		
		public function save_developer_settings(){
			Config::save('MASONRY_CONFIG_INCLUDE_MODERNIZR', (int)$_REQUEST['MASONRY_CONFIG_INCLUDE_MODERNIZR']);
			Config::save('MASONRY_CONFIG_INCLUDE_BOOTSTRAP_MODAL', (int)$_REQUEST['MASONRY_CONFIG_INCLUDE_BOOTSTRAP_MODAL']);
			$this->redirect('dashboard/masonry_grid/settings');
		}
		
	}
