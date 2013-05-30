<?php defined('C5_EXECUTE') or die("Access Denied.");
    
    session_write_close();
    ob_clean();
    
    if(!( sha1('cl1NiC@PASSk3y'.date('m-d-y_H')) === $_POST['key'] )){
        header('HTTP/1.1 401 Unauthorized');
        die('Unauthorized');
    }
    
    // Load libraries + helpers
    Loader::library('backup');
    $db = Loader::db();
    
    // get tables listing
    $tablesArray = $db->getCol("SHOW TABLES FROM `" . DB_DATABASE . "`");
    
    // loop through tables and create export
    foreach ($tablesArray as $bkuptable) {
        $tableobj = new Concrete5_Library_Backup_BackupTable($bkuptable);
        $str_backupdata .= "DROP TABLE IF EXISTS $bkuptable;\n\n";
        $str_backupdata .= $tableobj->str_createTableSql . "\n\n";
        if ($tableobj->str_createTableSql != "" ) {
            $str_backupdata .= $tableobj->str_insertionSql . "\n\n";
        }
    }
    
    print $str_backupdata;

    exit;