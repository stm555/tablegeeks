<?php
require_once( dirname( __FILE__ ) . '/../../../../../library/Zend/Db/Table/Abstract.php' );
class Tg_Campaign_Db_MySql_CampaignTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'campaigns';

    protected $_primary = 'id';
}
