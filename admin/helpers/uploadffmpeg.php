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
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Adminvideos Uploadffmpeg Helper
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
/**
 * uploading videos
 * type : FFMPEG
 * Contushdvideoshare Component Adminvideos Uploadffmpeg Helper
 */
class uploadFfmpegHelper
{
	/**
	 * function to upload ffmpeg video
	 */ 
	function uploadFfmpeg($arrFormData,$idval)
	{
		$db = & JFactory::getDBO();
				
		/**
		 * query for get HEIGTH,WIDTH player size and FFMPEG path from player settings		 
		 */	
		$query = "select height,width,ffmpegpath from  #__hdflv_player_settings limit 1";
		$db->setQuery($query);
		$arrPlayerSettings = $db->loadObject();
		// check valid record
		if (count($arrPlayerSettings))
		{
			/**
			 * In Ffmpeg allowed width & height should be even nos.
			 * Hence 1 is added if it is odd no.
			 * 
			 */ 
			if (( $arrPlayerSettings->height % 2) == 0)
			$previewheight = $arrPlayerSettings->height;
			else
			$previewheight = $arrPlayerSettings->height + 1;
			if (( $arrPlayerSettings->width % 2) == 0)
			$previewwidth = $arrPlayerSettings->width;
			else
			$previewwidth= $arrPlayerSettings->width + 1;
			// To get ffmpeg path
			if ($arrPlayerSettings->ffmpegpath) {
				$strFfmpegPath = $arrPlayerSettings->ffmpegpath;
			}
		}
		
		
		$ffmpeg_video = $arrFormData['ffmpegform-value'];
		$video_name = explode('uploads/', $ffmpeg_video);		
		$strTmpVidName = $video_name[1];
		
		/**
		 * VPATH to get target path
		 * target path @ /components/com_contushdvideoshare/videos
		 * FVPATH to get temporary path
		 * temp path @ /components/com_contushdvideoshare/images/uploads		 
		 */
		
		$strTmpPath = FVPATH . DS."images".DS."uploads".DS. $strTmpVidName;
		$strTargetPath = VPATH . DS;
		$exts = uploadFfmpegHelper::getFileExtension($strTmpVidName);		
		$strVidTargetPath = $strTargetPath . $idval . "_video" . "." . $exts;
		
		/**
		 * function to move video from temp path to target path		 
		 */			
		if (JFile::exists($strTmpPath))	
		rename($strTmpPath, $strVidTargetPath);		
		
		$strTmpPath = $strTargetPath . $idval . "_video" . "." . $exts;

		/**
		 * function to get FFMPEG video information		 
		 */	
		$arrData = uploadFfmpegHelper::getFfmpegVidInfo($strTmpPath, $strFfmpegPath);
		// Get file format
		$hdfile = $arrData['vdo_format'];		
		
		// To check for HD or Flv or other movies
		if ($hdfile == "h264") {
			$exts = uploadFfmpegHelper::getFileExtension($strTmpVidName);
			$video_name = $idval . '_hd' . ".flv";
			$flvpath = $strTargetPath . $idval . '_hd' . ".flv";
			exec($strFfmpegPath . ' ' . '-i' . ' ' . $strTmpPath . ' ' . '-sameq' . ' ' . $flvpath . ' ' . '2>&1');
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-r 1 -s 120x68 -f image2" . ' ' . $strTargetPath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-r 1 -s" . ' ' . $previewwidth . "x" . $previewheight . ' ' . " -f image2" . ' ' . $strTargetPath . $idval . '_preview' . ".jpeg");
			$hd_name = $idval . '_video.' . $exts;
		} else {
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-sameq" . ' ' . $strTargetPath . $idval . '_video' . ".flv  2>&1");
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . " -i " . $strTmpPath . ' ' . "-r 1 -s 120x68 -f image2" . ' ' . $strTargetPath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . " -i " . $strTmpPath . ' ' . "-r 1 -s " . ' ' . $previewwidth . "x" . $previewheight . ' ' . "-f image2" . ' ' . $strTargetPath . $idval . '_preview' . ".jpeg");
			$video_name = $idval . '_video' . ".flv";
			$hd_name = "";
		}
		$thumb_name = $idval . '_thumb' . ".jpeg";
		$preview_name = $idval . '_preview' . ".jpeg";
		$fileoption = $arrFormData['fileoption'];
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		
		// To update the video file name in database table
		$query = "UPDATE #__hdflv_upload 
				  SET streameroption= '$streamer_option',filepath='$fileoption',videourl='$video_name',thumburl='$thumb_name',previewurl='$preview_name',hdurl='$hd_name' 
				  WHERE id = $idval";
		$db->setQuery($query);
		$db->query();
	}
	
	/**
	* function to get FFMPEG video information		 
	*/	
	function getFfmpegVidInfo($strVidPath, $strFfmpegPath) {		
		$commandline = $strFfmpegPath . " -i " . $strVidPath;
		$exec_return = uploadFfmpegHelper::ffmpeg_exec($commandline);
		$exec_return_content = explode("\n", $exec_return);
		if ($infos_line_id = uploadFfmpegHelper::ffmpeg_search('Video:', $exec_return_content)) {
			$infos_line = trim($exec_return_content[$infos_line_id]);
			$infos_cleaning = explode(': ', $infos_line);
			$infos_datas = explode(',', $infos_cleaning[2]);
			$return_array['vdo_format'] = trim($infos_datas[0]);
		}
		return($return_array);
	}

	/**
	* function to execute FFMPEG video using POPEN
	* The popen() function opens a process by creating a pipe, forking, and invoking the shell		 
	*/
	function ffmpeg_exec($commandline) {
		$read = '';
		$handle = popen($commandline . ' 2>&1', 'r');
		while (!feof($handle)) {
			$read .= fread($handle, 2096);
		}
		pclose($handle);
		return($read);
	}

	/**
	* function to reset array value
	* and search		 
	*/
	function ffmpeg_search($needle, $array_lines) {
		$return_val = false;
		reset($array_lines);
		foreach ($array_lines as $num_line => $line_content) {
			if (strpos($line_content, $needle) !== false) {
				return($num_line);
			}
		}
		return($return_val);
	}
	
	/**
	 * function to get file extensions	 
	 */
	function getFileExtension($strFileName){
		$strFileName = strtolower($strFileName);
		return JFile::getExt($strFileName);		
	}
}
?>