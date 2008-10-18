<?php

abstract class Stm_MultiStorageModel_Abstract 
{
    const STORAGE_DB = 0;

    protected static $_storageType;

    /**
     * Validates storage type then sets it as the global storagetype
     */
    public static function setStorage( $storageType )
    {
        //Add a check here for every new storage type
        if ( $storageType !== self::STORAGE_DB
        // || $storageType !== [your storage type here]     
                )
        {
            throw new Exception( 'Invalid Storage Type' );
        }

        self::$_storageType = $storageType;
    }

    /**
     * getStorageAdapter pulls the correct storage adpater based on
     * the storage type
     * 
     * @return mixed
     */
    abstract public function getStorageAdapter( );
}
