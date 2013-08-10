<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	  	  : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Showvideos Uploadyoutube Helper
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
/**
 * uploading videos
 * type : YOUTUBE
 * Contushdvideoshare Component Showvideos Uploadyoutube Helper
 */
class uploadYouTubeHelper
{
	// function to upload youtube video
	function uploadYouTube($arrFormData,$idval)
	{
		$videourl = $arrFormData['videourl-value'];
		$str1 = explode('administrator', JURI::base());
		$videoshareurl = $str1[0] . "index.php?option=com_contushdvideoshare&view=videourl";
		$timeout = "";
		$header = "";
		$hdurl = "";
		// check video url is youtube
		if(strpos($videourl,'youtube') > 0)
		{
			$imgstr = explode("v=", $videourl);
			$imgval = explode("&", $imgstr[1]);
			$previewurl = "http://img.youtube.com/vi/" . $imgval[0] . "/0.jpg";
			$img = "http://img.youtube.com/vi/" . $imgval[0] . "/1.jpg";
		}
		else if(strpos($videourl,'youtu.be') > 0)
		{
			$imgstr = explode("/", $videourl);
			$previewurl = "http://img.youtube.com/vi/" . $imgstr[3] . "/0.jpg";
			$img = "http://img.youtube.com/vi/" . $imgstr[3] . "/1.jpg";
                        $videourl="http://www.youtube.com/watch?v=".$imgstr[3];
		}

		// check video url is youtube
		else if(strpos($videourl,'vimeo') > 0)
		{
		 $split=explode("/",$videourl);
                 if( ini_get('allow_url_fopen') ) {
			$doc = new DOMDocument();
			$doc->load('http://vimeo.com/api/v2/video/'.$split[3].'.xml');
			$videotags = $doc->getElementsByTagName('video');
			foreach ($videotags as $videotag)
			{
				$imgnode = $videotag->getElementsByTagName('thumbnail_medium');
				$img = $imgnode->item(0)->nodeValue;
			}
                }else{
                        $url="http://vimeo.com/api/v2/video/" . $split[3] . ".xml";
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($curl);
                        curl_close($curl);
                        $xml = simplexml_load_string($result);
                        $img = $xml->video->thumbnail_medium;
                }
		}
			
		// check video url is site url
		else
		{
			// is cURL exit or not
			if (!function_exists('curl_init')) {
				echo "<script> alert('Sorry cURL is not installed!');window.history.go(-1); </script>\n";
				exit();
			}

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $videoshareurl . '&url=' . $videourl . '&imageurl=' . $videourl);
			curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
			curl_setopt($curl, CURLOPT_HEADER, (int) $header);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$videoshareurl_location = curl_exec($curl);
			curl_close($curl);
			$location1 = "";
			$location2 = "";
			$location3 = "";
			$location = explode('&', $videoshareurl_location);
			$location1 = explode('location1=', $location[1]);
			$location2 = explode('location2=', $location[2]);
			$location3 = explode('location3=', $location[3]);
			$img = explode('imageurl=', $location[4]);
			$img = $img[1];
			$hdurl = "";
			if ($location2[1] != "")
			$hdurl = $videourl;
		}
		
		$streamer_option = "";		
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		$fileoption = $arrFormData['fileoption'];
		
		// update fields
		$db = & JFactory::getDBO();
		$query = "UPDATE #__hdflv_upload SET streameroption= '$streamer_option',filepath='$fileoption' ,videourl='$videourl',thumburl='$img',previewurl='$previewurl',hdurl='$hdurl' where id=$idval";
		$db->setQuery($query);
		$db->query();
	}
}
?>