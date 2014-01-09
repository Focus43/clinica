<?php defined('C5_EXECUTE') or die("Access Denied."); /** @var array $imageList */ ?>

    <div id="flexrySlider-<?php echo $this->controller->bID; ?>" class="owl-carousel">
        <?php foreach($imageList AS $flexryFile): /** @var FlexryFile $flexryFile */ ?>
            <a class="flexryItem" title="<?php echo $flexryFile->getTitle(); ?>" href="<?php echo $flexryFile->getRelativePath(); ?>">
                <span><?php echo $flexryFile->getTitle(); ?></span>
                <img src="<?php echo $flexryFile->thumbnailImgSrc(); ?>" alt="<?php echo $flexryFile->getTitle(); ?>" />
                <p data-descr><?php echo $flexryFile->getDescription(); ?></p>
            </a>
        <?php endforeach; ?>
    </div>

<script type="text/javascript">
    $(function(){
        var $slider = $('#flexrySlider-<?php echo $this->controller->bID; ?>');

        // carousel init
        $slider.owlCarousel({
            theme: 'flexry-theme',
            autoPlay: <?php echo ((bool) $templateData->slider->autoplay) ? 'true' : 'false'; ?>,
            items: <?php echo ($templateData->slider->items >= 1) ? $templateData->slider->items : '3'; ?>,
            navigation: <?php echo ((bool) $templateData->slider->showNavigation) ? 'true' : 'false'; ?>,
            pagination: <?php echo ((bool) $templateData->slider->showPagination) ? 'true' : 'false'; ?>,
            lazyLoad: true
        });

        // lightboxes
        $('.flexryItem', $slider).swipebox({hideBarsDelay:0});
    });
</script>