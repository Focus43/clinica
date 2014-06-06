<?php defined('C5_EXECUTE') or die("Access Denied.");

    $permissions = new Permissions(Page::getByPath('/dashboard/clinica/transactions'));

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
        header('Content-Disposition: attachment;filename=DataExport.xls');
        header('Content-Transfer-Encoding: binary');

        Loader::registerAutoload(array(
            'PHPExcel' => array('library', 'php_excel/Classes/PHPExcel', 'clinica'),
            // C5 autoloader keys on the word 'Helper' causing conflict; so declare explicitly here
            'PHPExcel_ReferenceHelper' => array('library', 'php_excel/Classes/PHPExcel/ReferenceHelper', 'clinica')
        ));

        $transactionListObj    = new ClinicaTransactionList;
        $transactionListResult = $transactionListObj->get(2000);

        $columnMap = new ClinicaTransactionAvailableColumnSet;
        $columns   = $columnMap->getColumns();

        $exportable = array();

        // first setup the column headers
        $colHeaders = array();
        foreach($columns AS $colObj){
            array_push($colHeaders, $colObj->getColumnName());
        }

        array_push($exportable, $colHeaders);

        foreach($transactionListResult AS $transactionObj){
            $rowArray = array();
            foreach($columns AS $colObj){
                array_push($rowArray, $colObj->getColumnValue($transactionObj));
            }
            array_push($exportable, $rowArray);
        }

        $excelObj = new PHPExcel();
        $excelObj->setActiveSheetIndex(0);
        $excelObj->getActiveSheet()->fromArray($exportable, null, 'A1');

        $excelWriter = new PHPExcel_Writer_Excel2007($excelObj);
        $excelWriter->save('php://output');
    }