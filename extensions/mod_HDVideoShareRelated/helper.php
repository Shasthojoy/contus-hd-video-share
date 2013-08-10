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
 * @abstract      : Contushdvideoshare Related Videos Module Helper
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Contushdvideoshare Related Videos Module Helper
 */
class modrelatedvideos {

	/* function to get related videos */
	public static function getrelatedvideos() {
		$db = JFactory::getDBO();
		$limitrow = modrelatedvideos::getrelatedvideossettings();
		$length = $limitrow[0]->siderelatedvideorow * $limitrow[0]->siderelatedvideocol;
		$seoOption = $limitrow[0]->seo_option;
		$category = $video = '';
		if ($seoOption == 1)
		{
			$videoid = JRequest::getVar('video', '', 'get', 'string');
			$video = $videoid;
		}
		else
		{
                    if($videoid = JRequest::getVar('id')) {
			$videoid = JRequest::getVar('id', '', 'get', 'int');
                    } else {
                        $videoid = JRequest::getVar('video', '', 'get', 'int');
                    }
			$catidquery = "select * from #__hdflv_upload where id ='$videoid'";
			$db->setQuery($catidquery);
			$resulttotal = $db->loadObjectList();
			if(count($resulttotal)>0){
				if ($videoid) {
					$video = $resulttotal[0]->title;
				}
			}
		}

		if (isset($videoid) && (isset($video)) && !empty($video)) {
			// $category = JRequest::getVar('category', '', 'get', 'string');
			/* Getting the category value Following code is to change the catgeory name which is passing in the url like -,and to '','&' */

			// Query is to get the category id based on category value passing in the url
			$kt=preg_split("/[\s,]+/", $video);//Breaking the string to array of words
			// Now let us generate the sql
			while(list($key,$video)=each($kt)){
				if($video<>" " and strlen($video) > 0)
				{
					//Quer is to display the related videos in the right hand side
					$query = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						 	  a.times_viewed,a.seotitle,b.id as catid,b.category,b.seo_category,e.catid,e.vid  
							  FROM #__hdflv_upload a 
							  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
							  LEFT JOIN #__hdflv_category b on e.catid=b.id 
							  WHERE a.published=1 and b.published=1 and  (a.title like '%$video%' )  group by a.id order by rand() LIMIT 0,$length"; 
					$db->setQuery($query);
					$relatedvideos = $db->loadObjectList();
				}
			}
		} else {
			$_SESSION['related'] = "featured";
			//Query is to display the related videos in the right hand side
			$query = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
					  a.times_viewed,a.seotitle,b.id as catid,b.category,b.seo_category,e.catid,e.vid  
					  FROM #__hdflv_upload a 
					  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
					  LEFT JOIN #__hdflv_category b on e.catid=b.id 
					  WHERE a.published=1 and b.published=1 and a.featured=1 
					  GROUP BY a.id 
					  ORDER BY rand() LIMIT 0,$length"; 

			$db->setQuery($query);
			$relatedvideos = $db->loadObjectList();
		}
		return $relatedvideos;
	}

	/* function to get related videos settings */
	public static function getrelatedvideossettings() {
		$db = JFactory::getDBO();
		//Query is to select the realted videos settings
		$featurequery = "SELECT siderelatedvideorow,siderelatedvideocol,seo_option,viewedconrtol,ratingscontrol
        				 FROM #__hdflv_site_settings"; 
		$db->setQuery($featurequery);
		$rows = $db->LoadObjectList();
		return $rows;
	}

}

?>
