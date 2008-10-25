<?php 
// ** Check to see if the environment is already setup **
if (isset($bootstrap) && $bootstrap) { 
    // Enable all errors so we'll know when something goes wrong. 
    error_reporting(E_ALL | E_STRICT);  
    ini_set('display_startup_errors', 1);  
    ini_set('display_errors', 1); 
 
    // Add our {{library}} directory to the include path so that PHP can find the Zend Framework classes.
    // you may wish to add other paths here, or keep system paths: set_include_path('../library' . PATH_SEPARATOR . get_include_path() 
    set_include_path('../library' . PATH_SEPARATOR . realpath(dirname(__FILE__).'/../') . PATH_SEPARATOR . get_include_path());  
 
    // Set up autoload. 
    // This is a nifty trick that allows ZF to load classes automatically so that you don't have to litter your 
    // code with 'include' or 'require' statements. 
    require_once "Zend/Loader.php"; 
    Zend_Loader::registerAutoload(); 
} 
 
// ** Get the front controller ** 
// The Zend_Front_Controller class implements the Singleton pattern, which is a design pattern used to ensure 
// there is only one instance of Zend_Front_Controller created on each request. 
$frontController = Zend_Controller_Front::getInstance(); 
 
// Point the front controller to your action controller directory. 
$frontController->setControllerDirectory('../application/controllers'); 
 
// ** Load and register Basic Configuration File **
$config = new Zend_Config_Xml( dirname( __FILE__ ) . '/configs/tablegeeks.xml' );
Zend_Registry::set( 'config', $config );

// ** Initialize Logging

$log = new Zend_Log( new Zend_Log_Writer_Firebug( ) );
Zend_Registry::set( 'log', $log );

// ** Load and register db access 
$profiler = new Zend_Db_Profiler_Firebug( 'All DB Queries' );
$db = Zend_Db::factory( $config->db->connection );
$profiler->setEnabled( $config->db->profiler->enabled );
$db->setProfiler( $profiler );
Zend_Registry::set( 'db', $db );
Zend_Db_Table_Abstract::setDefaultAdapter( $db );

$frontController->throwExceptions(true);
        
