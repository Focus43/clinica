<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Flexry Gallery block
	 */
	class FlexryGalleryBlockController extends BlockController {

        const CROP_FALSE                = 0,
              CROP_TRUE                 = 1,
              FULL_USE_ORIGINAL_FALSE   = 0,
              FULL_USE_ORIGINAL_TRUE    = 1,
              FILE_SOURCE_METHOD_CUSTOM = 0,
              FILE_SOURCE_METHOD_SETS   = 1;

        // file source selection method
        public static $fileSourceMethods = array(
            self::FILE_SOURCE_METHOD_CUSTOM => 'Custom Gallery',
            self::FILE_SOURCE_METHOD_SETS   => 'Pull From File Set(s)'
        );

		protected $btTable 									= 'btFlexryGallery';
		protected $btInterfaceWidth 						= '710';
		protected $btInterfaceHeight						= '450';
		protected $btCacheBlockRecord 						= false;
		protected $btCacheBlockOutput 						= false;
		protected $btCacheBlockOutputOnPost 				= false;
		protected $btCacheBlockOutputForRegisteredUsers 	= false;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;

        // defaults
        public  $fileSourceMethod   = self::FILE_SOURCE_METHOD_CUSTOM,
                $fileSetIDs         = null,
                $thumbWidth         = 250,
                $thumbHeight        = 250,
                $thumbCrop          = self::CROP_FALSE,
                $fullUseOriginal    = self::FULL_USE_ORIGINAL_TRUE,
                $fullWidth,  // no default
                $fullHeight, // no default
                $fullCrop           = self::CROP_FALSE;


        /**
         * @return string
         */
        public function getBlockTypeDescription(){
			return t("Flexible Image Gallery Management");
		}


        /**
         * @return string
         */
        public function getBlockTypeName(){
			return t("Flexry Gallery");
		}


        /**
         * Controller method (proxies to the edit() method).
         * @return void
         */
        public function add(){
            $this->edit();
        }


        /**
         * Controller method.
         * @return void
         */
        public function edit(){
            $this->set('imageList', $this->fileListResults());
            $this->set('availableFileSets', $this->availableFileSets());
            $this->set('savedFileSets', $this->savedFileSets());
        }


        /**
         * Controller method.
         * @return void
         */
        public function view(){
            $this->set('imageList', $this->fileListResults());
		}


        /**
         * Get the results from the prepared FileListObj.
         * @return array : of FlexryFile objects
         */
        protected function fileListResults(){
            if( $this->_fileListResults === null ){
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
         * Get an array of file set IDs.
         * @return array
         */
        private function savedFileSets(){
            if( $this->_savedFileSets === null ){
                $this->_savedFileSets = (array) $this->getHelper('json')->decode( $this->fileSetIDs );
            }
            return $this->_savedFileSets;
        }


        /**
         * Get an array of existing FileSet objects (all available in the
         * @return array
         */
        private function availableFileSets(){
            if( $this->_availableFileSets === null ){
                $fileSetListObj = new FileSetList;
                $this->_availableFileSets = $fileSetListObj->get();
            }
            return $this->_availableFileSets;
        }


        /**
         * Save block data.
         * @param array $data
         */
        public function save( $data ){
            // validate that shit first
            $this->validate( $data );
            // persist in the join table
            $this->persistFiles( (array) $data['fileIDs'] );
            // main block data
            $blockData                      = array();
            $blockData['fileSourceMethod']  = (int) $data['fileSourceMethod'];
            $blockData['fileSetIDs']        = $this->getHelper('json')->encode( (array) $data['fileSetIDs'] );
            $blockData['thumbWidth']        = (int) $data['thumbWidth'];
            $blockData['thumbHeight']       = (int) $data['thumbHeight'];
            $blockData['thumbCrop']         = (int) $data['thumbCrop'];
            $blockData['fullUseOriginal']   = (int) $data['fullUseOriginal'];
            $blockData['fullWidth']         = (int) $data['fullWidth'];
            $blockData['fullHeight']        = (int) $data['fullHeight'];
            $blockData['fullCrop']          = (int) $data['fullCrop'];
            // persist it
			parent::save( $blockData );
		}


        /**
         * Validate the submitted block data.
         * @param $data
         * @return ValidationErrorHelper
         */
        public function validate( $data ){
            // if using file sets, make sure at least one is selected
            if( ((int)$data['fileSourceMethod'] === self::FILE_SOURCE_METHOD_SETS) && (count( (array)$data['fileSetIDs'] ) === 0) ){
                $this->getHelper('validation/error')->add('At least one File Set must be selected.');
            }
            // thumbnail width
            if( !( (int)$data['thumbWidth'] >= 1) ){ $this->getHelper('validation/error')->add('Thumbnail Width must be >= 1.'); }
            // thumbnail height
            if( !( (int)$data['thumbHeight'] >= 1) ){ $this->getHelper('validation/error')->add('Thumbnail Height must be >= 1.'); }
            // if the full size image is *not* set to use original, then validate the sizes
            if( !( (int)$data['fullUseOriginal'] === self::FULL_USE_ORIGINAL_TRUE ) ){
                // full width
                if( !( (int)$data['fullWidth'] >= 1) ){ $this->getHelper('validation/error')->add('Full Width must be >= 1.'); }
                // full height
                if( !( (int)$data['fullHeight'] >= 1) ){ $this->getHelper('validation/error')->add('Full Height must be >= 1.'); }
            }

            return $this->getHelper('validation/error');
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