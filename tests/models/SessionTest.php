<?php
require_once( 'PHPUnit/Framework.php' );
require_once( dirname( __FILE__ ) . '/../../application/models/Session.php' );

class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * testSetStorage 
     * tests that setting the storage to Db causes a Zend_Db_Table adapter to be used
     * 
     */
    public function testSetStorageDb( )
    {
        Zend_Db_Table_Adapter_Abstract::setDefaultAdapter( new StubDbAdapter( ) );
        Stm_MultiStorageModel_Abstract::setStorage( Stm_MultiStorageModel_Abstract::STORAGE_DB );

        $session = new Tg_Session(  );

        $this->assertType( 'Zend_Db_Table_Abstract', $session->getStorageAdapter(  ) );
    }
}
class StubDbAdapter extends Zend_Db_Adapter_Abstract
{

}
