<?php defined('C5_EXECUTE') or die("Access Denied.");

	class DashboardClinicaController extends Controller {
	
		public function view() {
			$this->redirect('/dashboard/clinica/transactions');
		}
	
	}