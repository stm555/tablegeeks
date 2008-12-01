<?php

/**
 * Tg_User 
 * 
 * @author stm 
 */
class Tg_User
{
    /**
     * unique user id
     * 
     * @var integer
     */
    public $id;

    /**
     * User's common name 
     * 
     * @var string
     */
    public $name;

    /**
     * Data access through table gateway pattern
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_userTable;

    private function _getUserTable(  )
    {
        if ( is_null( $this->_userTable ) )
        {
            require_once ( dirname( __FILE__ ) . '/User/Db/MySql/UserTable.php');
            $this->_userTable = new Tg_User_Db_MySql_UserTable(  );
        }
        return $this->_userTable;
    }

    public function save() {
       //TODO implement this 
    }

    //Static methods
    public static function fetch( $id = null )
    {
        $user = new Tg_User( );
        if ( is_null($id) ) {
            return $user;
        }
        $userTable = $user->_getUserTable(  );
        $rowset = $userTable->find( $id );
        $row = $rowset->current( );
        $user->id = $row->id;
        $user->name = $row->name;

        return $user;
    }
}
