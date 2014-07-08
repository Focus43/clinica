<?php defined('C5_EXECUTE') or die(_("Access Denied."));

    class ClinicaFileEvents {

        /**
         * When a file gets added to the 'secure_files' set, this handles moving the file
         * to a secured alternative storage location.
         * @param $fileID
         * @param $fileSetID
         */
        public function onFileAddedToSet( $fileID, $fileSetID ){
            $fileSetObj = FileSet::getByID($fileSetID);

            if( $fileSetObj->getFileSetName() === ClinicaPackage::FILESET_PROCEDURE_FORMS ){
                Loader::model('file_storage_location');

                $fileObj  = File::getByID($fileID);
                $location = FileStorageLocation::getByID(FileStorageLocation::ALTERNATE_ID);

                if( (int)$fileObj->getStorageLocationID() !==  (int)$location->getID() ){
                    $fileObj->setStorageLocation($location);
                }
            }
        }

    }