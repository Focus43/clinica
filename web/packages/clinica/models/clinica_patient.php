<?php
/**
 * Created by JetBrains PhpStorm.
 * User: superrunt
 * Date: 6/12/13
 * Time: 11:29 AM
 */

class ClinicaPatient {

    /**
     * @param array $properties Set object property values with key => value array
     */
    public function __construct( array $properties = array() ){
        $this->setPropertiesFromArray($properties);
        $this->tableName = __CLASS__;
    }


    public function __toString(){
        return ucfirst("{$this->lastName}, {$this->firstName}");
    }

    /** @return int Get the ID */
    public function getID(){ return $this->id; }
    /** @return string Date the object was first created */
    public function getDateCreated(){ return $this->createdUTC; }
    /** @return string Date the object was last modified */
    public function getDateModified(){ return $this->modifiedUTC; }
    /** @return string Get first name */
    public function getFirstName(){ return ucfirst($this->firstName); }
    /** @return string Get last name */
    public function getLastName(){ return ucfirst($this->lastName); }
    /** @return string Get date of birth */
    public function getDOB($formatted = false) {
        if ($formatted) {
            return date($formatted, strtotime($this->dob));
        }
        return $this->dob;
    }
    /** @return string Get paid */
    public function getPaid(){ return ($this->paid == 1) ? "YES" : "NO"; }
    /** @return string Get paid numeric version */
    public function getPaidNumeric(){ return $this->paid; }

    /**
     * Set properties of the current instance
     * @param array $arr Pass in an array of key => values to set object properties
     * @return void
     */
    public function setPropertiesFromArray( array $properties = array() ) {
        foreach($properties as $key => $prop) {
            $this->{$key} = $prop;
        }
    }


    protected function persistable(){
        return array('firstName', 'lastName', 'paid', 'dob');
    }


    public function save(){
        $db = Loader::db();

        // record already exists, do an update
        if( $this->id >= 1 ){
            $fields		= $this->persistable();
            $updateStr  = 'modifiedUTC = UTC_TIMESTAMP()';
            $values		= array();
            foreach($fields AS $property){
                $updateStr .= ", {$property} = ?";
                $values[] = $this->{$property};
            }
            $values[] = $this->id;
            $db->Execute("UPDATE {$this->tableName} SET {$updateStr} WHERE id = ?", array($values));
        }else{
            $fields		= $this->persistable();
            $fieldNames = "createdUTC, modifiedUTC, " . implode(',', $fields);
            $fieldCount	= implode(',', array_fill(0, count($fields), '?'));
            $values		= array();
            foreach($fields AS $property){
                $values[] = $this->{$property};
            }
            $db->Execute("INSERT INTO {$this->tableName} ($fieldNames) VALUES (UTC_TIMESTAMP(), UTC_TIMESTAMP(), $fieldCount)", $values);
            $this->id	 = $db->Insert_ID();
        }

        return self::getByID( $this->id );
    }


    public static function getByID( $id ){
        $self = new self();
        $row = Loader::db()->GetRow("SELECT * FROM {$self->tableName} WHERE id = ?", array( (int)$id ));
        $self->setPropertiesFromArray($row);
        return $self;
    }


    /**
     * Delete the record, and any attribute values associated w/ it
     * @return void
     */
    public function delete(){
        $db = Loader::db();
        $db->Execute("DELETE FROM {$this->tableName} WHERE id = ?", array($this->id));
    }

}