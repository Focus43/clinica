<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var array $thumbnailList : Array of FlexryImage objects */

    foreach($imageList AS $flexryFile){ /** @var FlexryFile $flexryFile */
        echo '<img src="'.$flexryFile->thumbnailImgSrc().'" />';
        echo '<img src="'.$flexryFile->fullImgSrc().'" />';
    }

    /*foreach($thumbnailList AS $flexryImage){ /** @var FlexryImage $flexryImage ?>
        <img src="<?php echo $flexryImage->getSrc(); ?>" alt="<?php echo $flexryImage->getFileVersionObj()->getTitle(); ?>" />
    <?php }*/