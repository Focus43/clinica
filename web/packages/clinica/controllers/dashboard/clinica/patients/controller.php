<?php

	class DashboardClinicaPatientsController extends ClinicaPageController {
	
	
		public function on_start(){
			$this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
		}


        public function view( $id = null ) {
            // viewing a specific transaction
            if( !is_null($id) && ((int) $id >= 1) ){
                $this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
                $patientObj = ClinicaPatient::getByID($id);
                $this->set('patientObj', $patientObj);
                return;
            }

            $searchInstance = 'patient' . time();
            $this->addHeaderItem(Loader::helper('html')->css('dashboard/app.dashboard.css', 'clinica'));
            $this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
            $this->addFooterItem('<script type="text/javascript">$(function() { ccm_setupAdvancedSearch(\''.$searchInstance.'\'); });</script>');
            $this->addFooterItem(Loader::helper('html')->javascript('dashboard/app.dashboard.js', 'clinica'));
            $this->set('listObject', $this->patientListObj());
            $this->set('listResults', $this->patientListObj()->getPage());
            $this->set('searchInstance', $searchInstance);

            // just redirecting to the search page
//            $this->redirect('/dashboard/clinica/patients/search');
        }
		
		
		public function add(){
			$this->set('patientObj', new ClinicaPatient);
		}
		
		
		public function edit( $id ){
			$this->set('patientObj', ClinicaPatient::getByID($id));
		}
		
		
		public function save( $id = null ) {
			$personnelObj = ClinicaPatient::getByID($id);
			$personnelObj->setPropertiesFromArray($_POST);
			$personnelObj->save();
            
            // purge the Providers front-facing page from the cache
            PageCache::getLibrary()->purge( Page::getByPath('/patients') );
            
			$this->redirect('/dashboard/clinica/patients/');
		}

        public function delete( $id ) {
            $personnelObj = ClinicaPatient::getByID($id);
            $personnelObj->delete();

            // purge the Providers front-facing page from the cache
            PageCache::getLibrary()->purge( Page::getByPath('/patients') );

            $this->redirect('/dashboard/clinica/patients/');
        }

        public function patientListObj(){
            if( $this->_patientListObj === null ){
                $this->_patientListObj = new ClinicaPatientList();
//                $this->applySearchFilters( $this->_patientListObj );
            }
            return $this->_patientListObj;
        }
	
	}