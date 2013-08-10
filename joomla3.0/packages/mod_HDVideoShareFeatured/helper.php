<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Featured Module
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Contushdvideoshare Featured Videos Module Helper
 */
class modfeaturedVideos {

	/* function to get featured videos */
    public static function getfeaturedVideos() {
        $db = JFactory::getDBO();
        $limitrow = modfeaturedVideos::getfeaturedVideossettings();
        $length = $limitrow[0]->sidefeaturedvideorow * $limitrow[0]->sidefeaturedvideocol;
        // Query is to display featured videos randomly
        $featuredquery = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						  a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid
        				  FROM #__hdflv_upload a left join #__users d on a.memberid=d.id 
        				  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        				  LEFT JOIN #__hdflv_category b on e.catid=b.id 
        				  WHERE a.published='1' and b.published=1 and a.featured='1' and a.type='0'  
        				  GROUP BY e.vid order by rand() 
        				  LIMIT 0,$length ";
        $db->setQuery($featuredquery);
        $featuredvideos = $db->loadobjectList();
        return $featuredvideos;
    }

    /* function to get featured videos module settings */
    public static function getfeaturedVideossettings() {

        $db = JFactory::getDBO();
        //Query is to select the featured videos module settings
        $featurequery = "SELECT sidefeaturedvideorow,sidefeaturedvideocol,seo_option,viewedconrtol,ratingscontrol
        				 FROM #__hdflv_site_settings"; 
        $db->setQuery($featurequery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

}

?>
