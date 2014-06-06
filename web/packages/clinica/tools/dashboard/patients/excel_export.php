<?php defined('C5_EXECUTE') or die("Access Denied.");

    $permissions = new Permissions(Page::getByPath('/dashboard/clinica/patients'));

    if( ! $permissions->canViewPage() ){
        throw new Exception('Insufficient permission');
    }else{
        // Set headers to force downloading
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Disposition: attachment;filename=DataExport.xlsx');
        header('Content-Transfer-Encoding: binary');

        Loader::registerAutoload(array(
            'PHPExcel' => array('library', 'php_excel/Classes/PHPExcel', 'clinica'),
            // C5 autoloader keys on the word 'Helper' causing conflict; so declare explicitly here
            'PHPExcel_ReferenceHelper' => array('library', 'php_excel/Classes/PHPExcel/ReferenceHelper', 'clinica')
        ));

        $patientListObj = new ClinicaPatientList();
        $patientListObj->sortBy('lastName', 'asc');
        $patientList = $patientListObj->get(1000);

        $exportable = array(array('Last Name', 'First Name', 'Date Of Birth', 'Paid'));
        foreach($patientList AS $patientObj){ /** @var $patientObj ClinicaPatient */
            array_push($exportable, array(
                $patientObj->getLastName(),
                $patientObj->getFirstName(),
                $patientObj->getDOB('M d, Y'),
                $patientObj->getPaid()
            ));
        }

        $excelObj = new PHPExcel();
        $excelObj->setActiveSheetIndex(0);
        $excelObj->getActiveSheet()->fromArray($exportable, null, 'A1');

        $excelWriter = new PHPExcel_Writer_Excel2007($excelObj);
        $excelWriter->save('php://output');
    }