<?php defined('C5_EXECUTE') or die("Access Denied.");

    class ContentBlockController extends Concrete5_Controller_Block_Content {
        
        private function replaceImageID( $match ){
            $fID = $match[1];
            if( $fID > 0 ){
                $file = File::getByID($fID);
                if (is_object($file) && (!$file->isError())) {
                    $imgHelper = Loader::helper('image');
                    $thumb = $imgHelper->getThumbnail($file, 900, 0);
                    return '<img class="thumbnail" src="'.$thumb->src.'" width="'.$thumb->width.'" alt="'.$file->getTitle().'" />';
                }
            }
            return $match[0];
        }
        
    }
    