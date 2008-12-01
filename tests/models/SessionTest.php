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
    const TEST_SESSION_ID = 9999;
    const TEST_SESSION_ID_INVALID = 99999999;
    const TEST_CAMPAIGN_ID = 9999;
    const TEST_CAMPAIGN_NAME = 'Grand Campaign';
    const TEST_MEDIA_ID = 9999;
    const TEST_AUTHOR_ID = 9999;
    
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
            $session = Tg_Session::fetch( self::TEST_SESSION_ID_INVALID );
        }
        catch ( Exception $e )
        {
            return; //exception thrown, pass
        }
        $this->fail(  ); //exception not thrown, fail
    }

    public function testFetchGetsAGamingSession(  )
    {
        $session = Tg_Session::fetch( self::TEST_CAMPAIGN_ID );

        $this->assertType( 'Tg_Session', $session );

    }
    
    public function testFetchGetsGamingSessionByIdShouldHavePrimitiveValues(  ) {
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        
        $this->assertEquals(self::TEST_SESSION_ID, $session->id );
        $this->assertEquals( 'Wherein Grand Things Happen to our Heroes', $session->description );
        $this->assertEquals( 'Lots of interesting things hapen to our heroes in this episode', $session->synopsis );
        $this->assertEquals( new Zend_Date( '10-28-2008' ), $session->date );
    }

    public function testFetchGetsGamingSessionByIdShouldHaveCampaign(  ) {
        $campaign = new Tg_Campaign( );
        $campaign->id = self::TEST_CAMPAIGN_ID;
        $campaign->name = self::TEST_CAMPAIGN_NAME;
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        $this->assertEquals( get_object_vars( $campaign ), get_object_vars( $session->campaign ) );
    }
    
    public function testFetchGetsGamingSessionByIdShouldHaveMedia(  ) {
        $media = new Tg_Media(  );
        $media->id = self::TEST_MEDIA_ID;
        $media->path = "12345.m4a";
        $media->size = 3000000;
        $media->mimetype = 'audio/x-m4a';
        $media->duration = '360000';
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        $this->assertEquals( get_object_vars( $media ), get_object_vars( $session->media ) );
    }
    
    public function testFetchGetsGamingSessionByIdShouldHaveAuthor(  ) {
        $user = new Tg_User(  );
        $user->id = self::TEST_AUTHOR_ID;
        $user->name = 'stm';
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        $this->assertEquals( get_object_vars( $user ), get_object_vars( $session->author ) );
    }

    public function testFetchGetsGamingSessionByIdShouldHaveTags(  ) {
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        $this->assertContains( 'grand', $session->tags );
    }

    public function testFetchAllShouldGetArrayOfSessions(  ) {
        $sessions = Tg_Session::fetchAll(  );
        
        $this->assertContainsOnly( 'Tg_Session', $sessions );
    }

    public function testFetchAllShouldGetTestSession(  ) {
        $sessions = Tg_Session::fetchAll(  );
        $this->assertEquals( self::TEST_SESSION_ID, $sessions[0]->id );
    }
    
    public function testFetchWithNullIdShouldReturnNewSession( ) {
        $newSession = Tg_Session::fetch( );
        $this->assertType('Tg_Session', $newSession);
        $this->assertNull($newSession->id);
    }
    
    public function testGetFormShouldReturnZendFormObject( ) {
        $session = Tg_Session::fetch( );
        $this->assertType('Zend_Form', $session->getForm());
    }
    
    public function testGetFormShouldReturnFormWithAllFields() {
        $session = Tg_Session::fetch();
        $sessionForm = $session->getForm();
        $this->assertType('Zend_Form_Element', $sessionForm->id, 'ID field missing');
        $this->assertType('Zend_Form', $sessionForm->campaign, 'Campaign field missing');
        $this->assertType('Zend_Form_Element', $sessionForm->date,'Date field missing');
        $this->assertType('Zend_Form_Element', $sessionForm->description,'Description field missing');
        $this->assertType('Zend_Form_Element', $sessionForm->synopsis,'Synopsis field missing');
        //TODO add media test $this->assertType('Zend_Form_Element', $sessionForm->media,'Media field missing');
        $this->assertType('Zend_Form_Element', $sessionForm->tags,'Tags field missing');
    }
    
    public function testGetFormShouldBePopulated() {
        $session = Tg_Session::fetch( self::TEST_SESSION_ID );
        $sessForm = $session->getForm();
        $this->assertEquals($session->id,$sessForm->id->getValue());
        $this->assertEquals($session->campaign->id,$sessForm->campaign->id->getValue());
        $this->assertEquals($session->date,new Zend_Date($sessForm->date->getValue()));
        $this->assertEquals($session->description,$sessForm->description->getValue());
        $this->assertEquals($session->synopsis,$sessForm->synopsis->getValue());
        //TODO add media test $this->assertEquals($session->media->id,$sessForm->media->getValue());
        $this->assertEquals($session->tags,explode( ',', $sessForm->tags->getValue() ));
    }
    
    public function testSaveNewSessionWithExistingSubObjectsShouldSave() {
        $session = Tg_Session::fetch( );
        $session->campaign = Tg_Campaign::fetch( self::TEST_CAMPAIGN_ID );
        $session->media = Tg_Media::fetch( self::TEST_MEDIA_ID );
        $session->author = Tg_Media::fetch( self::TEST_AUTHOR_ID );
        $session->date = new Zend_Date();
        $session->description = "Test Description";
        $session->synopsis = "Test Synopsis";
        $session->tags = array('grand','newTag');
        
        $session->save();
        
        $fetchedSession = Tg_Session::fetch( $session->id );
        $this->assertEquals($session, $fetchedSession);
    }
}
