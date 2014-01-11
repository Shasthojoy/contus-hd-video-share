<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Random Videos Module Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
##  No direct access to this file
defined('_JEXEC') or die('Restricted access');
## Contushdvideoshare random Videos Module Helper
class modrandomVideos {

	## function to get random videos
    public static function getrandomVideos() {
        $db = JFactory::getDBO();
        $limitrow = modrandomVideos::getrandomVideossettings();
        $thumbview       = unserialize($limitrow[0]->sidethumbview);
        if(isset($thumbview['siderandomvideorow']) && isset($thumbview['siderandomvideocol'])){
        $length = $thumbview['siderandomvideorow'] * $thumbview['siderandomvideocol'];
        } else {
            $length = 4;
        }
        ##  Query is to display random videos randomly
        $randomquery = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,a.amazons3,
						  a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid
        				  FROM #__hdflv_upload a left join #__users d on a.memberid=d.id 
        				  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        				  LEFT JOIN #__hdflv_category b on e.catid=b.id 
        				  WHERE a.published='1' and b.published=1 and a.type='0'  
        				  GROUP BY e.vid order by rand() 
        				  LIMIT 0,$length ";
        $db->setQuery($randomquery);
        $randomvideos = $db->loadobjectList();
        return $randomvideos;
    }

    ## function to get random videos module settings 
    public static function getrandomVideossettings() {

        $db = JFactory::getDBO();
        ## Query is to select the random videos module settings
        $featurequery = "SELECT dispenable,sidethumbview FROM #__hdflv_site_settings"; 
        $db->setQuery($featurequery);
        $rows = $db->loadObjectList();
        return $rows;
    }
}
?>