<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Channel videos View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla view library
jimport('joomla.application.component.view');
/**
 * Contushdvideoshare Component Channel videos Model
 */
class contushdvideoshareViewchannelvideos extends JView
{
	function display($cachable = false, $urlparams = false)
	{
		$channelVideo = JRequest::getVar('channel_videos');
		$model = $this->getModel();
		//get channel videos based on request
		if($channelVideo == 'popular') {
			//get popular videos
			$popularVideos = $model->getPopularvideos();
			$this->assignRef('channelvideos', $popularVideos);
		} elseif ($channelVideo == 'recent') {
			//get recent videos
			$recentVideos = $model->getRecentvideos();
			$this->assignRef('channelvideos', $recentVideos);
		}elseif ($channelVideo == 'toprated') {
			//get top rated videos
			$topratedVideos = $model->getTopratedvideos();
			$this->assignRef('channelvideos', $topratedVideos);
		}
		elseif ($channelVideo == 'playlist') {
			//get playlist videos
			$playlistVideos = $model->getPlaylistvideos();
			$this->assignRef('channelvideos', $playlistVideos);
		}
		JRequest::setVar( 'channelVideo', $channelVideo, 'post' );

		//get channel settings
		$channelSettings = $model->channelSettings();
		$this->assignRef('channelvideorowcol', $channelSettings);

		//get myvideos
		$myVideos = $model->getMyvideos();
		$this->assignRef('myvideos', $myVideos);

		//get playlist
		$myPlaylist = $model->getMyplaylist();
		$this->assignRef('myplaylist', $myPlaylist);

		//get channel id
		$channelId = $model->getChannel();
		$this->assignRef('channelId', $channelId);


		parent::display();
	}

}
?>