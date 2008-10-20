<?php
require_once( dirname( __FILE__ ) . '/../../../../../library/Zend/Db/Table/Abstract.php' );
class Tg_Media_Db_MySql_MediaTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'media';

    protected $_primary = 'id';
}
