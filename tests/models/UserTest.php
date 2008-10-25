<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'User.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

class UserTest extends PHPUnit_Framework_TestCase
{
    
    public function setUp(  )
    {
        //load database with test data
    }
    public function tearDown(  )
    {
        //empty out all test data
    }

    public function testFetchNonExistantThrowsException(  )
    {
        try {
            $user = Tg_User::fetch( 99999999 );
        }
        catch ( Exception $e ) {
            return; //exception thrown, pass
        }

        $this->fail(  ); //exception not thrown, fail
    }

    public function testFetchGetsAUser(  )
    {
        $user = Tg_User::fetch( 9999 );

        $this->assertType( 'Tg_User', $user );

    }
    
    public function testFetchGetsUserById(  ) {
        $userId = 9999;
        $userName = 'stm';

        $user = Tg_User::fetch( $userId );
        
        $this->assertEquals($userId, $user->id );
        $this->assertEquals( $userName, $user->name );
    }
}
