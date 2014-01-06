<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Flexry Gallery block
	 */
	class FlexryGalleryBlockController extends BlockController {

        const CROP_FALSE = 0,
              CROP_TRUE  = 1;

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
                $thumbWidth     = 250,
                $thumbHeight    = 250,
                $thumbCrop      = self::CROP_FALSE,
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
            $this->set('imageList', $this->fileVersionListResults());
        }
		
        
		public function view(){
            $this->set('thumbnailList', $this->thumbnailList());
		}


        /**
         * Get a list of stdObj's containing the resized thumbnail data, and the associated
         * File and FileVersion objects.
         * @return array : Properties ->src, ->width, ->height, ->fileObj
         */
        public function thumbnailList(){
            if( $this->_thumbnailList === null ){
                $this->_thumbnailList = array();
                foreach($this->fileListResults() AS $fileObj){ /** @var File $fileObj */
                    // create the FlexryImage
                    $flexryImage = new FlexryImage($fileObj, $this->thumbWidth, $this->thumbHeight, $this->thumbCrop);
                    // push onto the result stack
                    array_push($this->_thumbnailList, $flexryImage);
                }
            }
            return $this->_thumbnailList;
        }


        /**
         * Get the FileVersion objects for each File object returned in the FileListResults.
         * @return array
         */
        protected function fileVersionListResults(){
            if( $this->_fileVersionListResults === null ){
                /** @var File $fileObj */
                $this->_fileVersionListResults = array_map(function( $fileObj ){
                    return $fileObj->getApprovedVersion();
                }, $this->fileListResults());
            }
            return $this->_fileVersionListResults;
        }


        /**
         * Get the results from the prepared FileListObj.
         * @return array
         */
        protected function fileListResults(){
            if( $this->_fileListResults === null ){
                // the json'ified array of fileIDs in the database
                $savedList = (array) $this->getHelper('json')->decode($this->fileIDs);
                // assuming block list isn't empty; apply filter of the fileIDs
                if( !empty($savedList) ){
                    $this->fileListObj()->filter(false, 'f.fID IN ('.join(',', $savedList).')');
                    $this->_fileListResults = $this->fileListObj()->get();
                }else{
                    $this->_fileListResults = array();
                }
            }
            return $this->_fileListResults;
        }


        /**
         * Get the FileList object (before a query ->get() is executed!), with the fileID
         * filter applied.
         * @return FileList
         */
        private function fileListObj(){
            if( $this->_fileListObj === null ){
                // set FileList object no matter what
                $this->_fileListObj = new FileList;
            }
            return $this->_fileListObj;
        }


        /**
         * Save block data.
         * @param array $data
         */
        public function save( $data ){
            $data['fileIDs']        = $this->getHelper('json')->encode($data['fileIDs']);
            $data['thumbWidth']     = (int) $data['thumbWidth'];
            $data['thumbHeight']    = (int) $data['thumbHeight'];
            $data['thumbCrop']      = (int) $data['thumbCrop'];
            $data['fullWidth']      = (int) $data['fullWidth'];
            $data['fullHeight']     = (int) $data['fullHeight'];
            $data['fullCrop']       = (int) $data['fullCrop'];
			parent::save( $data );
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