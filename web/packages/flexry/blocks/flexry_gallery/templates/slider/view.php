<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var array $thumbnailList : Array of FlexryImage objects */
?>

    <div id="flexrySlider-<?php echo $this->controller->bID; ?>" class="owl-carousel">
        <?php foreach($thumbnailList AS $flexryImage): /** @var FlexryImage $flexryImage */ ?>
            <a class="flexryItem" title="<?php echo $flexryImage->getFileVersionObj()->getTitle(); ?>" href="<?php echo $flexryImage->getFileVersionObj()->getRelativePath(); ?>">
                <span><?php echo $flexryImage->getFileVersionObj()->getTitle(); ?></span>
                <img src="<?php echo $flexryImage->getSrc(); ?>" alt="Gallery Image" />
                <p data-descr><?php echo $flexryImage->getFileVersionObj()->getDescription(); ?></p>
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
        $('.flexryItem', $slider).swipebox({hideBarsDelay:0, beforeOpen: function(){
            setTimeout(function(){
                if ($.swipebox.isOpen){
                    $('#swipebox-prev,#swipebox-next').on('click', function(){

                    });
                }
            },500);
        }});
    });
</script>