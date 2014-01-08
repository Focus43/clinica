<?php defined('C5_EXECUTE') or die("Access Denied.");

    class FlexryFileList extends FileList {

        /** @var BlockRecord $_blockRecord */
        protected $_blockRecord;

        /**
         * Using the FlexryFileList *requires* that a block record be passed in to use it.
         * @param BlockRecord $record
         */
        public function __construct( BlockRecord $record = null ){
            // cloning it retains ghetto immutability...
            $this->_blockRecord = is_null($record) ? new BlockRecord : clone $record;
            $this->_requiredFilters();
        }


        /**
         * Takes data from the block record and figures out how to apply required fitlers to
         * the list.
         * @return void
         */
        private function _requiredFilters(){
            // are we using a custom file source method?
            if( (int) $this->_blockRecord->fileSourceMethod === FlexryGalleryBlockController::FILE_SOURCE_METHOD_CUSTOM ){
                $this->addToQuery("RIGHT JOIN btFlexryGalleryFiles flxry ON flxry.fileID = f.fID");
                $this->filter('flxry.bID', (int) $this->_blockRecord->bID, '=');
                $this->sortBy('flxry.displayOrder', 'asc');
                return;
            }

            // no, we're using File Sets
            $fileSetIDs = (array) Loader::helper('json')->decode( $this->_blockRecord->fileSetIDs );
            // if more than one file set is being used
            if( count($fileSetIDs) > 1 ){
                $orFilters = array();
                foreach($fileSetIDs AS $fsID){
                    array_push($orFilters, t('fsID = %s', (int) $fsID));
                }
                $this->addToQuery("LEFT JOIN FileSetFiles fsfl ON fsfl.fID = f.fID");
                $this->filter(false, t('f.fID IN (SELECT DISTINCT fID FROM FileSetFiles WHERE %s)', join(" OR ", $orFilters)));
            }
            // if only one
            if( count($fileSetIDs) === 1 ){
                $this->filteredFileSetIDs = $fileSetIDs;
                $this->sortByFileSetDisplayOrder();
            }
        }


        /**
         * Override the base get() method and return the FlexryFile object instead of
         * the default File object.
         * @return array
         */
        public function get($itemsToGet = 0, $offset = 0) {
            $files = array();
            $this->createQuery();
            $r = DatabaseItemList::get($itemsToGet, $offset);
            foreach($r as $row) {
                $flexryFile = FlexryFile::getByID($row['fID']);
                $flexryFile->setFlexryBlockInstance( $this->_blockRecord );
                $files[] = $flexryFile;
            }
            return $files;
        }

    }