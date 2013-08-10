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
 * @abstract      : Contushdvideoshare Component Channel Settings Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport( 'joomla.application.component.model' );
// import filesystem libraries
jimport('joomla.filesystem.file');
/**
 * Contushdvideoshare Component Channel Settings Model
 */
class Modelcontushdvideosharechannelsettings extends JModel {

	/**
	 * initializing constructor
	 */
	function __construct()
	{
		parent::__construct();
		global $usergroup;
	}

	/**
	 * function to get myvideos
	 */
	function getMyvideos(){
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT a.id, a.memberid, a.published, a.title 
				  FROM #__hdflv_upload a
				  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        		  LEFT JOIN #__hdflv_category b on e.catid=b.id 
				  WHERE a.memberid = $memberId and a.published=1 and b.published=1";
		$db->setQuery($query);
		$myVideos = $db->loadObjectList();
		return $myVideos;
	}

	/**
	 * function to get myplaylist
	 */
	function getMyplaylist() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT `id`,`category`				  
				  FROM #__hdflv_category 
				  WHERE member_id = $memberId and published=1";
		$db->setQuery($query);
		$myPlaylist = $db->loadObjectList();
		return $myPlaylist;
	}

	/**
	 * function to save channel settings
	 */
	function saveSettings() {
		$app = JFactory::getApplication();
		$uploadLogo = JRequest::getVar('logo', null, 'files', 'array');
		if($uploadLogo['tmp_name'] != '') {	
			$logoName = JFile::makeSafe($uploadLogo['name']);
			$logoTargetPath = "components/com_contushdvideoshare/videos/".$logoName;			
			JFile::upload($uploadLogo['tmp_name'],$logoTargetPath);			
			if(isset($logoName)) {
			JRequest::setVar( 'logo', $logoName, 'post' );
		}
		}
		$channelId = $this->getChannel();
		JRequest::setVar( 'channel_id', $channelId, 'post' );
		$objChaSetTable =& $this->getTable('channelsettings');

		$data = JRequest::get( 'post' );
		

		// Bind the form fields to the hello table
		if (!$objChaSetTable->bind($data)) {
			JError::raiseWarning( 500, $objChaSetTable->getError() );
		}

		// Make sure the hello record is valid
		if (!$objChaSetTable->check()) {
			JError::raiseWarning( 500, $objChaSetTable->getError() );
		}

		// Store the web link table to the database
		if (!$objChaSetTable->store()) {
			JError::raiseWarning( 500, $objChaSetTable->getError() );
		} else {			
			$app->enqueueMessage( 'Channel settings saved successfully.' );
		}
	}

	/**
	 * function to get channel settings
	 */
	function channelSettings(){
		$channelId = $this->getChannel();
		$db = $this->getDBO();
		$query = "SELECT `id`, `channel_id`, `player_width`, `player_height`, `video_row`, `video_colomn`, `logo`, 
				  `recent_videos`, `popular_videos`, `top_videos`, `playlist`, `type`, `start_videotype`, 
				  `start_video`, `start_playlist`, `fb_comment` 
				  FROM #__hdflv_channelsettings 
				  WHERE channel_id = $channelId";
		$db->setQuery($query);
		$channelSettings = $db->loadObjectList();
		return $channelSettings;
	}

	/**
	 * function to get channels
	 */
	function getChannel() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT id 
				  FROM #__hdflv_channel 
				  WHERE user_id = $memberId";
		$db->setQuery($query);
		$channelId = $db->loadResult();
		return $channelId;
	}

	/**
	 *  function for updating recent activity
	 */
	function updateRecentactivity() {
		$channelId = $this->getChannel();
		$db = $this->getDBO();
		$query='UPDATE 
				#__hdflv_channel 
				SET updated_date=now() 
				WHERE id='.$channelId;
		$db->setQuery($query);
		$db->query();
	}
}
?>