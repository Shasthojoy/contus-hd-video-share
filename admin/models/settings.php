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
 * @abstract      : Contushdvideoshare Component PlayerSettings Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die();
// import joomla model library
jimport('joomla.application.component.model');
//Import filesystem libraries.
jimport('joomla.filesystem.file');


/**
 * Contushdvideoshare Component Administrator Player Settings Model
 */

class contushdvideoshareModelsettings extends JModel
{
	/**
	 * function to get player settings
	 */

	function showplayersettings()
	{
		$db = JFactory::getDBO();
		//query to fetch player settings
		$query = "SELECT `id`, `published`, `buffer`, `normalscale`, `fullscreenscale`, `autoplay`, `volume`, `logoalign`,
		         `logoalpha`, `skin_autohide`, `stagecolor`, `skin`, `embedpath`, `fullscreen`, `zoom`, `width`, `height`,
		         `uploadmaxsize`, `ffmpegpath`, `ffmpeg`, `related_videos`, `timer`, `logopath`, `logourl`, `nrelated`,
		         `shareurl`, `playlist_autoplay`, `hddefault`, `ads`, `prerollads`, `postrollads`, `random`, `midrollads`,
		         `midbegin`, `midinterval`, `midrandom`, `midadrotate`, `playlist_open`, `licensekey`, `vast`, `vast_pid`,
		         `Youtubeapi`, `scaletologo`, `googleanalyticsID`, `googleana_visible` FROM #__hdflv_player_settings";
		$db->setQuery( $query);
		$arrPlayerSettings = $db->loadObjectList();
		return $arrPlayerSettings;
	}

	/**
	 * function to save player settings
	 */

	function saveplayersettings()
	{
		$option = JRequest::getCmd('option');
		$arrFormData = JRequest::get('post');
		$mainframe = JFactory::getApplication();
		//Get the object for settings
		$objPlayerSettingsTable =& JTable::getInstance('settings', 'Table');		
		$id = 1;

		/**
		 * load a row from the database
		 */

		$objPlayerSettingsTable->load($id);

		// for logo image
		$logo = JRequest::getVar('logopath', null, 'files', 'array');
		$strRes = $this->logoImageValidation($logo['name']);
		if($logo['name'] && $strRes)
		{
			$strTargetPath = VPATH.DS;
			//Clean up filename to get rid of strange characters like spaces etc
			$strLogoName = JFile::makeSafe($logo['name']);
			$strTargetLogoPath = $strTargetPath.$logo['name'];
			// To store images to a directory called components/com_contushdvideoshare/videos
			JFile::upload($logo['tmp_name'],$strTargetLogoPath);
			$arrFormData['logopath'] = $strLogoName;
		}

		/**
		 * bind data to the databse table object.
		 */
		
		if($arrFormData['googleana_visible'] == '0'){
			$arrFormData['googleanalyticsID'] = '';
		}
		if(JRequest::getVar('midrollads') == '0') {
			$arrFormData['midbegin'] = '';
		}		
		
		if (!$objPlayerSettingsTable->bind($arrFormData))
		{
			JError::raiseWarning(500, JText::_($objPlayerSettingsTable->getError()));			
		}

		/**
		 * store the data into the settings table.
		 */
			
		if (!$objPlayerSettingsTable->store()) {
			JError::raiseWarning(500, JText::_($objPlayerSettingsTable->getError()));
		}

		// set to page redirect
		$link = 'index.php?option=' . $option.'&layout=settings';
		$mainframe->redirect($link, 'Saved Successfully');
	}

	/**
	 * function to check image type
	 */

	function logoImageValidation($logoname)
	{
		// Get file extension
		$ext = $this->getFileExt($logoname);
		if($ext)
		{
			// To check file type
			if(($ext!="png") && ($ext!="gif") && ($ext!="jpeg") && ($ext!="jpg"))
			{
				JError::raiseWarning(500, JText::_('File Extensions : Allowed Extensions for image file [ jpg , jpeg , png ] only'));
				return false;
			}else{
				return true;
			}
				
		}
	}

	/**
	 * function to get file extension
	 */

	function getFileExt($filename)
	{
		$filename = strtolower($filename) ;
		return JFile::getExt($filename);
	}
}
?>
