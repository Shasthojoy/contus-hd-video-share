<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
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
                $edit_playlist = JRequest::getVar( 'edit_playlist_category' );
                if(isset($edit_playlist)){
               $model->editgetPlaylist($edit_playlist);

                }
		//save playlist		
		if(JRequest::get( 'post' )) {
		$data = JRequest::get( 'post' );
                if(isset($data['category']))
		$category = $data['category'];
                if(isset($category)){
                    $playlistExists = $model->playlistExists();
                }
                if(isset($data['edit_category']))
                $edit_category = $data['edit_category'];
                if(isset($edit_category)){
                $updateplaylist = $model->updatePlaylist();
                }
                if(isset($data['edit_playlist_category']))
                $edit_playlist_category = $data['edit_playlist_category'];
                if(isset($edit_playlist_category)){
                $geteditplaylist = $model->geteditPlaylist();
                $this->assignRef('geteditplaylist', $geteditplaylist);
                }
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

                                $getplaylistsitesettings = $model->getplaylistsitesettings();
		$this->assignRef('getplaylistsitesettings', $getplaylistsitesettings);

		parent::display();
	}

}
?>