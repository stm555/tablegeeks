<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'User.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

class UserTest extends PHPUnit_Framework_TestCase
{
    private $dbUser = 'tablegeeks';
    private $dbPw = 'geeks@tables';
    private $dbName = 'tablegeeks';
    
    public function setUp(  )
    {
        //load database with test data
        exec( "mysql5 -u {$this->dbUser} -p {$this->dbPw} {$this->dbName} < " . Zend_Registry::get( 'testRoot' ) . "/scripts/data/mysql/testData.build.sql" );
    }
    public function tearDown(  )
    {
        //empty out all tables
        exec( "mysql5 -u {$this->dbUser} -p {$this->dbPw} {$this->dbName} < " . Zend_Registry::get( 'testRoot' ) . "/scripts/data/mysql/testData.destroy.sql" );
    }

    public function testFetchGetsAUser(  )
    {
        $user = Tg_User::fetch( 1 );

        $this->assertType( 'Tg_User', $user );

    }
    
    public function testFetchGetsUserById(  ) {
        $userId = 1;
        $userName = 'stm';

        $user = Tg_User::fetch( $userId );
        
        $this->assertEquals($userId, $user->id );
        $this->assertEquals( $userName, $user->name );
    }
}
