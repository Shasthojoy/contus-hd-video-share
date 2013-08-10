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
 * @abstract      : Contushdvideoshare Component Midrollxml Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die();
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Midrollxml Model
 */
class Modelcontushdvideosharemidrollxml extends JModel {

	/* function to get midroll ads */
	function getads()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$playlistid=0;
		$mid=0;
		$itemid=0;
		$rs_modulesettings="";
		$moduleid=0;
		$id=0;
		$playlistautoplay="false";
		$postrollads="false";
		$prerollads="false";
		$videoid=0;
		$home_bol="false";
		$playlistrandom="false";
		$query="SELECT * FROM `#__hdflv_ads` WHERE published=1 and typeofadd='mid'";
		$db->setQuery( $query );
		$rs_modulesettings = $db->loadObjectList();
		$qry_settings = "SELECT * FROM #__hdflv_player_settings LIMIT 1 ";
		$db->setQuery($qry_settings);
		$rs_random = $db->loadObjectList();
		$random = $rs_random[0]->midrandom;
		$adrotate = $rs_random[0]->midadrotate;
		$interval = $rs_random[0]->midinterval;
		$begin = $rs_random[0]->midbegin;
		($random == 1) ? $random = "true" : $random = "false";
		($adrotate == 1) ? $adrotate = "true" : $adrotate = "false";
		if($rs_modulesettings)
		{
			$this->showadsxml($rs_modulesettings, $random, $begin, $interval, $adrotate);
		}
	}
	/* function to show midroll ads */
	function showadsxml($midroll_video, $random, $begin, $interval, $adrotate)
	{
		ob_clean();
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<midrollad begin="' . $begin . '" adinterval="' . $interval . '" random="' . $random . '" adrotate="' . $adrotate . '">';
		$current_path = "components/com_contushdvideoshare/videos/";
		if (count($midroll_video) > 0) {
			foreach ($midroll_video as $rows)
			{
				if($rows->clickurl=='')
				$clickpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=click&id='.$rows->id;
				else
				$clickpath = $rows->clickurl;
				if($rows->impressionurl=='')
				$impressionpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=impression&id='.$rows->id;
				else
				$impressionpath = $rows->impressionurl;
				//echo '<midroll videoid="' . $rows->vid . '" targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '">';
				echo '<midroll targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '" >';
				echo '<![CDATA[';
				echo '<span class="heading">' . $rows->adsname;
				echo '</span><br><span class="midroll">' . $rows->adsdesc;
				echo '</span><br><span class="webaddress">'. $rows->targeturl;
				echo '</span>]]>';
				echo '</midroll>';
			}
		}
		echo '</midrollad>';
		exit();
	}

}