<?php
require_once( 'PHPUnit/Framework.php' );
require_once( dirname( __FILE__ ) . '/../../scripts/bruteDbBuilder.php' );
require_once( dirname( __FILE__ ) . '/../TestHelper.php' );

/**
 * bruteDbBuilderTest 
 * @author stm 
 */
class bruteDbBuilderTest extends PHPUnit_Framework_TestCase
{
    private $connInfo = array( 'host' => bruteDbBuilder::DB_HOST,
                               'username' => bruteDbBuilder::TG_UN,
                               'password' => bruteDbBuilder::TG_PW,
                               'dbname' => bruteDbBuilder::DB_NAME);
    private $dbAdapter;

    public function setUp(  )
    {
        $this->dbAdapter = Zend_Db::factory( 'Pdo_Mysql', $this->connInfo );
    }
    public function tearDown(  )
    {
        $tearDownConnInfo = $this->connInfo;
        $tearDownConnInfo['username'] = bruteDbBuilder::ADMIN_UN;
        $tearDownConnInfo['password'] = bruteDbBuilder::ADMIN_PW;

        $tearDownAdapter = Zend_Db::factory( 'Pdo_Mysql', $tearDownConnInfo  );
        $tearDownAdapter->query( 'DROP DATABASE `tablegeeks`' );
    }

    public function testCreateDb(  )
    {
        $builder = new bruteDbBuilder(  );
        $builder->createDb(  );
        
        $databases = $this->dbAdapter->fetchCol( 'SHOW DATABASES;' );
        
        $this->assertContains( 'tablegeeks', $databases );

    }

    public function testCreateTables(  )
    {
        $builder = new bruteDbBuilder(  );
        $builder->createDb(  );
        $builder->createTables(  );

        $tables = $this->dbAdapter->fetchCol( 'SHOW TABLES' );

        //TODO test for foreign keys as well
        $this->assertContains( 'sessions', $tables );
        $this->assertContains( 'campaigns', $tables );
        $this->assertContains( 'media', $tables );
        $this->assertContains( 'users', $tables );
        $this->assertContains( 'tags', $tables );
        $this->assertContains( 'tags_xref', $tables );
    }

    public function testLoadTestData(  ) {
        $builder = new bruteDbBuilder(  );
        $builder->createDb(  );
        $builder->createTables(  );
        $builder->loadTestData(  );

        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM campaigns WHERE id=?;',9999 );
        $this->assertEquals( 1, $count );
        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM media WHERE id=?;',9999 );
        $this->assertEquals( 1, $count );
        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM sessions WHERE id=?;',9999 );
        $this->assertEquals( 1, $count );
        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM users WHERE id=?;',9999 );
        $this->assertEquals( 1, $count );
        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM tags WHERE id=?;',9999 );
        $this->assertEquals( 1, $count );
        $count = $this->dbAdapter->fetchOne( 'SELECT count( 1 ) as count FROM tags_xref WHERE tag=? AND type=? AND entity=?;',array( 9999,'session',9999) );
        $this->assertEquals( 1, $count );
    }
}
