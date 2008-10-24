<?php
require dirname( __FILE__ ) . '/../TestHelper.php';
$bootstrap = true;
require dirname( __FILE__ ) . '/../../application/bootstrap.php';
class podcastControlerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp(  )
    {
        $this->bootstrap = dirname( __FILE__ ) . '/../../application/bootstrap.php';
        parent::setUp(  );
    }

    public function testMainFeed(  )
    {
        $this->dispatch( '/' );
        $this->assertXpath( 'rss' );
        $this->assertXpath( 'rss/channel' );
        $this->assertXpath( 'rss/channel/title' );
    }
}
