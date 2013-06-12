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

        <?php if ($listObject) {
            Loader::packageElement('dashboard/patients/search_results', 'clinica', array(
                'searchInstance'	=> $searchInstance,
                'listObject'		=> $listObject,
                'listResults'		=> $listResults,
                'pagination'		=> $pagination
            )); ?>
    </div>
        <?php } else { ?>
        <div class="ccm-pane-body">
        <?php Loader::packageElement('dashboard/patients/form_add_edit', 'clinica', array('patientObj' => $patientObj)); ?>
        </div>
        <div class="ccm-pane-footer"></div>
        <?php } ?>
    </div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>