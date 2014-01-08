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
        // owl carousel init
        $slider.owlCarousel({
            theme: 'flexry-theme',
            items: 3,
            navigation: true,
            pagination: false,
            lazyLoad: true
        });

        // lightboxes
        $('.flexryItem', $slider).swipebox({hideBarsDelay:0});
    });
</script>