<?php
require_once 'application/models/Session.php';
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
		//FIXME need to use a project defined base path here ..
		$viewHelpersPath = realpath(dirname(__FILE__) . '/../views/helpers');
		$this->view->addHelperPath($viewHelpersPath,'Tg_View_Helper');
		$this->view->sessions = $sessions;
		$this->_helper->viewRenderer->setViewSuffix('pxml');
    }

}
