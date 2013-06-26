<?php defined('C5_EXECUTE') or die("Access Denied.");

    Loader::library('api/handler', 'clinica');

    $api = new ClinicaApiHandler();
    $api->getTransactionList();

