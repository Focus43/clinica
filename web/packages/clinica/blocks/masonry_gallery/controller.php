<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Page list picker
	 */
	class MasonryGalleryBlockController extends BlockController {

		protected $btTable 									= 'btMasonryGallery';
		protected $btInterfaceWidth 						= '450';
		protected $btInterfaceHeight						= '400';
		protected $btCacheBlockRecord 						= true;
		protected $btCacheBlockOutput 						= true;
		protected $btCacheBlockOutputOnPost 				= true;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
		public $fileSetID,
			   $showTitleOverlay = 0,
			   $maxWidth = 250;
			   
		
		public function getBlockTypeDescription(){
			return t("Cool masonry layout for image sets.");
		}
		
		
		public function getBlockTypeName(){
			return t("Masonry Gallery");
		}
		
		
		public function view(){
			$this->set('imagesList', $this->imagesList());
			$this->set('imageHelper', Loader::helper('image'));
		}
		
		public function add(){
			$this->set('availableFileSets', $this->availableFileSets());
		}
		
		public function edit(){
			$this->set('availableFileSets', $this->availableFileSets());
		}
		
		
		private function imagesList(){
			if( $this->_imagesList === null ){
				$fileListObj = new FileList;
				$fileListObj->filterBySet( FileSet::getByID($this->fileSetID) );
				$this->_imagesList = $fileListObj->get();
			}
			return $this->_imagesList;
		}
		
		
		private function availableFileSets(){
			if( $this->_availableFileSets === null ){
				$this->_availableFileSets = array();
				$list = new FileSetList;
				$sets = $list->get();
				foreach($sets AS $setObj){
					$this->_availableFileSets[ $setObj->getFileSetID() ] = $setObj->getFileSetName();
				}
			}
			return $this->_availableFileSets;
		}
		
		
		public function save( $data ){
			$args['fileSetID'] 			= (int) $data['fileSetID'];
			$args['showTitleOverlay']	= (int) $data['showTitleOverlay'];
			$args['maxWidth']			= (int) $data['maxWidth'];
			parent::save( $args );
		}
		
	}