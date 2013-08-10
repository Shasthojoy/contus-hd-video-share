<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Hdvideoshare Search Model
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
 * Contushdvideoshare Component Hdvideoshare Search Model
 */
class Modelcontushdvideosharehdvideosharesearch extends JModel
{
	/* function is to display the search results */
	function getsearch()
	{
		$db = $this->getDBO();
		$session = JFactory::getSession();
                if(JRequest::getVar('searchtxtbox','','post','string'))
		{
			$search=JRequest::getVar('searchtxtbox','','post','string'); // Getting the search  text  box value
			$session->set('search', $search);
		}
		else
		{
			$search=$session->get('search');
		}
		$searchtotal="SELECT a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username
        			  FROM #__hdflv_category a 
        			  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
        			  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
        			  LEFT JOIN #__users d on c.memberid=d.id 
        			  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0
                                  AND (c.title like '%$search%' OR c.description like '%$search%' OR c.tags like '%$search%')
        			  GROUP BY c.id";		
		$kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
		// Now let us generate the sql
		while(list($key,$search)=each($kt)){
			if($search<>" " and strlen($search) > 0)
			{
				$searchtotal="SELECT a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username 
							  FROM #__hdflv_category a 
							  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
							  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
							  LEFT JOIN #__users d on c.memberid=d.id 
							  WHERE c.type=0 AND c.published=1 AND a.published=1 and d.block=0
							  AND (c.title like '%$search%' OR c.description like '%$search%' OR c.tags like '%$search%')  
							  GROUP BY c.id"; 
			}
		}
		$db->setQuery($searchtotal);
		$resulttotal = $db->loadObjectList();
		$subtotal=count($resulttotal);
		$total=$subtotal;
		$pageno = 1;
		if(JRequest::getVar('page','','post','int'))
		{
			$pageno = JRequest::getVar('page','','post','int');
		}
		$limitrow=$this->getsearchrowcol();
		$length=$limitrow[0]->searchrow * $limitrow[0]->searchcol;
		$pages = ceil($total/$length);
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		if(JRequest::getVar('searchtxtbox','','post','string'))
		{
			$search=JRequest::getVar('searchtxtbox','','post','string');
			$session->set('search', $search);
		}
		else
		{
			$search=$session->get('search');
		}
		$kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
		// Now let us generate the sql
		$searchquery="SELECT a.id as vid,a.category,a.seo_category,b.catid,b.vid,
					  c.id,c.filepath,c.thumburl,c.title,c.description,c.times_viewed,c.ratecount,c.rate,
				      c.times_viewed,c.seotitle,d.id,d.username 
					  FROM #__hdflv_category a 
					  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
					  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
					  LEFT JOIN #__users d on c.memberid=d.id 
					  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0 
					  GROUP BY c.id 
					  LIMIT $start,$length";//Query for displaying the search value results

		while(list($key,$search)=each($kt)){
			if($search<>" " and strlen($search) > 0){
				$searchquery="SELECT a.id as vid,a.category,a.seo_category,b.catid,b.vid,
							  c.id,c.filepath,c.thumburl,c.title,c.description,c.times_viewed,c.ratecount,c.rate,
				              c.times_viewed,c.seotitle
							  FROM #__hdflv_category a 
							  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
							  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
							  LEFT JOIN #__users d on c.memberid=d.id 
							  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0 
							  and (c.title like '%$search%' OR c.description like '%$search%' OR 
							  c.tags like '%$search%')
							  UNION DISTINCT SELECT f.id,f.user_id,f.channel_name,f.description,f.about_me,f.tags,f.website,
							  f.channel_views,f.total_uploads,f.recent_activity,f.created_date,f.updated_date,
							  g.logo,g.type,g.playlist	
							  FROM #__hdflv_channel f	
							  LEFT JOIN #__hdflv_channelsettings g on f.id=g.channel_id							  
							  WHERE f.channel_name like '%$search%' 							  
							  LIMIT $start,$length";//Query for displaying the search value results
			}}
			$db->setQuery($searchquery);
			$rows = $db->loadObjectList();//echo '<pre>';print_r($rows);exit;
			if(count($rows)>0)
			{
				$rows['pageno'] = $pageno;
				$rows['pages'] = $pages;
				$rows['start'] = $start;
				$rows['length'] = $length;					
			}                        
			return $rows;
	}
	function getsearchrowcol()
	{
		$db = $this->getDBO();
		//Query is to select the search video page settings
		$searchquery = "SELECT searchcol,searchrow,searchwidth,seo_option,ratingscontrol,viewedconrtol
						FROM #__hdflv_site_settings";
		$db->setQuery($searchquery);
		$rows=$db->LoadObjectList();
		return $rows;
	}
}
?>