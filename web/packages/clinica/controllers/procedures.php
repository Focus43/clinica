<?php defined('C5_EXECUTE') or die("Access Denied.");

    class ProceduresController extends ClinicaPageController {

        protected $includeThemeAssets   = true,
                  $requireHttps         = true;


        public function on_start(){
            $this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
            parent::on_start();
        }


        public function authorize(){
            $this->formResponder(true, 'Success', array(
                'token' => Loader::helper('validation/token')->generate('access'),
                'uri'   => $this->secureAction('asdfio23490asdf09zxcvihu234897asdf78234basdf89234')
            ));
        }


        public function asdfio23490asdf09zxcvihu234897asdf78234basdf89234( $token ){
            if( Loader::helper('validation/token')->validate('access', $token) ){
                // pass data to the element
                $patientListObj = new ClinicaPatientList();
                $patientListObj->sortBy('lastName', 'asc');
                $patients       = $patientListObj->get(1000);
                Loader::packageElement('partials/patients_table', 'clinica', array('patients' => $patients));
            }else{
                echo '<tr><td>An error occurred, please contact an administrator.</td></tr>';
            }
            exit;
        }

    }