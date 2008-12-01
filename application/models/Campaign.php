<?php
class Tg_Campaign
{

    /**
     * unique campaign id
     * 
     * @var integer
     */
    public $id;

    /**
     * Campaign Name 
     * 
     * @var string
     */
    public $name = '';

    /**
     * Data access through table gateway pattern
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_campaignTable;
    
    /**
     * Data access through the table row pattern
     *
     * @var Zend_Db_Table_Row_Abstract
     **/
    protected $_campaignRow;
    
    /**
     * Form
     * 
     * @var Zend_Form
     */
    protected $_campaignForm;

    private function _getCampaignTable(  )
    {
        if ( is_null( $this->_campaignTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/Campaign/Db/MySql/CampaignTable.php');
            $this->_campaignTable = new Tg_Campaign_Db_MySql_CampaignTable(  );
        }
        return $this->_campaignTable;
    }

    //Static methods
    public static function fetch( $id = null )
    {
        $campaign = new Tg_Campaign( );
        
        if (is_null($id)) {
            return $campaign;
        }
        
        $campaignTable = $campaign->_getCampaignTable(  );
        $rowset = $campaignTable->find( $id );
        $campaign->load( $rowset->current( ) );

        return $campaign;
    }
    
    public function load( $data ) {
        if ( $data instanceof Zend_Form ) {
            return $this->_loadFromForm( $data );
        }
        //TODO load from row
        if ( $data instanceof Zend_Db_Table_Row ) {
            return $this->_loadFromRow( $data );
        }
        //TODO load from array
        throw new Exception('Can not load Campaign: invalid type');
    }
    
    private function _loadFromForm( Zend_Form $form ) {
        $this->id = $form->id->getValue();
        $this->name = $form->name->getValue();
        
        $this->_campaignForm = $form;
    }
    
    private function _loadFromRow ( Zend_Db_Table_Row $row ) {
        $this->id = $row->id;
        $this->name = $row->name;
        
        $this->_campaignRow = $row;
    }
    
    public function getForm( $includeSubmit = false) {
        if ($this->_campaignForm instanceof Zend_Form) {
            $form = $this->_campaignForm;
        } else {
            $form = new Zend_Form();
            $form->setIsArray(true);
            $form->addElement('hidden', 'id');
            $form->addElement('text','name', array('label' => 'Campaign'));
            $nameField = $form->getelement('name');
            $nameField->setRequired(true);
            
            $this->_campaignForm = $form;
            $this->_populateForm();
            $form = $this->_campaignForm;
        }
        
        if ($includeSubmit) {
            $form->addElement('submit', 'submit');
        }
        
        return $form;
    }
    
    private function _populateForm() {
        //initialize object form if necessary
        if (is_null($this->_campaignForm)) {
            $this->getForm();
            return;
        }
        if (!is_null($this->id)) {
            $this->_campaignForm->id->setValue($this->id);
            $this->_campaignForm->name->setValue($this->name);
        }
    }
    
    private function _getRow() {
        if ( $this->_campaignRow instanceof Zend_Db_Table_Row ) {
            $row = $this->_campaignRow;
        } else {
            $row = $this->_getCampaignTable()->createRow();
        }
        
        $row->id = $this->id;
        $row->name = $this->name;
        
        $this->_campaignRow = $row;
        
        return $row;
    }
    
    public function save() {
        //TODO see if an existing campaign all ready exists to reuse
        $row = $this->_getRow();
        $row->save();
        //reload from row to get ids
        $this->load( $row );
    }
}
