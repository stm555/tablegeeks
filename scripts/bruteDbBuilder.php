<?php
define( BASE_PATH, dirname( __FILE__ ));
class bruteDbBuilder {

    const MYSQL_CLIENT = '~/bin/mysql';
    const DB_HOST = 'localhost';
    const DB_NAME = 'tablegeeks';
    const ADMIN_UN = 'root';
    const ADMIN_PW = 'smartone';
    const TG_UN = 'tablegeeks';
    const TG_PW = 'geeks@tables';

    protected function buildCmd( $user, $pw, $file, $dbName = null )
    {
        $cmd = self::MYSQL_CLIENT 
             . ' -u ' . escapeshellarg( $user ) 
             . ' -p' . escapeshellarg( $pw );
        $cmd .= ( !is_null( $dbName ) ) ? ' ' . escapeshellarg( $dbName ) . ' ' : null;
        $cmd .= ' < '. escapeshellarg( $file);
        return $cmd;
    }

    private function execFile( $un, $pw, $file, $dbName = null)
    {
        $cmd = $this->buildCmd( $un, $pw, $file, $dbName );
        exec( $cmd, $output, $exitCode );
        if ( $exitCode !== 0 )
        {
            throw new Exception ( 'Error executing file ' . $file . "\n" . implode( '\n', $output ) );
        }
    }

    public function createDb(  ) {
        $this->execFile( self::ADMIN_UN, self::ADMIN_PW, BASE_PATH . '/schema/mysql/tablegeeks.schema.sql' );
    }

    public function createTables(  ) {
        $tableDefinitions = glob( realpath( BASE_PATH ) . '/schema/mysql/*.table.sql' );
        foreach ( $tableDefinitions as $tableDef )
        {
           $this->execFile( self::TG_UN, self::TG_PW, $tableDef, self::DB_NAME ); 
        }
        $this->createForeignkeys(  );
    }

    private function createForeignkeys(  ) {
        $fkDefinitions = glob( realpath( BASE_PATH ) . '/schema/mysql/*.fk.sql' );
        foreach ( $fkDefinitions as $fkDef )
        {
           $this->execFile( self::TG_UN, self::TG_PW, $fkDef, self::DB_NAME ); 
        }

    }

    public function loadTestData(  ) {
        $this->execFile( self::TG_UN, self::TG_PW, BASE_PATH . '/data/mysql/testData.build.sql', self::DB_NAME );
    }
}

