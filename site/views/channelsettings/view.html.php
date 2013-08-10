<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Channel Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * hdvideoshare component channel settings view page
 *
 */
class contushdvideoshareViewchannelsettings extends JView
{
	/**
	 * function to prepare view for channel settings view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		//get myvideos
		$myVideos = $model->getMyvideos();
		$this->assignRef('myvideos', $myVideos);

		//get playlist
		$myPlaylist = $model->getMyplaylist();
		$this->assignRef('myplaylist', $myPlaylist);

		//save settings
		if(JRequest::get( 'post' )) {
			$saveSettings = $model->saveSettings();
			//update recent activity
			$updateRecentactivity = $model->updateRecentactivity();
		}

		//get channel settings value
		$channelSettings = $model->channelSettings();
		$this->assignRef('channelsettings', $channelSettings);
		parent::display();
	}
}
?>