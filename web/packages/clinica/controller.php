<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class ClinicaPackage extends Package {
	
	    protected $pkgHandle 			= 'clinica';
	    protected $appVersionRequired 	= '5.6.1';
	    protected $pkgVersion 			= '0.69';

        // Fileset names
        const FILESET_PROCEDURE_FORMS   = 'SecureProcedureForms';

        // User groups
        const GROUP_VIEW_PROCEDURES_TABLE = 'View Procedures Table';

		
		/**
		 * @return string
		 */
	    public function getPackageName(){
	        return t('Clinica');
	    }
		
		
		/**
		 * @return string
		 */
	    public function getPackageDescription() {
	        return t('Clinica.org site theme, assets, and add-ons');
	    }
	
		
		/**
		 * Run hooks high up in the load chain
		 * @return void
		 */
	    public function on_start(){
	        define('CLINICA_TOOLS_URL', BASE_URL . REL_DIR_FILES_TOOLS_PACKAGES . '/' . $this->pkgHandle . '/');
			define('CLINICA_IMAGES_URL', DIR_REL . '/packages/' . $this->pkgHandle . '/images/');
			
			// set theme paths
			View::getInstance()->setThemeByPath('/login', 'clinica_site');
			View::getInstance()->setThemeByPath('/page_not_found', 'clinica_site');
			
			// autoload classes
			Loader::registerAutoload(array(
				// page controller
				'ClinicaPageController'		=> array('library', 'clinica_page_controller', $this->pkgHandle),
				
				// Authorize.net; use Concrete5's autoloader instead of the require statements in AuthorizeNet.php fake autoloader
				'AuthorizeNetException' 	=> array('library', 'authorize_net_sdk/authorize_net_exception', $this->pkgHandle),
				'AuthorizeNetRequest' 		=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetRequest', $this->pkgHandle),
				'AuthorizeNetTypes'			=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetTypes', $this->pkgHandle),
				'AuthorizeNetXMLResponse' 	=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetXMLResponse', $this->pkgHandle),
				'AuthorizeNetResponse' 		=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetResponse', $this->pkgHandle),
				'AuthorizeNetAIM,AuthorizeNetAIM_Response' => array('library', 'authorize_net_sdk/lib/AuthorizeNetAIM', $this->pkgHandle),
				
				// Clinica transactional stuff (handler, records, attributes, search interface, etc.)
				'ClinicaBaseObject'			=> array('library', 'clinica_base_object', $this->pkgHandle),
				'ClinicaTransactionHandler'	=> array('library', 'clinica_transaction_handler', $this->pkgHandle),
				'ClinicaTransaction'		=> array('model', 'clinica_transaction', $this->pkgHandle),
				'ClinicaTransactionAttributeKey,ClinicaTransactionAttributeValue' => array('model', 'attribute/categories/clinica_transaction', $this->pkgHandle),
				'ClinicaTransactionList'	=> array('model', 'clinica_transaction_list', $this->pkgHandle),
				
				// Other clinica data
				'ClinicaPersonnel'			=> array('model', 'clinica_personnel', $this->pkgHandle),
				'ClinicaPersonnelList'		=> array('model', 'clinica_personnel_list', $this->pkgHandle),
                'ClinicaPatient'			=> array('model', 'clinica_patient', $this->pkgHandle),
                'ClinicaPatientList'		=> array('model', 'clinica_patient_list', $this->pkgHandle)
			));
			
			// load the SOAP client, if it exists
			if( class_exists('SoapClient') ){
				Loader::registerAutoload(array('AuthorizeNetSOAP', array('library', 'authorize_net_sdk/lib/AuthorizeNetSOAP', $this->pkgHandle)));
			}

            // event hooks for when the user is logged in
            if( User::isLoggedIn() ){
                Events::extend('on_file_added_to_set', 'ClinicaFileEvents', 'onFileAddedToSet', "packages/{$this->pkgHandle}/libraries/system_event_hooks/file_events.php");
            }
	    }
		
	
		/**
		 * Proxy to the parent uninstall method
		 * @return void
		 */
	    public function uninstall() {
	        parent::uninstall();
			
			try {
				$db = Loader::db();
				$db->Execute("DROP TABLE ClinicaTransaction");
				$db->Execute("DROP TABLE ClinicaTransactionAttributeValues");
				$db->Execute("DROP TABLE ClinicaTransactionSearchIndexAttributes");
			}catch(Exception $e){
				// fail gracefully
			}
	    }
	    
		
		/**
		 * @return void
		 */
	    public function upgrade(){
			parent::upgrade();
			$this->installAndUpdate();
	    }
		
		
		/**
		 * @return void
		 */
		public function install() {
	    	$this->_packageObj = parent::install(); 
			$this->installAndUpdate();
	    }
		
		
		/**
		 * Handle all the updating methods
		 * @return void
		 */
		private function installAndUpdate(){
			$this->registerEntityCategories()
				 ->setupAttributeTypes()
				 ->setupAttributeSets()
				 ->setupUserAttributes()
				 ->setupCollectionAttributes()
				 ->setupTransactionAttributes()
				 ->setupBlocks()
				 ->setupTheme()
				 ->setupPageTypes()
				 ->setupSitePages()
                 ->setupJobs()
                 ->setupFileSets()
                 ->setupUserGroups();
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function registerEntityCategories(){
			if( !($this->attributeKeyCategory('clinica_transaction') instanceof AttributeKeyCategory) ){
				$transactionAkc = AttributeKeyCategory::add('clinica_transaction', AttributeKeyCategory::ASET_ALLOW_MULTIPLE, $this->packageObject());
				$transactionAkc->associateAttributeKeyType( $this->attributeType('text') );
				$transactionAkc->associateAttributeKeyType( $this->attributeType('boolean') );
				$transactionAkc->associateAttributeKeyType( $this->attributeType('number') );
				$transactionAkc->associateAttributeKeyType( $this->attributeType('textarea') );
				$transactionAkc->associateAttributeKeyType( $this->attributeType('select') );
			}
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupAttributeTypes(){
			if( !(AttributeType::getByHandle('page_selector')->getAttributeTypeID() >= 1 ) ){
				AttributeType::add('page_selector', t('Page Selector'), $this->packageObject());
				$this->attributeKeyCategory('file')->associateAttributeKeyType( $this->attributeType('page_selector') );
			}
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupAttributeSets(){
			$this->getOrCreateAttributeSet('user_info', 'user');
			
			if( !class_exists('ClinicaTransaction') ){
				Loader::library('clinica_base_object', $this->packageObject());
				Loader::model('clinica_transaction', $this->packageObject());
			}
			
			// transaction attribute sets
			$this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_DONATION, 'clinica_transaction');
			$this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_BILL_PAY, 'clinica_transaction');
			$this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_MISS_GREEK, 'clinica_transaction');
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupTransactionAttributes(){
			// donation attributes
			if( !(is_object(ClinicaTransactionAttributeKey::getByHandle('use_donation_for'))) ){
				$useDonationForAk = ClinicaTransactionAttributeKey::add($this->attributeType('select'), array(
					'akHandle'						=> 'use_donation_for',
					'akName'						=> 'Please Use Donation For',
					'akIsSearchable'				=> true, 
					'akIsSearchableIndexed'			=> true, 
					'akSelectOptionDisplayOrder'	=> 'alpha_asc'
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_DONATION) );
			}

            // Make sure the donation attribute options exist
            $donationAk = ClinicaTransactionAttributeKey::getByHandle('use_donation_for');
            if( is_object($donationAk) ){

                if( !is_object(SelectAttributeTypeOption::getByValue('General Operations', $donationAk)) ){
                    SelectAttributeTypeOption::add($donationAk, 'General Operations', 1);
                }

                if( !is_object(SelectAttributeTypeOption::getByValue('Reach Out And Read', $donationAk)) ){
                    SelectAttributeTypeOption::add($donationAk, 'Reach Out And Read', 1);
                }
                if( !is_object(SelectAttributeTypeOption::getByValue('New Lafayette Clinic', $donationAk)) ){
                    SelectAttributeTypeOption::add($donationAk, 'New Lafayette Clinic', 1);
                }
            }
			
			// bill payment attributes
			if( !(is_object(ClinicaTransactionAttributeKey::getByHandle('clinica_account_number'))) ){
				ClinicaTransactionAttributeKey::add($this->attributeType('text'), array(
					'akHandle'						=> 'clinica_account_number',
					'akName'						=> 'Clinica Account Number',
					'akIsSearchable'				=> true, 
					'akIsSearchableIndexed'			=> true
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_BILL_PAY) );
			}
			
			if( !(is_object(ClinicaTransactionAttributeKey::getByHandle('patient_first_name'))) ){
				ClinicaTransactionAttributeKey::add($this->attributeType('text'), array(
					'akHandle'						=> 'patient_first_name',
					'akName'						=> 'Patient First Name',
					'akIsSearchable'				=> true, 
					'akIsSearchableIndexed'			=> true
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_BILL_PAY) );
			}
			
			if( !(is_object(ClinicaTransactionAttributeKey::getByHandle('patient_last_name'))) ){
				ClinicaTransactionAttributeKey::add($this->attributeType('text'), array(
					'akHandle'						=> 'patient_last_name',
					'akName'						=> 'Patient Last Name',
					'akIsSearchable'				=> true, 
					'akIsSearchableIndexed'			=> true
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_BILL_PAY) );
			}
			
			if( !(is_object(ClinicaTransactionAttributeKey::getByHandle('patient_birthdate'))) ){
				ClinicaTransactionAttributeKey::add($this->attributeType('text'), array(
					'akHandle'						=> 'patient_birthdate',
					'akName'						=> 'Patient Birth Date',
					'akIsSearchable'				=> true, 
					'akIsSearchableIndexed'			=> true
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet(ClinicaTransaction::TYPE_BILL_PAY) );
			}
			
			return $this;
		}


		/**
		 * @return ClinicaPackage
		 */
		private function setupUserAttributes(){
			if( !(is_object(UserAttributeKey::getByHandle('first_name'))) ){
				UserAttributeKey::add($this->attributeType('text'), array(
					'akHandle'					=> 'first_name', 
					'akName'					=> t('First Name'),
					'uakRegisterEdit'			=> 1,
					'uakRegisterEditRequired' 	=> 1
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet('user_info') );
			}
			
			if( !(is_object(UserAttributeKey::getByHandle('last_name'))) ){
				UserAttributeKey::add($this->attributeType('text'), array(
					'akHandle'					=> 'last_name', 
					'akName'					=> t('Last Name'),
					'uakRegisterEdit'			=> 1,
					'uakRegisterEditRequired' 	=> 1
				), $this->packageObject())->setAttributeSet( $this->getOrCreateAttributeSet('user_info') );
			}
			
			return $this;
		}
		
		
		/**
	     * @return ClinicaPackage 
	     */
	    private function setupCollectionAttributes(){
	        if( !is_object(CollectionAttributeKey::getByHandle('page_background')) ){
	            CollectionAttributeKey::add($this->attributeType('image_file'), array(
	                'akHandle'  => 'page_background',
	                'akName'    => 'Page Background'
	            ));
	        }
	        
	        return $this;
	    }


		/**
		 * @return ClinicaPackage
		 */
		private function setupBlocks(){
			// PageChoozer
			if(!is_object(BlockType::getByHandle('page_choozer'))) {
				BlockType::installBlockTypeFromPackage('page_choozer', $this->packageObject());
			}
            
            // Button Link
            if(!is_object(BlockType::getByHandle('button_link'))) {
                BlockType::installBlockTypeFromPackage('button_link', $this->packageObject());
            }
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupTheme(){
		    // primary clinica theme
			try {
				PageTheme::add('clinica_site', $this->packageObject());
			}catch(Exception $e){ /* fail gracefully */ }
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupPageTypes(){
			if( !is_object($this->pageType('home')) ){
	            CollectionType::add(array('ctHandle' => 'home', 'ctName' => 'Home'), $this->packageObject());
	        }

			if( !is_object($this->pageType('default')) ){
	            CollectionType::add(array('ctHandle' => 'default', 'ctName' => 'Default'), $this->packageObject());
	        }
			
			if( !is_object($this->pageType('full_width')) ){
	            CollectionType::add(array('ctHandle' => 'full_width', 'ctName' => 'Full Width'), $this->packageObject());
	        }

			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupSitePages(){
			$homePage = Page::getByID(1);
			
			// setup pages if less than 0.3
			if( (float) $this->pkgVersion <= 0.37 ){
				$aboutPage = $this->pageFactory($homePage, 'About');
					$this->pageFactory($aboutPage, 'Mission + Vision');
					$this->pageFactory($aboutPage, 'History');
					$this->pageFactory($aboutPage, 'Services & Who We Serve');
					$this->pageFactory($aboutPage, 'Executive Team');
					$this->pageFactory($aboutPage, 'Board Of Directors');
					$this->pageFactory($aboutPage, 'Accredidations & Certifications');
					$this->pageFactory($aboutPage, 'Clinica News, Reports, Press');
					
				$innovationsPage = $this->pageFactory($homePage, 'Innovations');
					$this->pageFactory($innovationsPage, 'PCMH');
					$this->pageFactory($innovationsPage, 'Group Visits');
					$this->pageFactory($innovationsPage, 'Our Facilities');
					$this->pageFactory($innovationsPage, 'Behavioral Health Care');
					$this->pageFactory($innovationsPage, 'ACC');
					$this->pageFactory($innovationsPage, 'EHR / CACHIE / iPn');
					
				$patientsPage = $this->pageFactory($homePage, 'Patient Information');
					
				$locationsPage = $this->pageFactory($homePage, 'Locations');
					$this->pageFactory($locationsPage, 'Federal Heights');
					$this->pageFactory($locationsPage, 'Lafayette');
					$this->pageFactory($locationsPage, 'Pocos');
					$this->pageFactory($locationsPage, 'People\'s');
					$this->pageFactory($locationsPage, 'Thornton');
					$this->pageFactory($locationsPage, 'Dental');
					$this->pageFactory($locationsPage, 'Administration');
					
				$contactPage = $this->pageFactory($homePage, 'Contact Us');
					
				// same idea as "links" page below
				$employeesPage = $this->pageFactory($homePage, 'Employees');
					
				// have a links page where all (most) outgoing links are stored
				$linksPage = $this->pageFactory($homePage, 'Links');
			}
			
			
			// setup single pages
			SinglePage::add('/giving', $this->packageObject());
			SinglePage::add('/bill_pay', $this->packageObject());
			SinglePage::add('/providers', $this->packageObject());
			
			// clinica transaction dashboard pages
			SinglePage::add('/dashboard/clinica', $this->packageObject());
			$transactions = SinglePage::add('/dashboard/clinica/transactions', $this->packageObject());
			if( is_object($transactions) ){
				$transactions->setAttribute('icon_dashboard', 'icon-search');
			}
			SinglePage::add('/dashboard/clinica/transactions/search', $this->packageObject());
			
			// clinica personnel dashboard pages
			$personnel = SinglePage::add('/dashboard/clinica/personnel', $this->packageObject());
			if( is_object($personnel) ){
				$personnel->setAttribute('icon_dashboard', 'icon-user');
			}
			SinglePage::add('/dashboard/clinica/personnel/search', $this->packageObject());

            // clinica patient dashboard pages
            $patient = SinglePage::add('/dashboard/clinica/patients', $this->packageObject());
            if( is_object($patient) ){
                $patient->setAttribute('icon_dashboard', 'icon-user');
            }
            
            // settings page
			$settings = SinglePage::add('/dashboard/clinica/settings', $this->packageObject());
            if( is_object($settings) ){
                $settings->setAttribute('icon_dashboard', 'icon-cog');
            }

            // patient procedures page
            SinglePage::add('/procedures', $this->packageObject());
			
			return $this;
		}


        /**
         * @return ClinicaPackage
         */
        private function setupJobs(){
            if( (float) $this->pkgVersion < 0.54 ){
                if( !is_object(Job::getByHandle('migrate_provider_locations')) ){
                    Job::installByPackage( 'migrate_provider_locations', $this->packageObject() );
                }
            }
            
            return $this;
        }


        /**
         * @return ClinicaPackage
         */
        private function setupFileSets(){
            if( !(FileSet::getByName(self::FILESET_PROCEDURE_FORMS) instanceof FileSet) ){
                FileSet::createAndGetSet(self::FILESET_PROCEDURE_FORMS, FileSet::TYPE_PUBLIC);
            }

            return $this;
        }


        /**
         * @return ClinicaPackage
         */
        private function setupUserGroups(){
            if( !(Group::getByName(self::GROUP_VIEW_PROCEDURES_TABLE) instanceof Group) ){
                Group::add(self::GROUP_VIEW_PROCEDURES_TABLE, 'Can view procedures table');
            }

            return $this;
        }


		/**
		 * @param Page $parent The parent page that the page being added should go under
		 * @param string $name Name of the page
		 * @param string Handle of the page_type to use
		 * @return Page
		 */
		private function pageFactory( Page $parent, $name, $typeHandle = 'default' ){
			return $parent->add( $this->pageType($typeHandle), array(
				'cName' => $name,
				'pkgID' => $this->packageObject()->getPackageID()
			));
		}
		
		
		/**
		 * Get or create an attribute set, for a certain attribute key category (if passed).
		 * Will automatically convert the $attrSetHandle from handle_form_name to Handle Form Name
		 * @param string $attrSetHandle
		 * @param string $attrKeyCategory
		 * @return AttributeSet
		 */
		private function getOrCreateAttributeSet( $attrSetHandle, $attrKeyCategory = null ){
			if( $this->{ 'attr_set_' . $attrSetHandle } === null ){
				// try to load an existing Attribute Set
				$attrSetObj = AttributeSet::getByHandle( $attrSetHandle );
				
				// doesn't exist? create it, if an attributeKeyCategory is passed
				if( !is_object($attrSetObj) && !is_null($attrKeyCategory) ){
					// ensure the attr key category can allow multiple sets
					$akc = AttributeKeyCategory::getByHandle( $attrKeyCategory );
					$akc->setAllowAttributeSets( AttributeKeyCategory::ASET_ALLOW_MULTIPLE );
					
					// *now* add the attribute set
					$attrSetObj = $akc->addSet( $attrSetHandle, t( $this->getHelper('text')->unhandle($attrSetHandle) ), $this->packageObject() );
				}
				
				// assign the $attrSetObj
				$this->{ 'attr_set_' . $attrSetHandle } = $attrSetObj;
			}
			
			return $this->{ 'attr_set_' . $attrSetHandle };
		}


		/**
		 * Get the package object; if it hasn't been instantiated yet, load it.
		 * @return Package
		 */
		private function packageObject(){
			if( $this->_packageObj === null ){
				$this->_packageObj = Package::getByHandle( $this->pkgHandle );
			}
			return $this->_packageObj;
		}
		
		
		/**
		 * @return CollectionType
		 */
		private function pageType( $handle ){
			if( $this->{ "pt_{$handle}" } === null ){
				$this->{ "pt_{$handle}" } = CollectionType::getByHandle( $handle );
			}
			return $this->{ "pt_{$handle}" };
		}
		
		
		/**
		 * @return AttributeType
		 */
		private function attributeType( $atHandle ){
			if( $this->{ "at_{$atHandle}" } === null ){
				$this->{ "at_{$atHandle}" } = AttributeType::getByHandle( $atHandle );
			}
			return $this->{ "at_{$atHandle}" };
		}
		
		
		/**
		 * Get an attribute key category object (eg: an entity category) by its handle
		 * @return AttributeKeyCategory
		 */
		private function attributeKeyCategory( $handle ){
			if( !($this->{ "akc_{$handle}" } instanceof AttributeKeyCategory) ){
				$this->{ "akc_{$handle}" } = AttributeKeyCategory::getByHandle( $handle );
			}
			return $this->{ "akc_{$handle}" };
		}
		
		
		/**
		 * "Memoize" helpers so they're only loaded once.
		 * @param string $handle Handle of the helper to load
		 * @param string $pkg Package to get the helper from
		 * @return ...Helper class of some sort
		 */
		private function getHelper( $handle, $pkg = false ){
			$helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
			if( $this->{$helper} === null ){
				$this->{$helper} = Loader::helper($handle, $pkg);
			}
			return $this->{$helper};
		}
	    
	}
