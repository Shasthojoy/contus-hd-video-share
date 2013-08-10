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
 * @abstract      : Contushdvideoshare Component Search Channel View Page
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
 * Contushdvideoshare Component Searchchannel Model
 */
class Modelcontushdvideosharesearchchannel extends JModel {
	/**
	 * initializing constructor
	 */
	function __construct()
	{
		parent::__construct();
		global $usergroup;
	}

	/**
	 * function to search channel
	 */
	function searchChannel($searchValue) {
		$db = $this->getDBO();
		$channelId = $this->getChannel();
		$query = "SELECT a.channel_name,a.id,b.type,b.logo
    			  FROM #__hdflv_channel a 
    			  LEFT JOIN #__hdflv_channelsettings b ON a.id=b.channel_id 
    			  WHERE b.type=1 and a.channel_name LIKE '%$searchValue%' and a.id!=$channelId";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	/**
	 * function to check channel availability
	 */
	function checkAvailability($searchChannelId) {
		$db = $this->getDBO();
		$channelId = $this->getChannel();
		$query = "SELECT id
        		  FROM #__hdflv_channellist 
        		  WHERE channel_id = $channelId AND other_channel = $searchChannelId";
		$db->setQuery($query);
		return $db->loadResult();
	}

	/**
	 * function to save other channels
	 */
	function insertOtherchannel() {
		$channelId = $this->getChannel();
		$otherChannel = JRequest::getVar('channel_id');
                                $otherChannel = explode(",", $otherChannel);

		$db = $this->getDBO();
				for($i=0;$i<count($otherChannel);$i++){
		$query='SELECT id
    			FROM #__hdflv_channellist 
    		WHERE channel_id ='.$channelId.' AND other_channel ='.$otherChannel[$i];
		$db->setQuery($query);
		$id = $db->loadResult();

		if(!$id){
		$query='INSERT INTO #__hdflv_channellist(channel_id,other_channel)
    			VALUES ("'.$channelId.'","'.$otherChannel[$i].'")';
		$db->setQuery($query);
		$db->query();
		}
                }
	}

	/**
	 * function to get channel id
	 */
	function getChannel() {
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "SELECT user_id
    				  FROM #__hdflv_channel 
    				  WHERE id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
		}
		$query = "SELECT id
    			  FROM #__hdflv_channel 
    			  WHERE user_id = $memberId";
		$db->setQuery($query);
		return $db->loadResult();		
	}

	/**
	 * function to delete other channels
	 */
	function deleteChannel() {
		$channelId = $this->getChannel();
		$otherChannel = JRequest::getVar('channel_id');
		$db = $this->getDBO();
		$query="DELETE
    			FROM #__hdflv_channellist 
    			WHERE other_channel = $otherChannel AND channel_id = $channelId";
		$db->setQuery($query);
		$db->query();
	}
}
?>