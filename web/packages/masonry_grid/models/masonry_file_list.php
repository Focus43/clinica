<?php

	class MasonryFileList extends FileList {
		
		public function __construct( array $fileSetIDs = array() ){
			if( count($fileSetIDs) > 1 ){
				$orFilters = array();
				foreach($fileSetIDs AS $fsID){
					$orFilters[] = t('fsID = %s', (int) $fsID);
				}
				$this->addToQuery("left join FileSetFiles fsfl on fsfl.fID = f.fID");
				$this->filter(false, t('f.fID IN (SELECT DISTINCT fID FROM FileSetFiles WHERE %s)', join(" OR ", $orFilters)));
			}else{
				$this->filteredFileSetIDs = $fileSetIDs;
				$this->sortByFileSetDisplayOrder();
			}
		}
		
	}
