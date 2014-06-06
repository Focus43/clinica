<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <thead>
        <tr>
            <th>Name (Last, First)</th>
            <th>Date Of Birth</th>
            <th>Proceed With Procedure</th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($patients) ){ foreach($patients as $patientObj): ?>
            <tr>
                <td><?php echo $patientObj; ?></td>
                <td><?php echo $patientObj->getDOB('M d, Y'); ?></td>
                <td><?php echo $patientObj->getPaid(); ?></td>
            </tr>
        <?php endforeach; }else{ ?>
            <tr>
                <td colspan="3">Patient table is empty.</td>
            </tr>
        <?php } ?>
    </tbody>
