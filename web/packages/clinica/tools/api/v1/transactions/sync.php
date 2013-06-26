<?php defined('C5_EXECUTE') or die("Access Denied.");
    
    session_write_close();
    ob_clean();
    
    try {
        // is request coming from authorized IP range?
        //$ipHelper = Loader::helper('validation/ip');
        //$ip = $ipHelper->getRequestIP();
        
        // authorize
        $authKey = hash('sha512', sha1('cl1N!C@Pa$Sk3y4@P!' . gmdate('m-d-y_H') . gmdate('H:mdY') . gmdate('Md:h-Y')));
        if( !($authKey === $_POST['authKey']) ){
            header('HTTP/1.1 401 Unauthorized');
            throw new Exception('Unauthorized');
        }
        
        // if we get here, authorization is ok, proceed
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
        
        // print out database schema
        print $str_backupdata;
        
    }catch(Exception $e){
        die( $e->getMessage() );
    }
    