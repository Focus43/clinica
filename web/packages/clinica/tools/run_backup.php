<?php defined('C5_EXECUTE') or die("Access Denied.");

    if( $_GET['proceed'] == 'cl1n1ca_bakd' ){
        Loader::library('backup');
        Backup::execute(false);
    }