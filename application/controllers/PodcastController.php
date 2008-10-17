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
        //mock data
		$session = new Tg_Session();
		$session->campaign = new Tg_Campaign();
		$session->campaign->name = "Grand Campaign!";
		$session->date = new Zend_Date( "10/14/2008" );
		$session->author = new Tg_User();
		$session->author->name = "stm";
		$session->description = "Wherein grand things happen to our heroes";
		$session->synopsis = "Lots of interesting things happen to our heroes in this episode!";
		$session->media = new Tg_Media( );
		$session->media->path = "/path/to/media.m4a";
		$session->media->size = 12345;
		$session->media->mimetype = "audio/x-m4a";
		$session->media->duration = 34;
		$session->addDate = new Zend_Date( "10/13/2008 3:00:00 PM CST" );
		$session->tags = array('fun','dragon','cthulu');
		//FIXME need to use a project defined base path here ..
		$viewHelpersPath = realpath(dirname(__FILE__) . '/../views/helpers');
		$this->view->addHelperPath($viewHelpersPath,'Tg_View_Helper');
		$this->view->sessions = array($session,$session,$session);
		$this->_helper->viewRenderer->setViewSuffix('pxml');
    }

}
