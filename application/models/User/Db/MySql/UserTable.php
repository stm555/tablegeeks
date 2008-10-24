<?php
require_once( dirname( __FILE__ ) . '/../../../../../library/Zend/Db/Table/Abstract.php' );
class Tg_User_Db_MySql_UserTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    protected $_primary = 'id';
}
