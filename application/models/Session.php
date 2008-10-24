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

    /**
     * Data access through table gateway pattern for tags
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_tagTable;

    private function _getSessionTable(  )
    {
        if ( is_null( $this->_sessionTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/Session/Db/MySql/SessionTable.php');
            $this->_sessionTable = new Tg_Session_Db_MySql_SessionTable(  );
        }
        return $this->_sessionTable;
    }

    private function _getTagTable(  ) {
        if ( is_null( $this->_tagTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/Tag/Db/MySql/TagTable.php');
            $this->_tagTable = new Tg_Tag_Db_MySql_TagTable(  );
        }
        return $this->_tagTable;
    }

    private function _loadFromRow( Zend_Db_Table_Row $row )
    {
        $this->id = $row->id;
        $this->description = $row->description;
        $this->synopsis = $row->synopsis;
        $this->date = new Zend_Date( $row->date );
        $this->campaign = Tg_Campaign::fetch( $row->campaign );
        $this->author = Tg_User::fetch( $row->author );
        $this->media = Tg_Media::fetch( $row->media );
        $this->_populateTags( );
    }

    private function _populateTags(  )
    {
       $tagTable = $this->_getTagTable(  );
       $select = $tagTable->select()
                          ->setIntegrityCheck(false)
                          ->from( $tagTable, 'tag' )
                          ->joinInner( 'tags_xref', 'tags.id = tags_xref.tag', array( ) )
                          ->where( "tags_xref.type = ?", Tg_Tag_Db_MySql_TagTable::TYPE_SESSION )
                          ->where( "tags_xref.entity = ?", $this->id );
       Zend_Registry::get( 'log' )->debug( $select->assemble() );
       $this->tags = $tagTable->getAdapter( )->fetchCol( $select );   
    }

    //Static methods
    /**
     * fetch a gaming session by id
     * 
     * @param integer $id 
     * @return Tg_Session
     */
    public static function fetch( $id )
    {
        $session = new Tg_Session( );
        $sessionTable = $session->_getSessionTable(  );
        $rowset = $sessionTable->find( $id );
        $session->_loadFromRow( $rowset->current( ) );

        return $session;
    }

    /**
     * Gets all gaming sessions and returns them in an array
     * 
     * @return array
     */
    public static function fetchAll(  )
    {
        $session = new Tg_Session( );
        $sessionTable = $session->_getSessionTable(  );
        $rowset = $sessionTable->fetchAll( );
        $sessions = array( );
        foreach( $rowset as $row )
        {
            $session = new Tg_Session(  );
            $session->_loadFromRow( $row );
            $sessions[] = $session;
        }
        return $sessions;
    }
}
