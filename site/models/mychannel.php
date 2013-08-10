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
 * @abstract      : Contushdvideoshare Component Mychannel Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Mychannel Model
 */
class Modelcontushdvideosharemychannel extends JModel {
	/**
	 * initializing constructor
	 */
	function __construct()
	{
		parent::__construct();
		global $usergroup;
	}

	/**
	 * function to get total uploads
	 */
	function getTotaluploads() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT COUNT(id)
    			  FROM #__hdflv_upload
    			  WHERE memberid = $memberId and published=1";
		$db->setQuery($query);
		return $db->loadResult();
	}

        /**
	 * function to get total uploads
	 */
	function getChannelname() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT username
    			  FROM #__users
    			  WHERE id = $memberId";
		$db->setQuery($query);
		return $db->loadResult();
	}

	/**
	 * function to get channel details
	 */
	function getChanneldetails(){
		$db = $this->getDBO();
		$user = JFactory::getUser();
		if(JRequest::getVar('channelname') || JRequest::getVar('channelid')) {
			$channelName = JRequest::getVar('channelname');
			$channelId = JRequest::getVar('channelid');
			if($channelName){
			$where = "a.channel_name = '$channelName'";
			}else if($channelId){
				$where = "a.id = '$channelId'";
			}
		}else {
			$memberId = $user->get('id');
			$where = "a.user_id = '$memberId'";
		}
		$query = "SELECT b.username,a.id, a.user_id, a.channel_name, a.description, a.about_me, a.tags, a.website,
    			  a.channel_views, a.total_uploads, a.recent_activity, a.created_date, a.updated_date
    			  FROM #__hdflv_channel a
                LEFT JOIN #__users b on b.id=a.user_id
    			  WHERE $where";
		$db->setQuery($query);
		$channeldetails = $db->loadObjectList();
                if(isset ($channeldetails) && $channeldetails!=0){
                    return $channeldetails;
                }else{
                    return $channeldetails=0;
                }
	}


	/**
	 * function to update views
	 */
	function updateViews() {
		$db = $this->getDBO();
		$user = JFactory::getUser();
		if(JRequest::getVar('channelname')) {
			$channelName = JRequest::getVar('channelname');
			$where = "channel_name = '$channelName'";
		}else {
			$memberId = $user->get('id');
			$where = "user_id = '$memberId'";
		}
		$query = "UPDATE #__hdflv_channel
    			  SET channel_views=1+channel_views
    			  WHERE $where";
		$db->setQuery($query);
		$db->query();
	}

	/**
	 * function to save channel
	 */
	function saveChannel() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		JRequest::setVar( 'user_id', $memberId, 'post' );
		$date = date();
		JRequest::setVar( 'created_date', $date, 'post' );
		$row =& JTable::getInstance('mychannel', 'Table');
		$data = JRequest::get( 'post' );

		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}


	/**
	 * function to get myplaylist
	 */
	function getMyplaylist() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT `id`, `member_id`, `category`, `seo_category`, `parent_id`, `ordering`, `lft`, `rgt`,
    			  `published`
    			  FROM #__hdflv_category WHERE published=1 and member_id = $memberId";
		$db->setQuery($query);
		return $db->loadObjectList();
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
				  FROM #__hdflv_channelsettings WHERE channel_id = $channelId";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	/**
	 * function to get front end video details
	 */
	function getfrontvideodetails() {
		$startVideo = '';
		$startVideodetails = '';
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$channelSettings = $this->channelSettings();
		if(isset($channelSettings[0])) {
			if($channelSettings[0]->start_videotype == 1) {
				$startVideo = $channelSettings[0]->start_video;
				$where = "a.vid = $startVideo";

			}elseif ($channelSettings[0]->start_videotype == 0) {
				$startVideo = $channelSettings[0]->start_playlist;
				$where = "c.playlistid = $startVideo AND $memberId";
			}
			$query = "SELECT c.* FROM #__hdflv_upload c left join `#__hdflv_video_category` a on c.id=a.vid left join `#__hdflv_category` b on b.id=a.catid WHERE b.published =1 and c.published =1 and $where";
			$db->setQuery($query);
			return $db->loadObjectList();
		}
	}

	/**
	 * function to get channels
	 */
	function getChannel() {
		$db = $this->getDBO();
		if(JRequest::getVar('channelname')) {
			$channelName = JRequest::getVar('channelname');
			$where = "channel_name = '$channelName'";
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
			$where = "user_id = '$memberId'";
		}
		$query = "SELECT id FROM #__hdflv_channel WHERE $where";
		$db->setQuery($query);
		$channelId = $db->loadResult();
                if(isset ($channelId) && $channelId!=0){
                    return $channelId;
                }else{
                    return $channelId=0;
                }
	}

	/**
	 * function to get other channels
	 */
	function getOtherchannels(){
		$channelId = $this->getChannel();
		$db = $this->getDBO();
		$query = "SELECT a.other_channel,b.channel_name,d.logo,d.type
    			  FROM #__hdflv_channellist a
    			  LEFT JOIN #__hdflv_channel b on a.other_channel = b.id
    			  LEFT JOIN #__hdflv_channelsettings d on d.channel_id = b.id
    			  WHERE a.channel_id = $channelId and d.type=1";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	/**
	 * function to get site settings
	 */
	function gethomepagebottomsettings() {
		$db = $this->getDBO();
		$homepagebottomsettings = "SELECT facebookapi,viewedconrtol,ratingscontrol
        						   FROM #__hdflv_site_settings";
		$db->setQuery($homepagebottomsettings);
		return $db->LoadObjectList();
	}

	/**
	 * function to get video id
	 */
	function getVideoid(){
		$title = JRequest::getVar('title');
		$db = $this->getDBO();
		$query = "SELECT id
        		  FROM #__hdflv_upload
        		  WHERE title = '$title'";
		$db->setQuery($query);
		return $db->loadResult();
	}
}
?>