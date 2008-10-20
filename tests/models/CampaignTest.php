<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( 'PHPUnit/Framework.php' );
require_once( 'Campaign.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );

class CampaignTest extends PHPUnit_Framework_TestCase
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

    public function testFetchGetsAGamingCampaign(  )
    {
        $campaign = Tg_Campaign::fetch( 1 );

        $this->assertType( 'Tg_Campaign', $campaign );

    }
    
    public function testFetchGetsGamingCampaignById(  ) {
        $campaignId = 1;
        $campaignName = 'Grand Campaign';

        $campaign = Tg_Campaign::fetch( $campaignId );
        
        $this->assertEquals($campaignId, $campaign->id );
        $this->assertEquals( $campaignName, $campaign->name );
    }
}
