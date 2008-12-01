<?php
class Tg_View_Helper_PodcastUrl extends Zend_View_Helper_Abstract
{
	/**
	 * Takes a local path to a podcast file and converts it into a valid url
         *
         * @TODO user of the SERVER_NAME super global is probably a security hole -- switch to configuration value
	 *
	 * @param string $filePath Path to podcast audio file
	 * @return string
	 * @author stm
	 **/
	public function podcastUrl($filePath)
	{
		return "http://{$_SERVER['SERVER_NAME']}" . $this->view->baseUrl() . "/audio/12345.m4a";
	}
}
