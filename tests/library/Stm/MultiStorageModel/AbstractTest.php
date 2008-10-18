<?php
require_once( 'PHPUnit/Framework.php' );
require_once( dirname( __FILE__ ) . '/../../../../library/Stm/MultiStorageModel/Abstract.php' );
require_once( dirname( __FILE__ ) . '/../../../../library/Zend/Db/Table/Abstract.php' );

class Stm_MultiStorageModel_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * testSetStorage 
     * tests that setting the storage to Db causes a Zend_Db_Table adapter to be used
     * as implemented in demo model class at bottom of file
     * 
     */
    public function testSetStorageDb( )
    {
        Stm_MultiStorageModel_Abstract::setStorage( Stm_MultiStorageModel_Abstract::STORAGE_DB );

        $model = new DemoModel(  );

        $this->assertType( 'Zend_Db_Table_Abstract', $model->getStorageAdapter(  ) );

    }
}

class DemoModel extends Stm_MultiStorageModel_Abstract
{
    private $_table = null;

    public function getStorageAdapter(  )
    {
        switch ( $this->_storageType )
        {
            case self::STORAGE_DB:
                return $this->_getTable( );
            case null:
                throw new Exception ( 'Storage Type Not Set' );
            default:
                throw new Exception ( 'Unsupported Storage Type Set' );
        }
    }
    private function _getTable(  )
    {
        if ( is_null( $this->_table ) )
        {
            $this->_table = new DemoTable(  );
        }
        return $this->_table;
    }

}
class DemoTable extends Zend_Db_Table_Abstract
{
    public function __construct(  )
    {
        //overloading so it doesn't require an adapter or anything

    }

}
