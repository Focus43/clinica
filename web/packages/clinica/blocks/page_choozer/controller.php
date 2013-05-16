<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Page list picker
	 */
	class PageChoozerBlockController extends BlockController {

		protected $btTable 									= 'btPageChoozer';
		protected $btInterfaceWidth 						= '350';
		protected $btInterfaceHeight						= '400';
		protected $btCacheBlockRecord 						= true;
		protected $btCacheBlockOutput 						= true;
		protected $btCacheBlockOutputOnPost 				= true;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
		public $serializedPageIDs;
		
		public function getBlockTypeDescription(){
			return t("Choose Manual Lists of Pages");
		}
		
		
		public function getBlockTypeName(){
			return t("PageChoozer");
		}
		
		
		public function view(){ $this->set('pageCollection', $this->pageCollection()); }
		public function add(){ $this->set('pageCollection', $this->pageCollection()); }
		public function edit(){ $this->set('pageCollection', $this->pageCollection()); }
		
		
		/**
		 * @return array Of page objects
		 */
		public function pageCollection(){
			$pageCollection = array();
			
			$pageIds = Loader::helper('json')->decode( $this->serializedPageIDs );
			if( is_array($pageIds) && !empty($pageIds) ){
				foreach($pageIds AS $pageID){
					$pageCollection[] = Page::getByID( $pageID );
				}
			}
			
			return $pageCollection;
		}
		
		
		public function save( $data ){
			// remove any array elements with value "0" (user clicked add, but didnt choose a page)
			$pageIDs = array_values( array_diff($data['chosenPages'], array('0')) );
			$args['serializedPageIDs'] = Loader::helper('json')->encode( $pageIDs );
			parent::save( $args );
		}
		
	}