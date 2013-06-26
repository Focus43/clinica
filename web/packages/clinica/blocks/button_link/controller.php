<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Button Link block
	 */
	class ButtonLinkBlockController extends BlockController {

        const LINKTYPE_PAGE = 1,
              LINKTYPE_URL  = 2,
              // button color classes
              BTN_PRIMARY   = 'btn-primary',
              BTN_INFO      = 'btn-info',
              BTN_SUCCESS   = 'btn-success',
              BTN_WARNING   = 'btn-warning',
              BTN_DANGER    = 'btn-danger',
              BTN_INVERSE   = 'btn-inverse',
              // size
              SIZE_LARGE    = 'btn-large',
              SIZE_SMALL    = 'btn-small',
              SIZE_MINI     = 'btn-mini',
              // width
              WIDTH_AUTO    = 0,
              WIDTH_BLOCK   = 1;

        // array helpers
        public static $btnColors = array(
            ''                  => 'Default (silver)',
            self::BTN_PRIMARY   => 'Primary (blue)',
            self::BTN_INFO      => 'Info (light blue)',
            self::BTN_SUCCESS   => 'Success (green)',
            self::BTN_WARNING   => 'Warning (yellow)',
            self::BTN_DANGER    => 'Danger (red)',
            self::BTN_INVERSE   => 'Inverse (black)'
        );
        
        public static $btnSizes = array(
            ''                  => 'Default',
            self::SIZE_LARGE    => 'Large',
            self::SIZE_SMALL    => 'Small',
            self::SIZE_MINI     => 'Mini'
        );

		protected $btTable 									= 'btButtonLink';
		protected $btInterfaceWidth 						= '325';
		protected $btInterfaceHeight						= '325';
		protected $btCacheBlockRecord 						= true;
		protected $btCacheBlockOutput 						= true;
		protected $btCacheBlockOutputOnPost 				= true;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
        // database fields
        public $pageOrUrl = self::LINKTYPE_PAGE,
               $pageID, 
               $hrefUrl, 
               $buttonColorClass, 
               $buttonSizeClass,
               $fullWidth = self::WIDTH_AUTO,
               $linkText;
        
        
		public function getBlockTypeDescription(){
			return t("Add links styled as buttons");
		}
		
		
		public function getBlockTypeName(){
			return t("Button Link");
		}
        
        
        public function add(){ }
        
        
        public function edit(){ }
		
        
		public function view(){
		    $this->set('linkUrl', $this->getLinkUrl());
            $this->set('classes', $this->getButtonClasses());
            $this->set('linkDisplayText', $this->getLinkDisplayText());
		}
        
        
        /**
         * Get the text to output
         * @return string
         */
        protected function getLinkDisplayText(){
            // custom link text takes priority
            if( !empty($this->linkText) ){
                return $this->linkText;
            }
            
            // if its a sitemap page...
            if( $this->pageOrUrl == self::LINKTYPE_PAGE ){
                return $this->pageObject()->getCollectionName();
            }
            
            // otherwise, just use the full URL
            return $this->hrefUrl;
        }
        
        
        /**
         * Get the classes to apply to the link
         * @return string
         */
        protected function getButtonClasses(){
            return implode(' ', array_filter(array(
                'btn',
                $this->buttonColorClass,
                $this->buttonSizeClass,
                $this->getWidthClass()
            )));
        }
        
        
        /**
         * @return string
         */
        protected function getWidthClass(){
            if( $this->fullWidth == self::WIDTH_BLOCK ){
                return 'btn-block';
            }
        }
		
		
        /**
         * Get the URL to be linked to
         * @return string
         */
        protected function getLinkUrl(){
            // if sitemap page (or sitemap external link)
            if( $this->pageOrUrl == self::LINKTYPE_PAGE ){
                if( $this->pageObject()->isExternalLink() ){
                    return $this->pageObject()->getCollectionPointerExternalLink();
                }
                return View::url( $this->pageObject()->getCollectionPath() );
            }
            // its an external URL
            return $this->hrefUrl;
        }
        
        
        /**
         * Memoize the page object
         * @return Page
         */
        private function pageObject(){
            if( $this->_pageObject === null ){
                $this->_pageObject = Page::getByID( $this->pageID );
            }
            return $this->_pageObject;
        }
		
		
		
		public function save( $data ){
			parent::save( $data );
		}
		
	}