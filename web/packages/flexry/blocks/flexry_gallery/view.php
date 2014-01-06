<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var array $thumbnailList : Array of FlexryImage objects */

    foreach($thumbnailList AS $flexryImage){ /** @var FlexryImage $flexryImage */ ?>
        <img src="<?php echo $flexryImage->getSrc(); ?>" alt="<?php echo $flexryImage->getFileVersionObj()->getTitle(); ?>" />
    <?php }