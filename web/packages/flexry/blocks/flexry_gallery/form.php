<?php defined('C5_EXECUTE') or die("Access Denied.");
    $formHelper = Loader::helper('form');
?>

	<style type="text/css">
        #flexryGallery {}
        #flexryGallery .nav-tabs select {width:160px;}
        #flexryGallery .well {padding-top:11px;padding-bottom:11px;}
        #flexryGallery .well p:last-child {margin:0;}
        #tab-choose-images .alert {display:none;}
        #imageSelections {background:#eee;position:absolute;top:58px;right:10px;bottom:10px;left:10px;border:1px dashed #bbb;overflow-y:scroll;overflow-x:hidden;}
        #imageSelections p {text-align:center;font-size:11px;color:#777;margin:0;padding:8px 0;}
        #imageSelections p i {position:relative;top:-2px;}
        #imageSelections .inner {width:100%;height:100%;position:relative;}
        #imageSelections .item {position:relative;background:#fff;padding:5px;text-align:center;border:1px solid #ccc;float:left;margin:0 0 8px 8px;cursor:pointer;box-shadow:0 0 4px rgba(0,0,0,.25);border-radius:3px;}
        #imageSelections .item i.remover {display:none;position:absolute;bottom:-8px;right:-6px;}
        #imageSelections .item:hover i.remover {display:block;cursor:not-allowed;}
        #imageSelections .item i.icon-move {display:none;position:absolute;top:-8px;left:50%;margin-left:-8px;}
        #imageSelections .item:hover i.icon-move {display:block;cursor:move}
        #imageSelections .item table {height:100%;vertical-align:middle;}

        #flexryGallery .tab-content {overflow:visible;}
        #tab-settings .well p.muted {font-size:11px;}
        #tab-settings table.table {margin-bottom:8px;background:#fff;}
        #tab-settings table.table td {white-space:nowrap;vertical-align: middle;background:#fff;}
        #tab-settings table.table tr td:last-child {width:98%;}

        #tab-choose-images.dups .alert {display:block;}
        #tab-choose-images.dups .alert .btn {color:inherit;float:right;}
        #tab-choose-images.dups .alert .close {top:1px;}
        #tab-choose-images.dups #imageSelections {top:110px;}

        #flexryGallery .fileSourceMethod {display:none;}
        #flexryGallery .fileSourceMethod.active {display:block;}

        <?php if((int)$this->controller->fileSourceMethod === FlexryGalleryBlockController::FILE_SOURCE_METHOD_SETS){ ?>
        #chooseImg {display:none;}
        <?php } ?>
	</style>

	<div id="flexryGallery" class="ccm-ui">
        <ul class="nav nav-tabs">
            <li class="active"><a data-tab="#tab-choose-images">Images</a></li>
            <li><a data-tab="#tab-settings">Settings</a></li>
            <li id="flexryOptionsRight" class="pull-right">
                <?php echo $formHelper->select('fileSourceMethod', FlexryGalleryBlockController::$fileSourceMethods, $this->controller->fileSourceMethod); ?>
                <button id="chooseImg" type="button" class="btn" title="Select multiple with checkboxes." data-method="<?php echo FlexryGalleryBlockController::FILE_SOURCE_METHOD_CUSTOM; ?>">Add Images</button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- image selection tab -->
            <div id="tab-choose-images" class="tab-pane active">
                <!-- build gallery manually -->
                <div class="fileSourceMethod <?php if((int)$this->controller->fileSourceMethod === FlexryGalleryBlockController::FILE_SOURCE_METHOD_CUSTOM){ echo 'active'; } ?>" data-method="<?php echo FlexryGalleryBlockController::FILE_SOURCE_METHOD_CUSTOM; ?>">
                    <div class="dups-warning alert alert-warning">The same image was added more than once; duplicates have been removed automatically.  <button type="button" class="close">&times;</button></div>
                    <div id="imageSelections">
                        <p><i class="icon-minus-sign remover"></i> to reorder. <i class="icon-move"></i> to remove. Click to edit file properties.</p>
                        <div class="inner clearfix">
                            <?php foreach($imageList AS $fileObj){ /** @var FlexryFile $fileObj */ ?>
                                <div class="item" data-fileid="<?php echo $fileObj->getFileID(); ?>">
                                    <i class="icon-minus-sign remover"></i><i class="icon-move"></i>
                                    <table>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $fileObj->getThumbnail(1, false); ?>" />
                                                <input type="hidden" name="fileIDs[]" value="<?php echo $fileObj->getFileID(); ?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- compose gallery from sets -->
                <div class="fileSourceMethod <?php if((int)$this->controller->fileSourceMethod === FlexryGalleryBlockController::FILE_SOURCE_METHOD_SETS){ echo 'active'; } ?>" data-method="<?php echo FlexryGalleryBlockController::FILE_SOURCE_METHOD_SETS; ?>">
                    <div class="well">
                        <h3>Choose One Or More File Sets</h3>
                        <p>If more than one File Set is used, images will be ordered randomly.</p>
                        <select id="fileSetPicker" class="input-block-level" name="fileSetIDs[]" multiple data-placeholder="Choose one or more File Set">
                            <?php foreach($availableFileSets AS $fsObj): ?>
                                <option value="<?php echo $fsObj->getFileSetID(); ?>"<?php if(in_array($fsObj->getFileSetID(), $savedFileSets)){ echo ' selected="selected"'; } ?>><?php echo $fsObj->getFileSetName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="muted">The advantage to using File Sets is that you can simply add one or more images to a set, or image sets, in the File Manager, and the gallery will automatically update with the images (instead of adding by hand using the custom gallery option).</p>
                    </div>
                </div>
            </div>

            <!-- settings tab -->
            <div id="tab-settings" class="tab-pane">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="well">
                            <h3>Thumbnail Image Size</h3>
                            <p>Size of image output within the page.</p>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Max Width</strong></td>
                                    <td><?php echo $formHelper->text('thumbWidth', $this->controller->thumbWidth, array('class' => 'span1', 'placeholder' => '250')); ?> px</td>
                                </tr>
                                <tr>
                                    <td><strong>Max Height</strong></td>
                                    <td><?php echo $formHelper->text('thumbHeight', $this->controller->thumbHeight, array('class' => 'span1', 'placeholder' => '250')); ?> px</td>
                                </tr>
                                <tr>
                                    <td><strong>Crop To Fit?</strong></td>
                                    <td><?php echo $formHelper->checkbox('thumbCrop', 1, $this->controller->thumbCrop); ?></td>
                                </tr>
                            </table>
                            <p class="muted">Note: both width and height are required. The image ratio will be maintained, and the image will fit to the max of either the width or height.</p>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="well">
                            <h3>Full Image Size</h3>
                            <p>i.e. Click image to open in overlay (if enabled).</p>
                            <p><?php echo $formHelper->checkbox('fullUseOriginal', 1, $this->controller->fullUseOriginal); ?> Use Original Image (uncheck to enable resizing)</p>
                            <table data-toggle-watch="fullUseOriginal" class="table table-bordered" style="<?php if( (bool)$this->controller->fullUseOriginal ){ echo 'display:none;'; } ?>">
                                <tr>
                                    <td><strong>Max Width</strong></td>
                                    <td><?php echo $formHelper->text('fullWidth', ($this->controller->fullWidth >= 1 ? $this->controller->fullWidth : ''), array('class' => 'span1', 'placeholder' => '900')); ?> px</td>
                                </tr>
                                <tr>
                                    <td><strong>Max Height</strong></td>
                                    <td><?php echo $formHelper->text('fullHeight', ($this->controller->fullHeight >= 1 ? $this->controller->fullHeight : ''), array('class' => 'span1', 'placeholder' => '750')); ?> px</td>
                                </tr>
                                <tr>
                                    <td><strong>Crop To Fit?</strong></td>
                                    <td><?php echo $formHelper->checkbox('fullCrop', 1, $this->controller->fullCrop); ?></td>
                                </tr>
                            </table>
                            <p data-toggle-watch="fullUseOriginal" class="muted" style="<?php if( (bool)$this->controller->fullUseOriginal ){ echo 'display:none;'; } ?>">Note: both width and height are required. The image ratio will be maintained, and the image will fit to the max of either the width or height.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

