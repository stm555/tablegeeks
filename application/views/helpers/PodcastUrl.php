<?php
class Tg_View_Helper_PodcastUrl extends Zend_View_Helper_Abstract
{
	/**
	 * Takes a local path to a podcast file and converts it into a valid url
	 *
	 * @param string $filePath Path to podcast audio file
	 * @return string
	 * @author stm
	 **/
	public function podcastUrl($filePath)
	{
		return "http://tablegeeks.com/audio/12345.m4a";
	}
}
