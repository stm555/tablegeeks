<?php
require_once( 'PHPUnit/Framework.php' );
require_once( dirname( __FILE__ ) . '/../../application/models/Media.php' );

class MediaTest extends PHPUnit_Framework_TestCase
{

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

