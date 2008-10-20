<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'Session.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

class SessionTest extends PHPUnit_Framework_TestCase
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

    public function testFetchGetsAGamingSession(  )
    {
        $session = Tg_Session::fetch( 1 );

        $this->assertType( 'Tg_Session', $session );

    }
    
    public function testFetchGetsGamingSessionById(  ) {
        $sessionId = 1;
        $campaign = new Tg_Campaign( );
        $campaign->id = 1;
        $campgain->name = "Grand Campaign";
        $media = new Tg_Media(  );
        $media->id = 1;
        $media->path = "12345.m4a";
        $media->size = 3000000;
        $media->mimetype = 'audio/x-m4a';
        $media->duration = '360000';
        $user = new Tg_Users(  );
        $user->id = 1;
        $user->name = stm;

        $session = Tg_Session::fetch( $sessionId );
        
        $this->assertEquals($sessionId, $session->id );
        $this->assertEquals( 'Wherein Grand Things Happen to our Heroes', $session->description );
        $this->assertEquals( 'Lots of interesting things hapen to our heroes in this episode', $session->synopsis );
        $this->assertEquals( new Zend_Date( '10-28-2008' ), $session->date );
        $this->assertEquals( $campaign, $session->campaign );
        $this->assertEquals( $media, $session->media );
        $this->assertEquals( $user, $session->user );
    }
}
