<?php

    class MissGreekPageTypeController extends ClinicaPageController {
        
        protected $requireHttps = true;
        
        public function on_start(){
            $this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
            $this->addHeaderItem( $this->getHelper('html')->css('bootstrap.min.css', self::PACKAGE_HANDLE) );
            $this->addHeaderItem( $this->getHelper('html')->css('miss_greek.css', self::PACKAGE_HANDLE) );
            $this->addHeaderItem( $this->getHelper('html')->javascript('libs/modernizr.min.js', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->getHelper('html')->javascript('libs/bootstrap.min.js', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->getHelper('html')->javascript('libs/backstretch.js', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->getHelper('html')->javascript('miss_greek.js', self::PACKAGE_HANDLE) );
        }
        
    }