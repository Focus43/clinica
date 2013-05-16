<?php

	class DashboardClinicaPersonnelController extends Controller {
	
	
		public function on_start(){
			$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
		}
	
	
		public function view() {			
			// just redirecting to the search page
			$this->redirect('/dashboard/clinica/personnel/search');
		}
		
		
		public function add(){
			$this->set('personnelObj', new ClinicaPersonnel);
		}
		
		
		public function edit( $id ){
			$this->set('personnelObj', ClinicaPersonnel::getByID($id));
		}
		
		
		public function save( $id = null ) {
			$personnelObj = ClinicaPersonnel::getByID($id);
			$personnelObj->setPropertiesFromArray($_POST);
			$personnelObj->save();
			$this->redirect('/dashboard/clinica/personnel/search');
		}
	
	}