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
 * @abstract      : Contushdvideoshare Component Mychannel Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Editchannel Model
 */
class Modelcontushdvideoshareeditchannel extends JModel {

	/**
	 * initializing constructor
	 */
	function __construct()
	{
		parent::__construct();
		global $usergroup;
	}

	/**
	 * function to check channel availability
	 */
	function searchChannel($searchValue) {
		$db = $this->getDBO();
		$query = "SELECT a.channel_name,b.type
    			  FROM #__hdflv_channel a 
    			  LEFT JOIN #__hdflv_channelsettings b on a.id=b.channel_id 
    			  WHERE b.type=1 AND a.channel_name LIKE '$searchValue%'";
		$db->setQuery($query);
		return $db->loadObjectList();
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
    			  WHERE memberid = $memberId";
		$db->setQuery($query);
		return $db->loadResult();
	}

	/**
	 * function to get channel details
	 */
	function getChanneldetails(){
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT `id`, `user_id`, `channel_name`, `description`, `about_me`, `tags`, `website`,
    			  `channel_views`, `total_uploads`, `recent_activity`, `created_date`, `updated_date` 
    			  FROM #__hdflv_channel 
    			  WHERE user_id = $memberId";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

        /**
	 * function to check channel existance
	 */
        function checkChannelexistance() {
                $db = $this->getDBO();
		$data = JRequest::get( 'post' );
                $channelName = $data['channel_name'];
                $channelId = $data['id'];
                if ($channelId) {
                    $where = 'id <> ' . $channelId . ' AND ' . 'channel_name = ' . "'$channelName'";
                } else {
                    $where = 'channel_name=' . "'$channelName'";
                }
		$query = "SELECT id
        		  FROM #__hdflv_channel
        		  WHERE $where";
		$db->setQuery($query);
		$channelId = $db->loadResult();
                return $channelId;

        }

	/**
	 * function to save channel
	 */
	function saveChannel() {
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		JRequest::setVar( 'user_id', $memberId, 'post' );
		$row = JTable::getInstance('mychannel', 'Table');
		$data = JRequest::get( 'post' );
		//$data['description'] = JRequest::getVar('description','','POST','STRING',JREQUEST_ALLOWHTML);
                $data['description'] = $_REQUEST['description'];
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
	 * function to get myvideos
	 */
	function getMyvideos(){
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT `id`, `memberid`, `published`, `title`, `seotitle`, `featured`, `type`, `rate`,
				  `ratecount`, `times_viewed`, `videos`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, 
				  `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, 
				  `prerollads`, `midrollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid`, 
				  `created_date`, `addedon`, `usergroupid`, `tags`, `useraccess`
				  FROM #__hdflv_upload WHERE memberid = $memberId";
		$db->setQuery($query);
		return $db->loadObjectList();
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
    			  FROM #__hdflv_category 
    			  WHERE published=1 AND member_id = $memberId";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	/**
	 * function to save channel settings
	 */
	function saveSettings() {
		$data = JRequest::get( 'post' );
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		JRequest::setVar( 'channel_id', $memberId, 'post' );
		$row = $this->getTable('channelsettings');

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
	 * function to get channel settings
	 */
	function channelSettings(){
		$user = JFactory::getUser();
		$memberId = $user->get('id');
		$db = $this->getDBO();
		$query = "SELECT `id`, `channel_id`, `player_width`, `player_height`, `video_row`, `video_colomn`, `logo`,
				  `recent_videos`, `popular_videos`, `top_videos`, `playlist`, `type`, `start_videotype`, 
				  `start_video`, `start_playlist`, `fb_comment` 
				  FROM #__hdflv_channelsettings 
				  WHERE channel_id = $memberId";
		$db->setQuery($query);
		return $db->loadObjectList();

	}
	/**
	 *  function for updating recent activity
	 */
	function updateRecentActivity() {
		$channelId = $this->getChannel();
		$db = $this->getDBO();
		$query='UPDATE #__hdflv_channel
        		SET updated_date=now() 
        		WHERE id='.$channelId;
		$db->setQuery($query);
		$db->query();
	}

	/**
	 * function to get channel id
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
}
?>