<?php
require_once dirname( __FILE__ ) . '/../../library/Stm/MultiStorageModel/Abstract.php';
require_once 'User.php';
require_once 'Campaign.php';
require_once 'Media.php';

/**
 * Tg_Session 
 * 
 * @author stm 
 */
class Tg_Session extends Stm_MultiStorageModel_Abstract
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

    /**
     * Data access through table gateway pattern
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_table;

    public function getStorageAdapter( )
    {
        switch ( $this->_storageType )
        {
            case self::STORAGE_DB:
                return $this->_getTable( );
            case null:
                throw new Exception ( 'Storage Type Not Set' );
            default:
                throw new Exception ( 'Unsupported Storage Type Set' );
        }
    }

    private function _getTable(  )
    {
        if ( is_null( $this->_table ) )
        {
            require_once ( dirname( __FILE__ ) . '/Session/Db/MySql/Table.php');
            $this->_table = new Tg_Session_Db_MySql_Table(  );
        }
        return $this->_table;
    }

}
