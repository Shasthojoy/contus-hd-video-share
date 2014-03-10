<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2011 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   February 2014
 * */
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * Playerbase model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideoshareplayerbase extends ContushdvideoshareModel
{
	/**
	 * Function to get player skin
	 * 
	 * @return  playerskin
	 */
	public function playerskin()
	{
		$playerpath = JURI::base() . 'components/com_contushdvideoshare/hdflvplayer/hdplayer.swf';
		$this->showplayer($playerpath);
	}

	/**
	 * Function to show player
	 * 
	 * @param   string  $playerpath  player skin path
	 * 
	 * @return  showplayer
	 */
	public function showplayer($playerpath)
	{
		ob_clean();
		header("content-type:application/x-shockwave-flash");
		readfile($playerpath);
		exit();
	}
}
