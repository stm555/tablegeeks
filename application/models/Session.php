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
     * Data access through table gateway row
     *
     * @var Zend_Db_Table_Row_Abstract
     **/
    protected $_sessionRow;

    /**
     * Data access through table gateway pattern for tags
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_tagTable;
    
    /**
     * Form definition w/ validators
     * @var Zend_Form
     **/
    protected $_sessionForm;

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
    
    public function getForm( $includeSubmit = false) {
        if ($this->_sessionForm instanceof Zend_Form) {
            $form = $this->_sessionForm;
        } else {
            $form = new Zend_Form();
            $form->setIsArray(true);
            $form->addElement('hidden', 'id');
            $form->addSubForm($this->campaign->getForm(), 'campaign');
            $form->addElement('text', 'date', array('label' => 'Date'));
            $form->addElement('text', 'description', array('label' => 'Description'));
            $form->addElement('text', 'synopsis', array('label' => 'Synopsis'));
            $form->addElement('text', 'tags', array('label' => 'Tags'));
            
            $this->_sessionForm = $form;
            $this->_populateForm();
            $form = $this->_sessionForm;
        }
        
        if ($includeSubmit) {
            $form->addElement('submit', 'submit');
        }
        
        return $form;
    }
    
    private function _populateForm() {
        //initialize object form if necessary
        if (is_null($this->_sessionForm)) {
            $this->getForm();
            return;
        }
        if (!is_null($this->id)) {
            $this->_sessionForm->id->setValue($this->id);
            $this->_sessionForm->date->setValue((string)$this->date);
            $this->_sessionForm->description->setValue($this->description);
            $this->_sessionForm->synopsis->setValue($this->synopsis);
            $this->_sessionForm->tags->setValue(implode(',',$this->tags));
        }
    }

    /**
     * Loads the object from the given data
     * @param mixed $data a row or form object
     * @param boolean $populateTags Whether to overload the tags, only applies to row objects
     * @throws Exception 
     **/
    public function load( $data, $populateTags = true ) {
        if ( $data instanceof Zend_Db_Table_Row ) {
            return $this->_loadFromRow( $data, $populateTags );
        }
        if ($data instanceof Zend_Form ) {
            return $this->_loadFromForm( $data );
        }
        //TODO load from array
        //data not in acceptable form
        throw new Exception('Can not load session: invalid type');
    }

    private function _loadFromForm( Zend_Form $form ) {
        $sessionId = $form->id->getValue();
        if ( !empty( $sessionId ) ) {
            $this->id = $sessionId;
        }
        $campaignId = $form->campaign->id->getValue();
        if ( !empty( $campaignId ) ) {
            $this->campaign = Tg_Campaign::fetch( $campaignId );
        } else {
            $this->campaign = Tg_Campaign::fetch( );
        }
        $this->campaign->load( $form->campaign );
        $this->date = new Zend_Date( $form->date->getValue() );
        $this->description = $form->description->getValue();
        $this->synopsis = $form->synopsis->getValue();
        //todo media
        //todo author
        $this->tags = explode( ',', $form->tags->getValue() );
        
        $this->_sessionForm = $form;
    }

    private function _loadFromRow( Zend_Db_Table_Row $row, $populateTags = true )
    {
        $this->id = $row->id;
        $this->description = $row->description;
        $this->synopsis = $row->synopsis;
        $this->date = new Zend_Date( $row->date );
        $this->campaign = Tg_Campaign::fetch( $row->campaign );
        $this->author = Tg_User::fetch( $row->author );
        $this->media = Tg_Media::fetch( $row->media );
        if ( $populateTags ) {
            $this->_populateTags( );
        }
        $this->_sesseionRow = $row;
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
       $this->tags = array_merge( $this->tags, $tagTable->getAdapter( )->fetchCol( $select ) );   
    }

    public function save( ) {
        $this->campaign->save();
        $this->media->save();
        $this->author->save();
        $row = $this->_getRow();
        $row->save();
        //reload from row to get new ids (don't override tags)
        $this->load( $row, false );
        $this->_saveTags();
    }
    
    private function _saveTags() {
        $tagTable = $this->_getTagTable();
        $adapter = $tagTable->getAdapter();
        $tags = array_flip($this->tags);
        $tagSet = ( !empty( $this->tags ) ) ? "('" . implode( "','", $this->tags ) . "')" : "()";
        $xrefJoin = "tags.id = tags_xref.tag AND tags_xref.type = " . $adapter->quote('session') . " and tags_xref.entity = " . $adapter->quote($this->id, Zend_Db::INT_TYPE);
        $select = $tagTable->select()
                           ->setIntegrityCheck(false)
                           ->from( $tagTable, array( 'id', 'tag' ) )
                           ->joinLeft( 'tags_xref', $xrefJoin, 'entity')
                           ->where( "tags.tag IN $tagSet" )
                           ->orWhere( "tags_xref.entity = ?", $this->id, Zend_Db::INT_TYPE );
        Zend_Registry::get('log')->debug( (string)$select );
        $existingTagsResult = $adapter->query( $select );
        $existingTagsResult->setFetchMode(Zend_Db::FETCH_OBJ);
        while ( $row = $existingTagsResult->fetch() ) {
            if ( is_null($row->entity) ) {
                //add the missing tag connection
                $adapter->insert('tags_xref', array('tag' => $row->id, 'type' => 'session', 'entity' => $this->id, 'created' => new Zend_Db_Expr( 'NOW()' ) ) );
            }
            if ( isset( $tags[$row->tag] ) ) {
                unset( $tags[$row->tag] );
            } else {
                //remove the new unused tag connection
                $adapter->delete( 'tags_xref', "tag = " . $adapter->quote( $row->id, Zend_Db::INT_TYPE ) .
                                               " AND type = " . $adapter->quote('session') .
                                               " AND entity = " . $adapter->quote( $this->id, Zend_Db::INT_TYPE ) );
            }
        }
        foreach ( $tags as $newTag => $placeHolder) {
            //create the new tag and connection
            $tagId = $adapter->insert( 'tags', array( 'tag' => $newTag, 'created' => new Zend_Db_Expr( 'NOW()' ) ) );
            $adapter->insert('tags_xref', array('tag' => $tagId, 'type' => 'session', 'entity' => $this->id, 'created' => new Zend_Db_Expr( 'NOW()' ) ) );
        }
    }
    
    private function _getRow() {
        if ($this->_sessionRow instanceof Zend_Db_Table_Row_Abstract ) {
            $row = $this->_sessionRow;
        } else {
            $row = $this->_getSessionTable()->createRow();
        }
        $row->campaign = $this->campaign->id;
        $row->description = $this->description;
        $row->synopsis = $this->synopsis;
        //TODO add date format correctly
        $row->date = (string)$this->date;
        $row->media = $this->media->id;
        $row->author = $this->author->id;
        
        return $row;
    }

    //Static methods
    /**
     * fetch a gaming session by id
     * 
     * @param integer $id 
     * @return Tg_Session
     */
    public static function fetch( $id = null )
    {
        $session = new Tg_Session( );
        
        if ( is_null($id) ) {
            $session->campaign = Tg_Campaign::fetch();
            $session->author = Tg_User::fetch();
            $session->media = Tg_Media::fetch();
            return $session;
        }
        
        $sessionTable = $session->_getSessionTable(  );
        $rowset = $sessionTable->find( $id );
        if (is_null($rowset->current())) {
            throw new Exception('Invalid Session Id');
        }
        $session->load( $rowset->current( ) );

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
