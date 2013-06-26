<?php defined('C5_EXECUTE') or die("Access Denied.");

    class ProceduresController extends ClinicaPageController {

        protected $includeThemeAssets   = true,
                  $requireHttps         = true;


        public function on_start(){
            $this->addFooterItem( $this->getHelper('html')->javascript('libs/ajaxify.form.js', self::PACKAGE_HANDLE) );
            parent::on_start();
        }


        /**
         * Action used as a second layer of validation to make sure the user has access.
         * @return void
         */
        public function authorize(){
            $user       = new User(); // current user
            $passHash   = User::encryptPassword( $_POST['password'], PASSWORD_SALT );
            $existence  = Loader::db()->GetOne("SELECT uIsActive FROM Users WHERE uID = ? AND uPassword  = ?", array(
                            $user->getUserID(), $passHash
                        ));

            if( (bool)$existence === true ){
                $this->formResponder(true, 'Success', array(
                    'token' => Loader::helper('validation/token')->generate('access'),
                    'uri'   => $this->secureAction('asdfio23490asdf09zxcvihu234897asdf78234basdf89234')
                ));
                return;
            }

            $this->formResponder(false, 'The password does not match your account.');
        }


        public function asdfio23490asdf09zxcvihu234897asdf78234basdf89234( $token ){
            if( Loader::helper('validation/token')->validate('access', $token) ){
                // pass data to the element
                $patientListObj = new ClinicaPatientList();
                $patientListObj->sortBy('lastName', 'asc');
                $patients       = $patientListObj->get(1000);

                // load the package element as a view
                Loader::packageElement('partials/patients_table', 'clinica', array('patients' => $patients));
            }else{
                echo '<tr><td>An error occurred, please contact an administrator.</td></tr>';
            }
            exit;
        }

    }