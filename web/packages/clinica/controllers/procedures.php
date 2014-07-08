<?php defined('C5_EXECUTE') or die("Access Denied.");

    class ProceduresController extends ClinicaPageController {

        const ACCESS_TOKEN = 'access_prcdz';

        protected $includeThemeAssets   = true,
                  $requireHttps         = true,
                  $supportsPageCache    = false;


        public function on_start(){
            $this->tokenHelper = Loader::helper('validation/token');
            $this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
            parent::on_start();
        }


        /**
         * Tokens, by default, are valid for 24 hours (86400 seconds). $validFor makes the token
         * valid for only 10 seconds.
         * @return void
         */
        public function view(){
            $validFor = (int) (time() - 86390);
            $this->set('accessToken', $this->tokenHelper->generate(self::ACCESS_TOKEN, $validFor));
        }


        /**
         * Ajax request to load the patient table data.
         * @param string $token
         */
        public function get_data( $token = null ){
            // Is the token request valid? Expires after ten seconds...
            if( $this->tokenHelper->validate(self::ACCESS_TOKEN, $token) ){
                $userObj = new User();
                // Does the user have permission?
                if( $userObj->inGroup(Group::getByName(ClinicaPackage::GROUP_VIEW_PROCEDURES_TABLE)) ){
                    // Load the patient list
                    $patientListObj = new ClinicaPatientList();
                    $patientListObj->sortBy('lastName', 'asc');
                    $patients       = $patientListObj->get(1000);
                    // Render the view partial
                    Loader::packageElement('partials/patients_table', 'clinica', array('patients' => $patients));
                    exit;
                }
            }

            // Either token expired or user didn't have permission; render error.
            echo '<tr><td>Either your request took too long or you dont have permission Please contact an administrator.</td></tr>';
            exit;
        }

    }