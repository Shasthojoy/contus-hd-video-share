<?php
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Channel Videos Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
//define ('DIRECTORY_SEPARATOR', "/");
//define( 'DS', DIRECTORY_SEPARATOR );
class Modelcontushdvideosharechannelvideos extends JModel {

	//var $usergroup = null;
	function __construct()
	{
		parent::__construct();
		global $usergroup;


	}

	/*function for getting popular videos*/
	function getPopularvideos() {
		$limit = '';
		$length = '';
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "SELECT user_id FROM #__hdflv_channel WHERE id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
		}
		$viewrow = $this->channelSettings();
		$query = "SELECT count(a.id)
        			   	 FROM  #__hdflv_upload a 
        			   	 LEFT JOIN #__users d on a.memberid=d.id 
        			     LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
        				 WHERE a.published=1 AND a.memberid = $memberId AND b.published=1 AND a.published=1 AND a.type='0'";
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page'))
		{
			$pageno = JRequest::getVar('page');
		}
		if(isset($viewrow[0])) {
			$length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
		}
		if($length != 0) {
			$pages = ceil($total/$length);
		}
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		$popularquery = "SELECT a.id,a.filepath,a.created_date,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
					   	 a.videourl,a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid 
        				 FROM #__hdflv_upload a 
        				 LEFT JOIN #__users d on a.memberid=d.id 
        				 LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        				 LEFT JOIN #__hdflv_category b on e.catid=b.id 
        				 WHERE a.published='1' and a.type='0' and b.published=1 and a.memberid=$memberId 
        				 GROUP BY e.vid 
        				 ORDER BY a.times_viewed desc 
        				 LIMIT $start,$length";
		$db->setQuery($popularquery);
		$popularvideos = $db->loadobjectList();
		$rows = $popularvideos;
		return $rows;
	}

	/*function for getting recent videos*/
	function getRecentvideos() {
		$limit = '';
		$length = '';
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "SELECT user_id FROM #__hdflv_channel WHERE id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user =& JFactory::getUser();
			$memberId = $user->get('id');
		}
		$viewrow = $this->channelSettings();
		$query = "SELECT count(a.id)
        		  FROM  #__hdflv_upload a 
        		  LEFT JOIN #__users d on a.memberid=d.id 
        		  LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
        		  WHERE a.published=1 AND b.published=1 AND a.published=1 AND a.type='0' and a.memberid = $memberId";
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page'))
		{
			$pageno = JRequest::getVar('page');
		}
		if(isset($viewrow[0])) {
			$length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
		}
		if($length != 0) {
			$pages = ceil($total/$length);
		}
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		$recentquery = "SELECT a.id,a.filepath,a.created_date,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
					   	a.videourl,a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid 
    					FROM  #__hdflv_upload a 
    					LEFT JOIN #__users d on a.memberid=d.id 
    					LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
    					LEFT JOIN #__hdflv_category b on e.catid=b.id 
    					WHERE a.published='1' and b.published=1 and a.type='0' and a.memberid=$memberId 
    					GROUP BY e.vid 
    					ORDER BY a.id desc 
    					LIMIT $start,$length";
		$db->setQuery($recentquery);
		$recentvideos = $db->loadobjectList();//echo '<pre>';print_r($recentvideos);exit;
		$rows = $recentvideos;
		return $rows;
	}

	/*function for getting top rated videos*/
	function getTopratedvideos() {
		$limit = '';
		$length = '';
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "select user_id from #__hdflv_channel where id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user =& JFactory::getUser();
			$memberId = $user->get('id');
		}
		$viewrow = $this->channelSettings();
		$query = "SELECT count(a.id)
        		  FROM  #__hdflv_upload a 
        		  LEFT JOIN #__users d on a.memberid=d.id 
        		  LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
        		  WHERE a.published=1 AND b.published=1 AND a.published=1 AND a.type='0' and a.memberid = $memberId";
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page'))
		{
			$pageno = JRequest::getVar('page');
		}
		if(isset($viewrow[0])) {
			$length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
		}
		if($length != 0) {
			$pages = ceil($total/$length);
		}
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		$topratedquery = "SELECT a.id,a.filepath,a.created_date,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
					   	  a.videourl,a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid 
    					  FROM  #__hdflv_upload a LEFT JOIN #__users d on a.memberid=d.id 
    					  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
    					  LEFT JOIN #__hdflv_category b on e.catid=b.id 
    					  WHERE a.published='1' and b.published=1 and a.type='0' and a.memberid=$memberId 
    					  GROUP BY e.vid 
    					  ORDER BY a.rate desc 
    					  LIMIT $start,$length";
		$db->setQuery($topratedquery);
		$topratedvideos = $db->loadobjectList();//echo '<pre>';print_r($topratedvideos);
		return $topratedvideos;
	}

	/*function for getting playlist videos*/
	function getPlaylistvideos() {
		$limit = '';
		$length = '';
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "select user_id from #__hdflv_channel where id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user =& JFactory::getUser();
			$memberId = $user->get('id');
		}
		$viewrow = $this->channelSettings();
		$query = "SELECT count(id)
    			  FROM #__hdflv_category 
    			  WHERE member_id = $memberId AND published=1";
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page'))
		{
			$pageno = JRequest::getVar('page');
		}
		if(isset($viewrow[0])) {
			$length = $viewrow[0]->video_row * $viewrow[0]->video_colomn;
		}
		if($length != 0) {
			$pages = ceil($total/$length);
		}
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		$playlistquery = "SELECT distinct(a.playlistid)
    					  FROM #__hdflv_upload a
    					  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        			  	  LEFT JOIN #__hdflv_category b on e.catid=b.id 
    					  WHERE a.memberid=$memberId and b.published=1 AND a.published=1
    					  LIMIT $start,$length";
		//$playlistquery = "select a.*,b.category,b.seo_category,d.username,e.* from  #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' and a.playlistid in (select distinct(playlistid) from #__hdflv_upload where memberid=$memberId) group by e.vid limit 0,$limit ";
		$db->setQuery($playlistquery);
		$playlist = $db->loadobjectList();
		if(!empty($playlist)) {
			for($i=0;$i<count($playlist);$i++) {
				//echo $i;
				$playlistId = $playlist[$i]->playlistid;
				$query = "SELECT a.*,b.category,b.seo_category,d.username,e.*
        			  FROM  #__hdflv_upload a 
        			  LEFT JOIN #__users d on a.memberid=d.id 
        			  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        			  LEFT JOIN #__hdflv_category b on e.catid=b.id 
        			  WHERE a.published='1' and a.type='0' and a.memberid=$memberId and a.playlistid=$playlistId 
        			  LIMIT 1";
				$db->setQuery($query);
				$playlistdvideos = $db->loadobjectList();
				$playlistArray[$i] = $playlistdvideos;
			}
			return $playlistArray;
		}
	}

	/*function to get channel settings*/
	function channelSettings(){
		$channelId = $this->getChannel();
		$db = $this->getDBO();
		$query = "select * from #__hdflv_channelsettings where channel_id = $channelId";
		$db->setQuery($query);
		$channelSettings = $db->loadObjectList();
		return $channelSettings;
	}

	/*function to get channel id*/
	function getChannel() {
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "select user_id from #__hdflv_channel where id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
		}
		$query = "select id from #__hdflv_channel where user_id = $memberId";
		$db->setQuery($query);
		$channelId = $db->loadResult();
		return $channelId;
	}

	/*function to get myvideos*/
	function getMyvideos(){
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "SELECT user_id FROM #__hdflv_channel WHERE id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
		}
		$query = "SELECT count(a.id)
        		  FROM  #__hdflv_upload a 
        		  LEFT JOIN #__users d on a.memberid=d.id 
        		  LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
        		  WHERE a.published=1 AND b.published=1 AND a.type='0' and a.memberid = $memberId";
		$db->setQuery($query);
		$myVideos = $db->loadResult();
		return $myVideos;
	}

	/*function to get myplaylist*/
	function getMyplaylist() {
		$db = $this->getDBO();
		if(JRequest::getVar('channelid')) {
			$channelId = JRequest::getVar('channelid');
			$query = "SELECT user_id FROM #__hdflv_channel WHERE id = $channelId";
			$db->setQuery($query);
			$memberId = $db->loadResult();
		}else {
			$user = JFactory::getUser();
			$memberId = $user->get('id');
		}
		$query = "SELECT count(distinct(a.playlistid))
    			  FROM #__hdflv_upload a
    			  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        		  LEFT JOIN #__hdflv_category b on e.catid=b.id 
    			  WHERE a.memberid=$memberId and b.published=1";
		$db->setQuery($query);
		$myPlaylist = $db->loadResult();
		return $myPlaylist;
	}
function getsettings() {
		$db = $this->getDBO();
		//Query is to select the home page botom videos settings
		$homepagebottomsettings = "SELECT * FROM #__hdflv_site_settings";
		$db->setQuery($homepagebottomsettings);
		$rows = $db->LoadObjectList();
		return $rows;
	}

}
?>