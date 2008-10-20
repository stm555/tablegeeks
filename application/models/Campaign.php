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
    public static function fetch( $id )
    {
        $campaign = new Tg_Campaign( );
        $campaignTable = $campaign->_getCampaignTable(  );
        $rowset = $campaignTable->find( $id );
        $row = $rowset->current( );
        $campaign->id = $row->id;
        $campaign->name = $row->name;

        return $campaign;
    }
}
