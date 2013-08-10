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
			$videoid = str_replace(":", "-", $videoid);
			if ($videoid != "") {
				$videoid = $db->getEscaped($videoid);
                        }
                        $catidquery = "select playlistid from #__hdflv_upload where seotitle ='$videoid'";
			$db->setQuery($catidquery);
			$video = $db->loadResult();
		}
		else
		{
                    if(JRequest::getVar('id')) {
			$videoid = JRequest::getVar('id', '', 'get', 'int');
                    } else {
                        $videoid = JRequest::getVar('video', '', 'get', 'int');
                    }
			$catidquery = "select playlistid from #__hdflv_upload where id ='$videoid'";
			$db->setQuery($catidquery);
			$video = $db->loadResult();
		}

		if (isset($videoid) && (isset($video)) && !empty($video)) {

					$query = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						 	  a.times_viewed,a.seotitle,b.id as catid,b.category,b.seo_category,e.catid,e.vid  
							  FROM #__hdflv_upload a 
							  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
							  LEFT JOIN #__hdflv_category b on e.catid=b.id 
							  WHERE a.published=1 and b.published=1 and  (a.playlistid=$video )  group by a.id order by rand() LIMIT 0,$length";
					$db->setQuery($query);
					$relatedvideos = $db->loadObjectList();
                                        
return $relatedvideos;
		}
		
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
