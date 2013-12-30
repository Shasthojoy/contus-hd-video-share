<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Category Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Category Model
 */
class Modelcontushdvideosharecategory extends ContushdvideoshareModel {
	/* function is to display the video results of related category */
	function getcategory()
	{
		$category = 0;
		$db = $this->getDBO();
		$flatCatid = is_numeric(JRequest::getString('category'));
		if (JRequest::getString('category') && $flatCatid != 1) {
			$catvalue = str_replace(':', '-', JRequest::getString('category'));
			$query = 'SELECT id FROM #__hdflv_category WHERE seo_category="' . $catvalue . '"';
			$db->setQuery($query);
			$catid = $db->loadResult();
		} else if ($flatCatid == 1) {
			$catid = JRequest::getString('category');
		} else if (JRequest::getInt('catid')) {
			$catid = JRequest::getInt('catid');
		} else {
			$query_catid = "SELECT id FROM #__hdflv_category WHERE published=1 ORDER BY category asc"; // this query is for category view pagination
			$db->setQuery($query_catid);
			$searchtotal1 = $db->loadObjectList();
			//     print_r($searchtotal1);
			$catid = $searchtotal1[0]->id;
		} //Category id is stored in this catid variable
		if(!version_compare(JVERSION, '3.0.0', 'ge'))
		$catid = $db->getEscaped($catid);
		//query to calculate total number of videos in paricular category
		$totalquery = "SELECT a.*,b.id as cid,b.category,b.seo_category,b.parent_id,c.*
        			   FROM #__hdflv_upload a
                                   LEFT JOIN #__users d on a.memberid=d.id 
        			   LEFT JOIN #__hdflv_video_category c on a.id=c.vid 
        			   LEFT JOIN #__hdflv_category b on c.catid=b.id 
        			   WHERE (c.catid=$catid OR b.parent_id = $catid OR a.playlistid=$catid) 
        			   AND a.published=1 AND b.published=1 AND d.block=0 order by b.id asc";
		$db->setQuery($totalquery);
		$searchtotal = $db->loadObjectList();
		$subtotal = count($searchtotal);
		$total = $subtotal;
		$pageno = 1;
		if (JRequest::getVar('page', '', 'post', 'int')) {
			$pageno = JRequest::getVar('page', '', 'post', 'int');
		}
		$limitrow = $this->getcategoryrowcol();
                $thumbview       = unserialize($limitrow[0]->thumbview);
		$length = $thumbview['categoryrow'] * $thumbview['categorycol'];
		$pages = ceil($total / $length);
		if ($pageno == 1)
		$start = 0;
		else
		$start= ( $pageno - 1) * $length;
		// This query for displaying category's full view display
		$categoryquery = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,a.streameroption,a.streamerpath,a.videourl,
							  a.times_viewed,a.seotitle,b.category,b.seo_category,b.parent_id,d.username,e.catid,e.vid 
            				  FROM #__hdflv_upload a 
            				  LEFT JOIN #__users d on a.memberid=d.id 
            				  LEFT JOIN #__hdflv_video_category e on a.id=e.vid 
            				  LEFT JOIN #__hdflv_category b on e.catid=b.id 
            				  WHERE (e.catid=$catid OR a.playlistid=$catid OR b.parent_id = $catid ) 
            				  AND a.published=1 AND b.published=1 AND d.block=0
            				  GROUP BY e.vid 
            				  ORDER BY b.ordering asc
            				  LIMIT $start,$length";       
		$db->setQuery($categoryquery);
		$rows = $db->LoadObjectList();

		$categoryquery = "SELECT category FROM #__hdflv_category WHERE id=$catid"; // This query for displaying category's full view display
		$db->setQuery($categoryquery);
		$category = $db->LoadObjectList();
		// Below code is to merge the pagination values like pageno,pages,start value,length value
		if (count($rows) > 0)
		{
			$insert_data_array = array('categoryname' => $category);
			$rows = array_merge($rows, $insert_data_array);
			$insert_data_array = array('pageno' => $pageno);
			$rows = array_merge($rows, $insert_data_array);
			$insert_data_array = array('pages' => $pages);
			$rows = array_merge($rows, $insert_data_array);
			$insert_data_array = array('start' => $start);
			$rows = array_merge($rows, $insert_data_array);
			$insert_data_array = array('length' => $length);
			$rows = array_merge($rows, $insert_data_array);
		} else {
			$categoryquery = "select * from #__hdflv_category where id=$catid"; // This query for displaying category's full view display
			$db->setQuery($categoryquery);
			$rows = $db->LoadObjectList();
		}
		// merge code ends here
		return $rows;
	}
	/* function to get category view settings */
	function getcategoryrowcol()
	{
		$db = $this->getDBO();
		//query to get category view settings
		$query = "SELECT thumbview,dispenable
        		  FROM #__hdflv_site_settings"; 
		$db->setQuery($query);
		$rows = $db->LoadObjectList();
		return $rows;
	}
	## function to get category view settings */
	function getplayersettings()
	{
		$db = $this->getDBO();
		$query          = "SELECT player_values FROM #__hdflv_player_settings";
                $db->setQuery($query);
                $settingsrows   = $db->loadResult();
		return $settingsrows;
	}

	function getcategoryid()
	{
		$db = $this->getDBO();
		$flatCatid = is_numeric(JRequest::getString('category'));
		if (JRequest::getString('category') && $flatCatid != 1) {
			$catvalue = str_replace(':', '-', JRequest::getString('category'));
			if(!version_compare(JVERSION, '3.0.0', 'ge'))
			$catvalue = $db->getEscaped($catvalue);

			$query = 'select id from #__hdflv_category where seo_category="' . $catvalue . '"';
			$db->setQuery($query);
			$catid = $db->loadResult();
		} else if ($flatCatid == 1) {
			$catid = JRequest::getString('category');
		} else if (JRequest::getInt('catid')) {
			$catid = JRequest::getInt('catid');
		} else {
			$query_catid = "select id from #__hdflv_category where published=1 order by category asc"; // this query is for category view pagination
			$db->setQuery($query_catid);
			$searchtotal1 = $db->loadObjectList();
			//print_r($searchtotal1);
			$catid = $searchtotal1[0]->id;
		}
		return $catid;
	}
	function getcategoryList()
	{
		$db = $this->getDBO();
                $catid = $this -> getcategoryid();
                if(!version_compare(JVERSION, '3.0.0', 'ge')) {
		$catid = $db->getEscaped($catid);
                }
		$categoryquery = "select * from #__hdflv_category where id=$catid or parent_id=$catid order by ordering"; //Query is to select the popular videos row
		$db->setQuery($categoryquery);
		$rows = $db->LoadObjectList();
		return $rows;
	}
	## function to get html video access level 
    function getHTMLVideoAccessLevel() {
        $db             = JFactory::getDBO();
        $user           = JFactory::getUser();
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $uid        = $user->get('id');
            if ($uid) {
                $db     = JFactory::getDBO();
                $query  = $db->getQuery(true);
                $query->select('g.id AS group_id')
                        ->from('#__usergroups AS g')
                        ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                        ->where('map.user_id = ' . (int) $uid);
                $db->setQuery($query);
                $message = $db->loadObjectList();
                foreach ($message as $mess) {
                    $accessid[] = $mess->group_id;
                }
            } else {
                $accessid[] = 1;
            }
        } else {
            $accessid = $user->get('aid');
        }
	
        ## CODE FOR SEO OPTION OR NOT - START 
        $flatCatid = is_numeric(JRequest::getString('category'));
		if (JRequest::getString('category') && $flatCatid != 1) {
			$catvalue = str_replace(':', '-', JRequest::getString('category'));
			$query = 'SELECT id FROM #__hdflv_category WHERE seo_category="' . $catvalue . '"';
			$db->setQuery($query);
			$catid = $db->loadResult();
		} else if ($flatCatid == 1) {
			$catid = JRequest::getString('category');
		} else if (JRequest::getInt('catid')) {
			$catid = JRequest::getInt('catid');
		} else {
			$query_catid = "SELECT id FROM #__hdflv_category WHERE published=1 ORDER BY category asc"; // this query is for category view pagination
			$db->setQuery($query_catid);
			$searchtotal1 = $db->loadObjectList();
			//     print_r($searchtotal1);
			$catid = $searchtotal1[0]->id;
		} //Category id is stored in this catid variable
		if(!version_compare(JVERSION, '3.0.0', 'ge'))
		$catid = $db->getEscaped($catid);
		//query to calculate total number of videos in paricular category
		$totalquery = "SELECT a.*,b.id as cid,b.category,b.seo_category,b.parent_id,c.*
        			   FROM #__hdflv_upload a
                                   LEFT JOIN #__users d on a.memberid=d.id 
        			   LEFT JOIN #__hdflv_video_category c on a.id=c.vid 
        			   LEFT JOIN #__hdflv_category b on c.catid=b.id 
        			   WHERE (c.catid=$catid OR b.parent_id = $catid OR a.playlistid=$catid) 
        			   AND a.published=1 AND b.published=1 AND d.block=0 order by b.id asc";
		$db->setQuery($totalquery);
		$rowsVal = $db->loadAssoc();
        if (count($rowsVal) > 0) {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $query          = $db->getQuery(true);
                if ($rowsVal['useraccess'] == 0) {
                    $rowsVal['useraccess'] = 1;
                }
                $query->select('rules as rule')
                        ->from('#__viewlevels AS view')
                        ->where('id = ' . (int) $rowsVal['useraccess']);
                $db->setQuery($query);
                $message        = $db->loadResult();
                $accessLevel    = json_decode($message);
            }
            $member             = "true";
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $member = "false";
                foreach ($accessLevel as $useracess) {
                    if (in_array("$useracess", $accessid) || $useracess == 1) {
                        $member = "true";
                        break;
                    }
                }
            } else {
                if ($rowsVal['useraccess'] != 0) {
                    if ($accessid != $rowsVal['useraccess'] && $accessid != 2) {
                        $member = "false";
                    }
                }
            }
            return $member;
        }
    }
	
}
?>