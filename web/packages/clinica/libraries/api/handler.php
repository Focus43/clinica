<?php

    class ClinicaApiHandler {

        const AUTHORIZATION_KEY = 'cl1N!C@Pa$Sk3y4@P!';


        /**
         * Instantiate (clear necessary stuff), and run validation first thing.
         */
        public function __construct(){
            session_write_close();
            ob_clean();
            $this->validate();
        }


        /**
         * Get the authorization key to match against.
         * @return string
         */
        protected function validationKey(){
            $pepper = gmdate('Y_m_d.G') . '@R3Qu$t!';
            return hash('sha512', self::AUTHORIZATION_KEY . $pepper);
        }


        /**
         * Validate the call, and throw an Unauthorized HTTP header if not valid. Will
         * force the script to die automatically if not valid.
         * @return void
         */
        protected function validate(){
            try {
                if( !($this->validationKey() === $_POST['authKey']) ){
                    throw new Exception("Unauthorized");
                }
            }catch(Exception $e){
                header('HTTP/1.1 401 Unauthorized');
                die( $e->getMessage() );
            }
        }


        /**
         * Output a JSON formatted list of transactions.
         * @return void
         */
        public function getTransactionList(){
            $transactionListObj = new ClinicaTransactionList();
            $results            = $transactionListObj->get(1000);
            print Loader::helper('json')->encode($results);
        }


        /**
         * Output a full dump of the database.
         * @return void
         */
        public function getDatabaseDump(){
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
        }

    }