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


        private function _requiredFilters(){
            $this->addToQuery("RIGHT JOIN btFlexryGalleryFiles flxry ON flxry.fileID = f.fID");
            $this->filter('flxry.bID', (int) $this->_blockRecord->bID, '=');
            $this->sortBy('flxry.displayOrder', 'asc');
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