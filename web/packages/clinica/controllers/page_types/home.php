<?php

    class HomePageTypeController extends ClinicaPageController {
        
        protected $includeThemeAssets = true;
        
        public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/backstretch.js', self::PACKAGE_HANDLE) );
        	$this->set('backgroundImage', $this->getPageBackgroundImageURL());
			parent::on_start();
        }
		
		
		protected function getPageBackgroundImageURL(){
			$fileObj = $this->getCollectionObject()->getAttribute('page_background');
			if( $fileObj instanceof File ){
			    return Loader::helper('image')->getThumbnail($fileObj, 1100, 1100)->src;
				//return $fileObj->getRecentVersion()->getRelativePath();
			}
		}
        
    }