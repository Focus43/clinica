<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var $patientObj ClinicaPatient */
?>

    <thead>
        <tr>
            <th>Name (Last, First)</th>
            <th>Date Of Birth</th>
            <th>Proceed?</th>
            <th>Procedure Form</th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($patients) ){ foreach($patients as $patientObj): ?>
            <tr>
                <td><?php echo $patientObj; ?></td>
                <td><?php echo $patientObj->getDOB('M d, Y'); ?></td>
                <td><?php echo $patientObj->getPaid(); ?></td>
                <td>
                    <?php if( !((int)$patientObj->getProcedureFormFileID() >= 1) ): ?>
                        ----------
                    <?php else: ?>
                        <a class="procedure-form" href="<?php echo $patientObj->getProcedureFormFileObj()->getDownloadURL(); ?>">
                            <img src="<?php echo $patientObj->getProcedureFormFileObj()->getThumbnail(2, false); ?>" alt="File Icon" />
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; }else{ ?>
            <tr>
                <td colspan="3">Patient table is empty.</td>
            </tr>
        <?php } ?>
    </tbody>
