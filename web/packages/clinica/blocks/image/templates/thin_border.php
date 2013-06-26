<? defined('C5_EXECUTE') or die("Access Denied.");
    $imageHelper = Loader::helper('image');
    $imageLink   = $this->controller->getLinkURL();
    $maxWidth    = ($this->controller->maxWidth > 0) ? $this->controller->maxWidth : 900;
    $maxHeight   = ($this->controller->maxHeight > 0) ? $this->controller->maxHeight : 900;
    $thumb       = $imageHelper->getThumbnail($this->controller->getFileObject(), $maxWidth, $maxHeight);
    
    $imageTag    = t('<img class="thumbnail dark" src="%s" alt="%s" />', $thumb->src, $this->controller->getAltText());
?>

<div class="btImage">
    <?php
        if( !empty($imageLink) ){
            echo t('<a href="%s">%s</a>', $imageLink, $imageTag);
        }else{
            echo $imageTag;
        }
    ?>
</div>