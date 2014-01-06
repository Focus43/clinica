<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Flexry Gallery block
	 */
	class FlexryGalleryBlockController extends BlockController {

        const CROP_FALSE                = 0,
              CROP_TRUE                 = 1,
              FULL_USE_ORIGINAL_FALSE   = 0,
              FULL_USE_ORIGINAL_TRUE    = 1;

		protected $btTable 									= 'btFlexryGallery';
		protected $btInterfaceWidth 						= '710';
		protected $btInterfaceHeight						= '450';
		protected $btCacheBlockRecord 						= false;
		protected $btCacheBlockOutput 						= false;
		protected $btCacheBlockOutputOnPost 				= false;
		protected $btCacheBlockOutputForRegisteredUsers 	= false;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
        // database fields
        public  $fileIDs,
                $thumbWidth         = 250,
                $thumbHeight        = 250,
                $thumbCrop          = self::CROP_FALSE,
                $fullUseOriginal    = self::FULL_USE_ORIGINAL_TRUE,
                $fullWidth,  // not required
                $fullHeight, // not required
                $fullCrop       = self::CROP_FALSE;
        
        
		public function getBlockTypeDescription(){
			return t("Flexible Image Gallery Management");
		}
		
		
		public function getBlockTypeName(){
			return t("Flexry Gallery");
		}
        
        
        public function add(){
            $this->edit();
        }
        
        
        public function edit(){
            $this->set('imageList', $this->fileListResults());
        }
		
        
		public function view(){
            $this->set('imageList', $this->fileListResults());
		}


        /**
         * Get the results from the prepared FileListObj.
         * @return array
         */
        protected function fileListResults(){
            if( $this->_fileListResults === null ){
                // get the results
                $this->_fileListResults = $this->fileListObj()->get();
            }
            return $this->_fileListResults;
        }


        /**
         * Get the FileList object (before a query ->get() is executed!), with the fileID
         * filter applied.
         * @return FlexryFileList
         */
        private function fileListObj(){
            if( $this->_fileListObj === null ){
                $this->_fileListObj = new FlexryFileList( $this->record );
            }
            return $this->_fileListObj;
        }


        /**
         * Save block data.
         * @param array $data
         */
        public function save( $data ){
            // persist in the join table
            $this->persistFiles( (array) $data['fileIDs'] );
            // main block data
            $blockData                      = array();
            $blockData['thumbWidth']        = (int) $data['thumbWidth'];
            $blockData['thumbHeight']       = (int) $data['thumbHeight'];
            $blockData['thumbCrop']         = (int) $data['thumbCrop'];
            $blockData['fullUseOriginal']   = (int) $data['fullUseOriginal'];
            $blockData['fullWidth']         = (int) $data['fullWidth'];
            $blockData['fullHeight']        = (int) $data['fullHeight'];
            $blockData['fullCrop']          = (int) $data['fullCrop'];
			parent::save( $blockData );
		}


        /**
         * When this gets run, it *always* first deletes any existing records (instead of going
         * through and updating).
         * @param array $fileIDs
         * @return void
         */
        protected function persistFiles( array $fileIDs = array() ){
            $db = Loader::db();
            $db->Execute("DELETE FROM btFlexryGalleryFiles WHERE bID = ?", array( $this->bID ));
            foreach( $fileIDs AS $orderIndex => $fileID ){
                $db->Execute("INSERT INTO btFlexryGalleryFiles (bID, fileID, displayOrder) VALUES(?,?,?)", array(
                    $this->bID, $fileID, ($orderIndex + 1)
                ));
            }
        }


        /**
         * "Memoize" helpers so they're only loaded once.
         * @param string $handle Handle of the helper to load
         * @param string $pkg Package to get the helper from
         * @return ...Helper class of some sort
         */
        public function getHelper( $handle, $pkg = false ){
            $helper = '_helper_' . preg_replace("/[^a-zA-Z0-9]+/", "", $handle);
            if( $this->{$helper} === null ){
                $this->{$helper} = Loader::helper($handle, $pkg);
            }
            return $this->{$helper};
        }
		
	}