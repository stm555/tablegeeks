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
     * unique session id
     * 
     * @var integer
     */
    public $id;

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

    /**
     * Data access through table gateway pattern
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_sessionTable;

    private function _getSessionTable(  )
    {
        if ( is_null( $this->_sessionTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/Session/Db/MySql/SessionTable.php');
            $this->_sessionTable = new Tg_Session_Db_MySql_SessionTable(  );
        }
        return $this->_sessionTable;
    }

    //Static methods
    public static function fetch( $id )
    {
        $session = new Tg_Session( );
        $sessionTable = $session->_getSessionTable(  );
        $rowset = $sessionTable->find( $id );
        $row = $rowset->current( );
        $session->id = $row->id;
        $session->description = $row->description;
        $session->synopsis = $row->synopsis;
        $session->date = new Zend_Date( $row->date );

        return $session;
    }
}
