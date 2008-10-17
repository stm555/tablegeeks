<?php
require_once 'User.php';
require_once 'Campaign.php';
require_once 'Media.php';

/**
 * Tg_Session 
 * 
 * @author stm 
 */
class Tg_Session
{
    /**
    * Campaign that this session part of
    * @var Tg_Campaign
    **/
    public $campaign;
    /**
    * Stores date of the session
    * @var Zend_Date
    **/
    public $date;
    /**
    * User who uploaded this session
    * @var Tg_User
    **/
    public $author;
    /**
    * Description of this session
    * @var string
    **/
    public $description = '';
    /**
    * Synopsis of this session
    * @var string
    **/
    public $synopsis = '';
    /**
    * Media file for this session
    * @var Tg_Media
    **/
    public $media;
    /**
    * Date that this session was added
    * @var Zend_Date
    **/
    public $addDate;
    /**
    * Collection of tags related to this session
    * @var array
    **/
    public $tags = array();
}
