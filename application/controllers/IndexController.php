<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }


    public function indexAction()
    {
       require_once dirname( __file__ ) . '/../models/Session/Db/Mysql/Table.php';
       $sessionTable = new Tg_Session_Db_MySql_Table(  );
       Zend_Registry::get( 'log' )->debug( Zend_Debug::dump( $sessionTable->find( 1 )), 'Tuple from Session', false );

    }



}


