<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Related Videos Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Related Vidos Model
 */
class Modelcontushdvideosharerelatedvideos extends JModel
{
/* function is to display the related videos */
function getrelatedvideos()
{
        $db = $this->getDBO();
        $session =& JFactory::getSession();       
        $categoryid=JRequest::getVar('catid','','get','int');
        $limitrow=$this->getrelatedvideosrowcol();
        $seoOption = $limitrow[0]->seo_option;
		$category = $video = '';
		if ($seoOption == 1)
		{
			$videoid = JRequest::getVar('video', '', 'get', 'string');
			$video = $videoid;
		}
		else
		{
                    if(JRequest::getVar('id')) {
			$videoid = JRequest::getVar('id');
                    } else {
                        $videoid = JRequest::getVar('video');
                    }
			$catidquery = "select title from #__hdflv_upload where id ='$videoid'";
			$db->setQuery($catidquery);
			$resulttotal = $db->loadObjectList();
			if(count($resulttotal)>0){
				if ($videoid) {
					$video = $resulttotal[0]->title;
				}
			}
		}
        //Query for getting the pagination values for related video page
        $totalquery="SELECT count(a.id) FROM #__hdflv_upload a
        			 LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        			 LEFT JOIN #__hdflv_category b on e.catid=b.id 
                     WHERE a.published=1 and b.published=1 and  (a.title like '%$video%' ) ";
        $db->setQuery( $totalquery );
        $total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $length=$limitrow[0]->relatedrow * $limitrow[0]->relatedcol;
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
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
							  WHERE a.published=1 and b.published=1 and  (a.title like '%$video%' )  group by a.id order by rand() LIMIT $start,$length";

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
					  ORDER BY rand() LIMIT $start,$length";


		}
        $db->setQuery( $query );
        $rows = $db->loadObjectList();
        if(count($rows)>0){
        $rows['pageno'] = $pageno;
		$rows['pages'] = $pages;
		$rows['start'] = $start;
		$rows['length'] = $length;	
        }
        return $rows;
}
function getrelatedvideosrowcol()
{
        $db = $this->getDBO();
		$relatedvideosquery="SELECT relatedcol,relatedrow,seo_option,viewedconrtol,ratingscontrol 
							 FROM #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($relatedvideosquery);
        $rows=$db->LoadObjectList();
        return $rows;
}
}
?>