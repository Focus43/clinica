<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class MissGreekPackage extends Package {
	
	    protected $pkgHandle 			= 'miss_greek';
	    protected $appVersionRequired 	= '5.6.1';
	    protected $pkgVersion 			= '0.01';
	
		
		/**
		 * @return string
		 */
	    public function getPackageName(){
	        return t('Miss Greek');
	    }
		
		
		/**
		 * @return string
		 */
	    public function getPackageDescription() {
	        return t('Miss Greek site and assets.');
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
	        $this->checkDependencies();
			parent::upgrade();
			$this->installAndUpdate();
	    }
		
		
		/**
		 * @return void
		 */
		public function install() {
		    $this->checkDependencies();
	    	$this->_packageObj = parent::install(); 
			$this->installAndUpdate();
	    }
        
        
        /**
         * Run before install or upgrade to ensure dependencies are present
         * @dependency concrete_redis package
         */
        private function checkDependencies(){
            // test for the redis package
            $redisPackage       = Package::getByHandle('concrete_redis');
            $redisPackageAvail  = false;
            if( $redisPackage instanceof Package ){
                if( (bool) $redisPackage->isPackageInstalled() ){
                    $redisPackageAvail = true;
                }
            }
            
            if( !$redisPackageAvail ){
                throw new Exception('Miss Greek requires the ConcreteRedis package.');
            }
            
            // test for the clinica package
            $clinicaPackage       = Package::getByHandle('clinica');
            $clinicaPackageAvail  = false;
            if( $clinicaPackage instanceof Package ){
                if( (bool) $clinicaPackage->isPackageInstalled() ){
                    $clinicaPackageAvail = true;
                }
            }
            
            if( !$clinicaPackageAvail ){
                throw new Exception('Miss Greek requires the Clinica package.');
            }
        }
		
		
		/**
		 * Handle all the updating methods
		 * @return void
		 */
		private function installAndUpdate(){
			$this->setupTheme()
				 ->setupPageTypes();
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupTheme(){            
            // miss greek theme
            try {
                PageTheme::add('miss_greek', $this->packageObject());
            }catch(Exception $e){ /* fail gracefully */ }
			
			return $this;
		}
		
		
		/**
		 * @return ClinicaPackage
		 */
		private function setupPageTypes(){            
            if( !is_object($this->pageType('miss_greek')) ){
                CollectionType::add(array('ctHandle' => 'miss_greek', 'ctName' => 'Miss Greek'), $this->packageObject());
            }

			return $this;
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
