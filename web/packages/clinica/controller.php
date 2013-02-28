<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class ClinicaPackage extends Package {
	
	    protected $pkgHandle 			= 'clinica';
	    protected $appVersionRequired 	= '5.6.1';
	    protected $pkgVersion 			= '0.01';
	
		
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
			
			// autoload classes
			Loader::registerAutoload(array(
				// Authorize.net; use Concrete5's autoloader instead of the require statements in AuthorizeNet.php fake autoloader
				'AuthorizeNetException' 	=> array('library', 'authorize_net_exception', $this->pkgHandle),
				'AuthorizeNetRequest' 		=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetRequest', $this->pkgHandle),
				'AuthorizeNetTypes'			=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetTypes', $this->pkgHandle),
				'AuthorizeNetXMLResponse' 	=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetXMLResponse', $this->pkgHandle),
				'AuthorizeNetResponse' 		=> array('library', 'authorize_net_sdk/lib/shared/AuthorizeNetResponse', $this->pkgHandle),
				'AuthorizeNetAIM,AuthorizeNetAIM_Response' => array('library', 'authorize_net_sdk/lib/AuthorizeNetAIM', $this->pkgHandle)
			));
			
			// load the SOAP client, it it exists
			if( class_exists('SoapClient') ){
				Loader::registerAutoload(array('AuthorizeNetSOAP', array('library', 'authorize_net_sdk/lib/AuthorizeNetSOAP', $this->pkgHandle)));
			}
	    }
		
	
		/**
		 * Proxy to the parent uninstall method
		 * @return void
		 */
	    public function uninstall() {
	        parent::uninstall();
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
			$this->setupAttributeSets()
				 ->setupUserGroups()
				 ->setupUserAttributes()
				 ->setupSitePages();
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupAttributeSets(){
			$this->getOrCreateAttributeSet('user_info', 'user');
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupUserGroups(){
			if( !(Group::getByName('Clinica Employees') instanceof Group ) ){
				Group::add('Clinica Employees', 'Employees at Clinica; limited access to certain areas');
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
		private function setupSitePages(){
			$homePage = Page::getByID(1);
			
			$aboutPage = $this->pageFactory($homePage, 'About Clinica');
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
				
			$locationsPage = $this->pageFactory($homePage, 'Our Locations');
				$this->pageFactory($locationsPage, 'Federal Heights');
				$this->pageFactory($locationsPage, 'Lafayette');
				$this->pageFactory($locationsPage, 'Pocos');
				$this->pageFactory($locationsPage, 'People\'s');
				$this->pageFactory($locationsPage, 'Thornton');
				$this->pageFactory($locationsPage, 'Dental');
				$this->pageFactory($locationsPage, 'Administration');
				
			// same idea as "links" page below
			$employeesPage = $this->pageFactory($homePage, 'Employees');
				
			// have a links page where all (most) outgoing links are stored
			$linksPage = $this->pageFactory($homePage, 'Links');
			
			return $this;
		}


		/**
		 * @param Page $parent The parent page that the page being added should go under
		 * @param string $name Name of the page
		 * @param string Handle of the page_type to use
		 * @return Page
		 */
		private function pageFactory( Page $parent, $name, $typeHandle = 'full' ){
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
			if( $this->{ '_pt_' . $handle } === null ){
				$this->{ '_pt_' . $handle } = CollectionType::getByHandle( $handle );
			}
			return $this->{ '_pt_' . $handle };
		}
		
		
		/**
		 * @return AttributeType
		 */
		private function attributeType( $atHandle ){
			if( $this->{'at_' . $atHandle} === null ){
				$this->{'at_' . $atHandle} = AttributeType::getByHandle( $atHandle );
			}
			return $this->{'at_' . $atHandle};
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
