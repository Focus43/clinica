<?php defined('C5_EXECUTE') or die("Access Denied.");

    class MigrateProviderLocations extends Job {
        
        public function getJobName(){
            return 'Migrate Provider Locations';
        }
        
        public function getJobDescription(){
            return 'See job name. Runs once, then self-uninstalls.';
        }
        
        public function run(){
            $db     = Loader::db();
            $rows   = $db->Execute("SELECT * FROM ClinicaPersonnel");
            
            foreach($rows AS $providerRow){
                $db->Execute("INSERT INTO ClinicaPersonnelLocations (personnelID, providerHandle) VALUES (?,?)", array(
                    $providerRow['id'], $providerRow['providerHandle']
                ));
            }
            
            // uninstall the job!
            $this->uninstall();
        }
        
    }
