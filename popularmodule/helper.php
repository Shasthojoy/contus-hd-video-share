<?php
/*
* "Popular Videos Module for ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined ('_JEXEC') or die('Restricted access');
class modpopularVideos
{
    function getpopularvideos()
    {
    $db = & JFactory::getDBO();
       $limitrow=modpopularVideos::getpopularvideossettings();
    $length=$limitrow[0]->sidepopularvideorow * $limitrow[0]->sidepopularvideocol;
    $popularquery = "select a.*,b.category,b.seo_category,d.username,e.* from #__hdflv_upload a left join #__users d on a.memberid=d.id left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published='1' and a.type='0' group by e.vid order by a.times_viewed desc limit 0,$length"; //Query is to display popular videos in home page
    $db->setQuery( $popularquery );
    $popularvideos = $db->loadobjectList(); //$popularvideos contains the results
    return $popularvideos;
    }


       function getpopularvideossettings()
{

        $db = & JFactory::getDBO();
		$featurequery="select * from #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows=$db->LoadObjectList();
        return $rows;
}

    }

?>
