<?php

    /**
     * Class FlexryImage
     * This just acts as a wrapper for resizing images, and caching the File and FileVersion
     * objects (only if they're called).
     */
    class FlexryImage {

        protected static $_imageHelper;

        protected $fileObj, $maxWidth, $maxHeight, $crop;

        /**
         * Build a new FlexryImage container object.
         * @param File $fileObj
         * @param $maxWidth
         * @param $maxHeight
         * @param bool $crop
         */
        public function __construct( File $fileObj, $maxWidth, $maxHeight, $crop = false ){
            $this->fileObj      = $fileObj;
            $this->maxWidth     = (int) $maxWidth;
            $this->maxHeight    = (int) $maxHeight;
            $this->crop         = (bool) $crop;
        }


        /**
         * @return File
         */
        public function getFileObj(){
            return $this->fileObj;
        }


        /**
         * @return FileVersion
         */
        public function getFileVersionObj(){
            if( $this->_fileVersionObj === null ){
                $this->_fileVersionObj = $this->getFileObj()->getApprovedVersion();
            }
            return $this->_fileVersionObj;
        }


        /**
         * Get the width of the image after its been resized.
         * @return int
         */
        public function getWidth(){
            if( $this->_rszdWidth === null ){
                $this->_rszdWidth = $this->resizedImageObj()->width;
            }
            return $this->_rszdWidth;
        }


        /**
         * Get the height of the image after its been resized.
         * @return int
         */
        public function getHeight(){
            if( $this->_rszdHeight === null ){
                $this->_rszdHeight = $this->resizedImageObj()->height;
            }
            return $this->_rszdHeight;
        }


        /**
         * Get the path to the resized image asset.
         * @return string
         */
        public function getSrc(){
            if( $this->_rszdSrc === null ){
                $this->_rszdSrc = $this->resizedImageObj()->src;
            }
            return $this->_rszdSrc;
        }


        /**
         * Process the image to resize it, and memoize it so its only generated once.
         * @return stdObj; properties ->src, ->width, ->height
         */
        protected function resizedImageObj(){
            if( $this->_resizedImageObj === null ){
                $this->_resizedImageObj = self::imageHelper()->getThumbnail($this->fileObj, $this->maxWidth, $this->maxHeight, $this->crop);
            }
            return $this->_resizedImageObj;
        }


        /**
         * Get and memoize the image helper, so only has to load the class once.
         * @return ImageHelper
         */
        protected static function imageHelper(){
            if( self::$_imageHelper === null ){
                self::$_imageHelper = Loader::helper('image');
            }
            return self::$_imageHelper;
        }

    }