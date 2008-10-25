<?php
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );
require_once( Zend_Registry::get( 'testBootstrap' ) );
require_once( 'PHPUnit/Framework.php' );
require_once( 'Media.php' );

class MediaTest extends PHPUnit_Framework_TestCase
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
            $media = Tg_Media::fetch( 99999999 );
        }
        catch ( Exception $e ) {
            return; //exception thrown, pass
        }

        $this->fail(  ); //exception not thrown, fail
    }

    public function testFetchGetsMedia(  )
    {
        $media = Tg_Media::fetch( 9999 );

        $this->assertType( 'Tg_Media', $media );

    }
    
    public function testFetchGetsMediaById(  ) {
        $mediaId = 9999;
        $mediaPath = '12345.m4a';
        $mediaSize = 3000000;
        $mediaMimeType = 'audio/x-m4a'; 
        $mediaDuration = 360000;

        $media = Tg_Media::fetch( $mediaId );
        
        $this->assertEquals($mediaId, $media->id );
        $this->assertEquals( $mediaPath, $media->path );
        $this->assertEquals( $mediaSize, $media->size );
        $this->assertEquals( $mediaMimeType, $media->mimetype );
        $this->assertEquals( $mediaDuration, $media->duration );
    }

    public function testGetDurationSeconds( )
    {
        $media = new Tg_Media( );
        $media->duration = 90;

        $this->assertEquals( '90', $media->getDuration(  ) );
    }

    public function testGetDurationMinutesMoreThanMinute( )
    {
        $media = new Tg_Media( );
        $media->duration = 90;

        $this->assertEquals( '1:30', $media->getDuration( Tg_Media::DURATION_TYPE_MINUTES ) );
    }
    
    public function testGetDurationMinutesLessThanMinute( )
    {
        $media = new Tg_Media( );
        $media->duration = 50;

        $this->assertEquals( '0:50', $media->getDuration( Tg_Media::DURATION_TYPE_MINUTES ) );
    }

    public function testGetDurationHoursLessThanHour( )
    {
        $media = new Tg_Media( );
        $media->duration = 90;

        $this->assertEquals( '0:1:30', $media->getDuration( Tg_Media::DURATION_TYPE_HOURS ) );
    }

    public function testGetDurationHoursMoreThanHour(  )
    {

        $media = new Tg_Media(  );
        $media->duration = 3690;

        $this->assertEquals( '1:1:30', $media->getDuration( Tg_Media::DURATION_TYPE_HOURS ) );
    }
}

