<?php
//ini_set( 'include_path', '../../library' . DIRECTORY_SEPARATOR . ini_get( 'include_path' ));
//require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';
$bootstrap = true;
require '../../application/bootstrap.php';
class podcastControlerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp(  )
    {
        $this->bootstrap = '../../application/bootstrap.php';
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
