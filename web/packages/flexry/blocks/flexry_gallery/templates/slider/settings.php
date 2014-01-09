<?php /** @var stdObj $templateData */ ?>

    <table class="table table-bordered">
        <tr>
            <td><strong>Items Per Page</strong></td>
            <td><?php echo $formHelper->text('templateData[slider][items]', $templateData->slider->items, array('class' => 'span1')); ?></td>
        </tr>
        <tr>
            <td><strong>Autoplay</strong></td>
            <td><label class="checkbox"><?php echo $formHelper->checkbox('templateData[slider][autoplay]', 1, (int) $templateData->slider->autoplay ); ?> Automatically scroll through elements</label></td>
        </tr>
        <tr>
            <td><strong>Navigation Settings</strong></td>
            <td><label class="checkbox"><?php echo $formHelper->checkbox('templateData[slider][showNavigation]', 1, (int) $templateData->slider->showNavigation ); ?> Show Navigation</label>
                <label class="checkbox"><?php echo $formHelper->checkbox('templateData[slider][showPagination]', 1, (int) $templateData->slider->showPagination ); ?> Show Page Markers</label>
            </td>
        </tr>
    </table>