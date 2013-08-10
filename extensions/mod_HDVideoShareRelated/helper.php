<?php

/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        helper.php
 * @location    /components/modules/mod_HDVideoShareRelated/helper.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Related helper
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');

class modrelatedvideos {

    function getrelatedvideos() {

        $db = & JFactory::getDBO();
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
                       $videoid = JRequest::getVar('id', '', 'get', 'int');
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
                // $query ="select a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username from #__hdflv_category a left join #__hdflv_video_category b on b.catid=a.id left join #__hdflv_upload c on c.id=b.vid left join #__users d on c.memberid=d.id where c.type=0 and c.published=1 and (c.title like '%$video%' )  group by c.id"; // Query for displayin the pagination results
                $query = "select a.*,b.id as catid,b.category,e.* from #__hdflv_upload a left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and b.published=1 and  (a.title like '%$video%' )  group by a.id order by rand() LIMIT 0,$length"; //Quer is to display the related videos in the right hand side
                $db->setQuery($query);
                $relatedvideos = $db->loadObjectList();
            }
            }
        } else {
            $_SESSION['related'] = "featured";
            $query = "select a.*,b.id as catid,b.category,e.* from #__hdflv_upload a left join #__hdflv_video_category e on e.vid=a.id left join #__hdflv_category b on e.catid=b.id where a.published=1 and b.published=1 and a.featured=1  group by a.id order by rand() LIMIT 0,$length"; //Quer is to display the related videos in the right hand side

            $db->setQuery($query);
        $relatedvideos = $db->loadObjectList();
        }
        //echo $query;die;
        //    echo '<pre>';print_r($relatedvideos);die;
        //$relatedvideos=isset($relatedvideos)?$relatedvideos:'';
        return $relatedvideos;
    }


    function getrelatedvideossettings() {
        $db = & JFactory::getDBO();
        $featurequery = "select * from #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

}

?>
