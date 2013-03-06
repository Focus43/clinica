<?php

    class HomePageTypeController extends ClinicaPageController {
        
        public function on_start(){
			$this->addFooterItem( $this->getHelper('html')->javascript('libs/backstretch.js', self::PACKAGE_HANDLE) );
        	$this->set('backgroundImage', $this->getPageBackgroundImageURL());
			parent::on_start();
        }
		
		
		protected function getPageBackgroundImageURL(){
			$fileObj = $this->getCollectionObject()->getAttribute('page_background');
			if( $fileObj instanceof File ){
				return $fileObj->getRecentVersion()->getRelativePath();
			}
		}
        
    }