<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class MasonryGridPackage extends Package {
	
	    protected $pkgHandle 			= 'masonry_grid';
	    protected $appVersionRequired 	= '5.6.1';
	    protected $pkgVersion 			= '0.12';
	
		
		/**
		 * @return string
		 */
	    public function getPackageName(){
	        return t('Masonry Grid');
	    }
		
		
		/**
		 * @return string
		 */
	    public function getPackageDescription() {
	        return t('Display content in a unique grid-style, auto-arranging layout.');
	    }
	
		
		/**
		 * Run hooks high up in the load chain
		 * @return void
		 */
	    public function on_start(){
	        define('MASONRY_TOOLS_URL', REL_DIR_FILES_TOOLS_PACKAGES . '/' . $this->pkgHandle . '/');
			define('MASONRY_IMAGES_URL', DIR_REL . '/packages/' . $this->pkgHandle . '/images/');
			
			// autoload classes
			Loader::registerAutoload(array(
				'MasonryFileList' => array('model', 'masonry_file_list', $this->pkgHandle)
			));
	    }
		
	
		/**
		 * Proxy to the parent uninstall method
		 * @return void
		 */
	    public function uninstall() {
	        parent::uninstall();
			
			try {
				$db = Loader::db();
				//$db->Execute("DROP TABLE ClinicaTransaction");
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
			$this->setupAttributeSets()
				 ->setupBlocks()
				 ->setupPages();
		}
		
		
		/**
		 * @return MasonryGridPackage
		 */
		private function setupAttributeSets(){
			//$this->getOrCreateAttributeSet('masonry', 'file');
			
			return $this;
		}


		/**
		 * @return MasonryGridPackage
		 */
		private function setupBlocks(){			
			// Masonry Gallery
			if(!is_object(BlockType::getByHandle('masonry_gallery'))) {
				BlockType::installBlockTypeFromPackage('masonry_gallery', $this->packageObject());
			}
			
			return $this;
		}
		
		
		/**
		 * @return MasonryGridPackage
		 */
		private function setupPages(){
			SinglePage::add('/dashboard/masonry_grid/', $this->packageObject());
			$settings = SinglePage::add('/dashboard/masonry_grid/settings', $this->packageObject());
			if( is_object(($settings)) ){
				$settings->setAttribute('icon_dashboard', 'icon-th-large');
			}
			
			return $this;
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
