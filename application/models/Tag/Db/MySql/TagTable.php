<?php
require_once( dirname( __FILE__ ) . '/../../../../../library/Zend/Db/Table/Abstract.php' );
class Tg_Tag_Db_MySql_TagTable extends Zend_Db_Table_Abstract
{
    const TYPE_SESSION = 'session';

    protected $_name = 'tags';

    protected $_primary = 'id';
}

