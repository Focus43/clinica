<?php defined('C5_EXECUTE') or die("Access Denied."); /** @var array $imageList */

    foreach($imageList AS $flexryFile){ /** @var FlexryFile $flexryFile */
        echo '<img src="'.$flexryFile->thumbnailImgSrc().'" />';
    }