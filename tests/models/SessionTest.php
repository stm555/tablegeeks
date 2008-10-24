<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'Session.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

/**
 * SessionTest 
 * @TODO refactor all these hard coded test values to defines or something
 * @TODO need to add support for tags
 * @author stm 
 */
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
    
    public function testFetchGetsGamingSessionByIdShouldHavePrimitiveValues(  ) {
        $sessionId = 1;

        $session = Tg_Session::fetch( $sessionId );
        
        $this->assertEquals($sessionId, $session->id );
        $this->assertEquals( 'Wherein Grand Things Happen to our Heroes', $session->description );
        $this->assertEquals( 'Lots of interesting things hapen to our heroes in this episode', $session->synopsis );
        $this->assertEquals( new Zend_Date( '10-28-2008' ), $session->date );
    }

    public function testFetchGetsGamingSessionByIdShouldHaveCampaign(  ) {
        $sessionId = 1;
        $campaign = new Tg_Campaign( );
        $campaign->id = 1;
        $campaign->name = "Grand Campaign";
        $session = Tg_Session::fetch( $sessionId );
        $this->assertEquals( get_object_vars( $campaign ), get_object_vars( $session->campaign ) );
    }
    
    public function testFetchGetsGamingSessionByIdShouldHaveMedia(  ) {
        $sessionId = 1;
        $media = new Tg_Media(  );
        $media->id = 1;
        $media->path = "12345.m4a";
        $media->size = 3000000;
        $media->mimetype = 'audio/x-m4a';
        $media->duration = '360000';
        $session = Tg_Session::fetch( $sessionId );
        $this->assertEquals( get_object_vars( $media ), get_object_vars( $session->media ) );
    }
    
    public function testFetchGetsGamingSessionByIdShouldHaveAuthor(  ) {
        $sessionId = 1;
        $user = new Tg_User(  );
        $user->id = 1;
        $user->name = 'stm';
        $session = Tg_Session::fetch( $sessionId );
        $this->assertEquals( get_object_vars( $user ), get_object_vars( $session->author ) );
    }

    public function testFetchGetsGamingSessionByIdShouldHaveTags(  ) {

        $sessionId = 1;
        $session = Tg_Session::fetch( $sessionId );
        $this->assertContains( 'grand', $session->tags );
    }

    public function testFetchAllShouldGetArrayOfSessions(  ) {
        $sessions = Tg_Session::fetchAll(  );
        
        $this->assertContainsOnly( 'Tg_Session', $sessions );
    }

    public function testFetchAllShouldGetTestSession(  ) {
        $sessionId = 1;
        $sessions = Tg_Session::fetchAll(  );
        $this->assertEquals( $sessionId, $sessions[0]->id );
    }
}
