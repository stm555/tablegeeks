<?php

/**
 * Tg_Media 
 * 
 * @author stm
 */
class Tg_Media
{
    const DURATION_TYPE_SECONDS = 0;
    const DURATION_TYPE_MINUTES = 1;
    const DURATION_TYPE_HOURS = 2;

    /**
     * local relative path to media file
     * 
     * @var string
     */
    public $path ='';
    /**
     * size of media file
     * 
     * @var int
     */
    public $size = 0;
    /**
     * mimetype of media file
     * 
     * @var string
     */
    public $mimetype = '';
    /**
     * duration in seconds of media
     * 
     * @var int
     */
    public $duration = 0;

    /**
     * getDuration returns a string formatted duration based on the unit 
     * 
     * @param int $unit 
     * @return string
     */
    public function getDuration( $unit = self::DURATION_TYPE_SECONDS )
    {
        switch ( $unit )
        {
            case self::DURATION_TYPE_SECONDS: 
                          //seconds
                return (string)$this->duration;
            case self::DURATION_TYPE_MINUTES:
                                           //minutes                   //seconds
                return floor( $this->duration / 60 ) . ':' . $this->duration % 60; 
            case self::DURATION_TYPE_HOURS:
                                           //hours                                       //minutes                              //seconds
                return floor ( $this->duration / ( 60*60 ) ) . ':' . floor( $this->duration / 60 ) % 60  . ':' . $this->duration % 60;
            default:
                throw new Exception( 'Invalid duration unit' );
        }

    }
}
