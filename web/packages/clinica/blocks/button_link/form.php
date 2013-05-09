<?php defined('C5_EXECUTE') or die("Access Denied.");
	$pageSelector = Loader::helper('form/page_selector');
    $formHelper   = Loader::helper('form');
?>

	<style type="text/css">
	   #buttonLink.ccm-ui h4,
	   #buttonLink.ccm-ui .form-inline {padding:.5em 0;}
	   #buttonLink.ccm-ui h4:first-child {padding:0;}
	   #buttonLink.ccm-ui .ccm-summary-selected-item {margin:.2em 0;}
	   #buttonLink.ccm-ui .toggleable {display:none;}
	</style>

	<div id="buttonLink" class="ccm-ui">
	    <h4>Button Type</h4>
	    <div class="form-inline">
	        <label>
	            <?php echo $formHelper->radio('pageOrUrl', ButtonLinkBlockController::LINKTYPE_PAGE, $this->controller->pageOrUrl); ?> Sitemap Page
	        </label>
	        &nbsp;&nbsp;<label>
	            <?php echo $formHelper->radio('pageOrUrl', ButtonLinkBlockController::LINKTYPE_URL, $this->controller->pageOrUrl); ?> External URL
	        </label>
	    </div>
	    <div class="toggleable" data-toggle-on="<?php echo ButtonLinkBlockController::LINKTYPE_PAGE; ?>" style="<?php echo ($this->controller->pageOrUrl == ButtonLinkBlockController::LINKTYPE_PAGE) ? 'display:block;' : ''; ?>">
	        <?php echo $pageSelector->selectPage('pageID', $this->controller->pageID); ?>
	    </div>
	    <div class="toggleable" data-toggle-on="<?php echo ButtonLinkBlockController::LINKTYPE_URL; ?>" style="<?php echo ($this->controller->pageOrUrl == ButtonLinkBlockController::LINKTYPE_URL) ? 'display:block;' : ''; ?>">
	        <?php echo $formHelper->text('hrefUrl', $this->controller->hrefUrl, array('class' => 'input-block-level', 'placeholder' => 'Include http://')); ?>
	    </div>
	    
	    <h4>Button Color</h4>
	    <?php echo $formHelper->select('buttonColorClass', ButtonLinkBlockController::$btnColors, $this->controller->buttonColorClass, array('class' => 'input-block-level')); ?>
	    
	    <h4>Button Size</h4>
		<?php echo $formHelper->select('buttonSizeClass', ButtonLinkBlockController::$btnSizes, $this->controller->buttonSizeClass, array('class' => '')); ?> &nbsp;<?php echo $formHelper->checkbox('fullWidth', ButtonLinkBlockController::WIDTH_BLOCK, $this->controller->fullWidth); ?> Full Width
		
		<h4>Custom Link Text (Optional)</h4>
		<?php echo $formHelper->text('linkText', $this->controller->linkText, array('class' => 'input-block-level')); ?>
	</div>

<script type="text/javascript">
    $(function(){
        $('[name="pageOrUrl"]').on('change', {toggleable: $('.toggleable', '#buttonLink')}, function(_event){
            var _to = $(this).val();
            _event.data.toggleable.hide().filter('[data-toggle-on="'+_to+'"]').show();
        });
    });
</script>

