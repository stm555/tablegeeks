<?php
require_once 'Session.php';
/**
 * PodcastController 
 * 
 * @author stm 
 */
class PodcastController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * indexAction 
     * 
     * @return void
     */
    public function indexAction()
    {
        $log = Zend_Registry::get( 'log' );
        $log->info( 'index action of Podcast controller' );
        $sessions = Tg_Session::fetchAll(  );
	$this->view->sessions = $sessions;
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setViewSuffix('pxml');
    }

}
