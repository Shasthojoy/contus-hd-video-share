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
 * @abstract      : Contushdvideoshare Component Playlist View Page
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
 * hdvideoshare component playlist view page
 *
 */
class contushdvideoshareViewplaylist extends JView
{
	/**
	 * function to prepare view for playlist view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$app = JFactory::getApplication();
		$model = $this->getModel();
		//save playlist		
		if(JRequest::get( 'post' )) {
			$playlistExists = $model->playlistExists();
			if(!$playlistExists) {
				$saveSettings = $model->savePlaylist();
			}else {				
				JError::raiseWarning( 100, JText::_('HDVS_PLAYLIST_EXISTS') );
				$app->redirect('index.php?option=com_contushdvideoshare&view=playlist');
			}
			//update recent activity
			$updateRecentactivity = $model->updateRecentactivity();
		}

		//get myvideos
		$myVideos = $model->getMyvideos();
		$this->assignRef('myvideos', $myVideos);

		//get playlists
		$playList = $model->getPlaylist();
		$this->assignRef('channelvideos', $playList);

		if(JRequest::getString('category')) {
			//get videos for playlist
			$playlistVideos = $model->getplaylistVideos();
			$this->assignRef('playlistvideos', $playlistVideos);
		}

		$channelName = $model->getChannel();
		$this->assignRef('channelName', $channelName);

		parent::display();
	}

}
?>