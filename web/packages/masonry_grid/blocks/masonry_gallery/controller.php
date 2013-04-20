<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Masonry Gallery
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
		
		public $fileSetIDs,
			   $showFileSetFilters 	= 0,
			   $enableModals		= 0,
			   $maxWidth 		 	= 250,
			   $padding			 	= 3,
			   $margin			 	= 3,
			   $pagingResults		= 15;
			   
		
		public static $pagingOptions = array(
			'10' => '10',
			'15' => '15',
			'20' => '20',
			'25' => '25',
			'30' => '30'
		);
			   
		
		public function getBlockTypeDescription(){
			return t("Cool masonry layout for image sets.");
		}
		
		
		public function getBlockTypeName(){
			return t("Masonry Gallery");
		}
		
		
		public function view(){
			$this->set('imagesList', $this->masonryFileList()->get( $this->pagingResults ));
			$this->set('fileSetObjects', $this->getSelectedFileSetObjects());
			$this->set('imageHelper', Loader::helper('image'));
			$this->set('textHelper', Loader::helper('text'));
		}
		
		public function add(){
			$this->set('availableFileSets', $this->availableFileSets());
			$this->set('selectedFileSetIDs', array());
		}
		
		public function edit(){
			$this->set('availableFileSets', $this->availableFileSets());
			$this->set('selectedFileSetIDs', $this->getSelectedFileSetIds());
		}
		
		public function on_page_view(){
			if( Config::get('MASONRY_CONFIG_INCLUDE_MODERNIZR') ){
				$this->addHeaderItem( Loader::helper('html')->javascript('modernizr.min.js', 'masonry_grid') );
			}
		}
		
		
		public function getContainerID(){ return "masonryBlock-{$this->bID}"; }
		public function getItemClass(){ return "masonryItem-{$this->bID}"; }
		public function getColumnWidth(){ return $this->maxWidth + ($this->margin * 2) + ($this->padding * 2); }
		public function getFilterListID(){ return "masonryFilters-{$this->bID}"; }
		
		
		/**
		 * Get the full URL to the block tools directory
		 * @return string
		 */
		public function getBlockToolsURL( $resource = null ){
			if( $this->_btUrl === null ){
				$this->_btUrl = Loader::helper('concrete/urls')->getBlockTypeToolsURL(BlockType::getByHandle('masonry_gallery'));
			}
			return $resource ? "{$this->_btUrl}/$resource" : $this->_btUrl;
		}
		
		
		public function getFileSetsString( File $fileObj ){
			return join(" ", array_map(array($this, 'callbackFileSetsString'), $fileObj->getFileSets()));
		}
		
		
		private function callbackFileSetsString( FileSet $fileSetObj ){
			return $this->getHelper('text')->handle($fileSetObj->getFileSetName());
		}
		
		
		private function getSelectedFileSetObjects(){
			if( $this->_selectedFileSetObjects === null ){
				$this->_selectedFileSetObjects = array();
				foreach( $this->getSelectedFileSetIds() AS $fsID ){
					$this->_selectedFileSetObjects[] = FileSet::getByID( $fsID );
				}
			}
			return $this->_selectedFileSetObjects;
		}
		
		
		private function getSelectedFileSetIds(){
			if( $this->_selectedFileSetIDs === null ){
				$this->_selectedFileSetIDs = explode(',', $this->fileSetIDs);
			}
			return $this->_selectedFileSetIDs;
		}
		
		
		public function masonryFileList(){
			if( $this->_masonryFileListObj === null ){
				$this->_masonryFileListObj = new MasonryFileList( $this->getSelectedFileSetIds() );
			}
			return $this->_masonryFileListObj;
		}
		
		
		private function availableFileSets(){
			if( $this->_availableFileSets === null ){
				$list = new FileSetList;
				$this->_availableFileSets = $list->get();
			}
			return $this->_availableFileSets;
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
		
		
		public function save( $data ){
			// validation
			if( empty($_REQUEST['fileSetIDs']) ){
				throw new Exception('At least one file set must be selected');
			}
			
			$args['fileSetIDs'] 		= join(',', $_REQUEST['fileSetIDs']);
			$args['showFileSetFilters']	= (int) $data['showFileSetFilters'];
			$args['enableModals']		= (int) $data['enableModals'];
			$args['maxWidth']			= (int) $data['maxWidth'];
			$args['margin']				= (int) $data['margin'];
			$args['padding']			= (int) $data['padding'];
			$args['pagingResults']		= (int) $data['pagingResults'];
			parent::save( $args );
		}
		
	}