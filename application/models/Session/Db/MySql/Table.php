<?php
require_once( dirname( __FILE__ ) . '/../../../../../library/Zend/Db/Table/Abstract.php' );
class Tg_Session_Db_MySql_Table extends Zend_Db_Table_Abstract
{

    protected $_name = 'sessions';

    protected $_primary = 'id';
}
