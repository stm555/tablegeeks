<?php
require_once ( 'bruteDbBuilder.php' );

$builder = new bruteDbBuilder(  );
//create database
$builder->createDb(  );
//create tables
$builder->createTables(  );
//load test data
$builder->loadTestData(  );
