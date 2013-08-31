<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	  	  : 3.4
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos Uploadurl Helper
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
/**
 * uploading videos
 * type : URL
 * Contushdvideoshare Component Showvideos Uploadurl Helper
 */
class uploadUrlHelper
{
	// function to upload url video
function uploadUrl($arrFormData,$idval)
	{
		$db = & JFactory::getDBO();
		$videourl = "";
		$baseUrl = str_replace("administrator/","",JURI::base());
		$thumburl = $baseUrl.'components/com_contushdvideoshare/videos/default_thumb.jpg';		
		$previewurl = $baseUrl.'components/com_contushdvideoshare/videos/default_preview.jpg';
		$hdurl = "";
		$streamer_option = "";
		
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		$fileoption = $arrFormData['fileoption'];

		// assign video url
		if ($arrFormData['videourl-value'] != "") {
		$videourl = $arrFormData['videourl-value'];
		}
		
		// assign hd url
		if ($arrFormData['hdurl-value'] != "") {
		$hdurl = $arrFormData['hdurl-value'];
		}
		
		// assign thumb image url
		if ($arrFormData['thumburl-value'] != "") {
		$thumburl = $arrFormData['thumburl-value'];
		}
			
		// assign preview image url
		if ($arrFormData['previewurl-value'] != "") {
		$previewurl = $arrFormData['previewurl-value'];
		}		

		// assign streamer path
		$streamer_path = ($arrFormData['streamerpath-value'] != '')?$arrFormData['streamerpath-value']:'';	
		$isLive = $arrFormData['islive-value'];
		// update streameroption,streamerpath,etc
		$query = "UPDATE #__hdflv_upload 
				  SET streameroption= '$streamer_option',streamerpath='$streamer_path', filepath='$fileoption',
				  videourl='$videourl',thumburl='$thumburl',previewurl='$previewurl',hdurl='$hdurl',islive='$isLive'
				  where id=$idval";
                $db->setQuery($query);
		$db->query();
	}
}
?>