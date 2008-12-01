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
     * unique media id
     * 
     * @var integer
     */
    public $id;

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
     * Data access through table gateway pattern
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_mediaTable;
    
    /**
     * Form
     *
     * @var Zend_Form
     */
    protected $_mediaForm;

    private function _getMediaTable(  )
    {
        if ( is_null( $this->_mediaTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/Media/Db/MySql/MediaTable.php');
            $this->_mediaTable = new Tg_Media_Db_MySql_MediaTable(  );
        }
        return $this->_mediaTable;
    }

    //Static methods
    public static function fetch( $id = null )
    {
        $media = new Tg_Media( );
        if ( is_null( $id ) ) {
            return $media;
        }
        $mediaTable = $media->_getMediaTable(  );
        $rowset = $mediaTable->find( $id );
        $row = $rowset->current( );
        $media->id = $row->id;
        $media->path = $row->path;
        $media->size = $row->size;
        $media->mimetype = $row->mimetype;
        $media->duration = $row->duration;

        return $media;
    }

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
    
    //todo update this form to use a file upload field
    public function getForm( $includeSubmit = false) {
        if ($this->_mediaForm instanceof Zend_Form) {
            $form = $this->_mediaForm;
        } else {
            $form = new Zend_Form();
            $form->setIsArray(true);
            $form->addElement('hidden', 'id');
            $form->addElement('text','name', array('label' => 'media'));
            
            $this->_mediaForm = $form;
            $this->_populateForm();
            $form = $this->_mediaForm;
        }
        
        if ($includeSubmit) {
            $form->addElement('submit', 'submit');
        }
        
        return $form;
    }
    //TODO update this form as appropriate
    private function _populateForm() {
        //initialize object form if necessary
        if (is_null($this->_mediaForm)) {
            $this->getForm();
            return;
        }
        if (!is_null($this->id)) {
            $this->_mediaForm->id->setValue($this->id);
            $this->_mediaForm->name->setValue($this->name);
        }
    }
    
    //TODO implement this
    public function save() {
    }
}
