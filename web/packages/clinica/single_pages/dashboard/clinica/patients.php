<?php
/**
 * Created by JetBrains PhpStorm.
 * User: superrunt
 * Date: 6/12/13
 * Time: 12:45 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Patients'), t(''), false, false ); ?>

    <div id="clinicaWrap">
        <div class="ccm-pane-body">

            <?php Loader::packageElement('dashboard/personnel/form_add_edit', 'clinica', array('patientObj' => $patientObj)); ?>

        </div>
        <div class="ccm-pane-footer"></div>
    </div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>