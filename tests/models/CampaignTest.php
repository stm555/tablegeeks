<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'Campaign.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

class CampaignTest extends PHPUnit_Framework_TestCase
{
    public function setUp(  )
    {
        //load database with test data
    }
    public function tearDown(  )
    {
        //remove test data
    }

    public function testFetchGetsAGamingCampaign(  )
    {
        $campaign = Tg_Campaign::fetch( 9999 );

        $this->assertType( 'Tg_Campaign', $campaign );

    }

    public function testFetchThrowsExceptionOnNonExistantGamingSession(  )
    {
        try {
            $campaign = Tg_Campaign::fetch( 99999999 );
        }
        catch ( Exception $e ) {
            return; //exception thrown, pass
        }
        
        $this->fail(  ); //exception not thrown, fail
    }
    
    public function testFetchGetsGamingCampaignById(  ) {
        $campaignId = 9999;
        $campaignName = 'Grand Campaign';

        $campaign = Tg_Campaign::fetch( $campaignId );
        
        $this->assertEquals($campaignId, $campaign->id );
        $this->assertEquals( $campaignName, $campaign->name );
    }
}
