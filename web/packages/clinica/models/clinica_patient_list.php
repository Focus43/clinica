<?php
/**
 * Created by JetBrains PhpStorm.
 * User: superrunt
 * Date: 6/12/13
 * Time: 11:30 AM
 * To change this template use File | Settings | File Templates.
 */

class ClinicaPatientList extends DatabaseItemList {

    protected $autoSortColumns 	= array('createdUTC', 'modifiedUTC', 'firstName', 'lastName', 'dob'),
        $itemsPerPage		= 10;

    public function get( $itemsToGet = 100, $offset = 0 ){
        $patients = array();
        $this->createQuery();
        $r = parent::get($itemsToGet, $offset);
        foreach($r AS $row){
            $patients[] = ClinicaPatient::getByID( $row['id'] );
        }
        return $patients;
    }


    public function getTotal(){
        $this->createQuery();
        return parent::getTotal();
    }


    protected function createQuery(){
        if( !$this->queryCreated ){
            $this->setBaseQuery();
            $this->queryCreated = true;
        }
    }

    public function setBaseQuery(){
        $queryStr = "SELECT ct.id FROM ClinicaPatient ct";
        $this->setQuery( $queryStr );
    }

    public function filterByName( $name ){
        $name = Loader::db()->quote('%'.$name.'%');
        $this->filter(false, "cp.firstName LIKE $name OR cp.lastName LIKE $name");
    }

}

class ClinicaPatientColumnSet extends DatabaseItemListColumnSet {

    public function __construct(){
        $this->addColumn(new DatabaseItemListColumn('lastName', t('Name'), array('ClinicaPatientColumnSet', 'getNameAsLast')));
        $this->addColumn(new DatabaseItemListColumn('dob', t('DOB'), array('ClinicaPatientColumnSet', 'getDOB')));
        $this->addColumn(new DatabaseItemListColumn('paid', t('Proceed With Procedure'), 'getPaid'));
        $this->addColumn(new DatabaseItemListColumn('procedureFormFileID', t('Procedure Form'), array('ClinicaPatientColumnSet', 'getProcedureFormLink')));
    }

    public function getNameAsLast( ClinicaPatient $patientObj ){
        $name = "{$patientObj->getLastName()}, {$patientObj->getFirstName()}";
        return '<a href="'.View::url('dashboard/clinica/patients/edit', $patientObj->getID()).'">'.$name.'</a>';
    }

    public function getDOB( ClinicaPatient $patientObj ){
        return $patientObj->getDOB(true);
    }

    public function getProcedureFormLink( ClinicaPatient $patientObj ){
        if( !((int)$patientObj->getProcedureFormFileID() >= 1) ):
            return 'Unavailable.';
        else:
            return '<a href="'.$patientObj->getProcedureFormFileObj()->getDownloadURL().'">'.$patientObj->getProcedureFormFileObj()->getTitle().'</a>';
        endif;
    }

    public function getCurrent(){
        return new self;
    }

}