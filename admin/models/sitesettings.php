<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Sitesettings Model 
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');

/**
 * Contushdvideoshare Component Administrator Sitesettings Model
 *
 */ 

class contushdvideoshareModelsitesettings extends ContushdvideoshareModel
{	
	/**
	 * function to get sitesettings 
	 */ 
	function getsitesetting()
	{
		$jcomment = $jomcomment = 0;
		//query to fetch site settings
		$query = 'SELECT `id`, `published`, `seo_option`, `facebooklike`, `facebookapi`, `featurrow`, `featurcol`,`featurwidth`,
				 `recentrow`, `recentcol`,`recentwidth`, `categoryrow`, `categorycol`,`categorywidth`, `popularrow`, `popularcol`,`popularwidth`, `searchrow`,
				 `searchcol`,`searchwidth`, `relatedrow`, `relatedcol`,`relatedwidth`, `memberpagerow`, `memberpagecol`,`memberpagewidth`, `homepopularvideo`,
				 `homepopularvideorow`, `homepopularvideocol`,`homepopularvideowidth`, `homefeaturedvideo`, `homefeaturedvideorow`,
				 `homefeaturedvideocol`,`homefeaturedvideowidth`, `homerecentvideo`, `homerecentvideorow`, `homerecentvideocol`, `homerecentvideowidth`,
				 `myvideorow`, `myvideocol`,`myvideowidth`, `sidepopularvideorow`, `sidepopularvideocol`, `sidefeaturedvideorow`,
				 `sidefeaturedvideocol`, `siderelatedvideorow`, `siderelatedvideocol`, `siderecentvideorow`, 
				 `siderecentvideocol`, `allowupload`, `comment`, `language_settings`, `homepopularvideoorder`,
				 `homefeaturedvideoorder`, `homerecentvideoorder`, `user_login`, `ratingscontrol`, `viewedconrtol` 
		          FROM #__hdflv_site_settings 
		          WHERE `id` = 1';
		$db = $this->getDBO();
		$db->setQuery($query);
		$settings = $db->loadObject();
		//query to check jomcomment component exists
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__extensions 
					  WHERE `element`='com_jomcomment' 
					  AND enabled =1";
		} else {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__components 
				      WHERE `option`='com_jomcomment' 
					  AND enabled =1";
		}
		$db->setQuery($query);
		$jomcomment = $db->loadResult();
		//query to check jcomments component exists		
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$query = "SELECT COUNT(extension_id) 
				      FROM  #__extensions 
					  WHERE `element`='com_jcomments' 
					  AND enabled =1";
		} else {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__components 
					  WHERE `option`='com_jcomments' 
					  AND enabled =1";
		}

		$db->setQuery($query);
		$jcomment = $db->loadResult();		
		if (empty($settings)){
		JError::raiseError(500, 'detail with ID: ' . $id . ' not found.');
		}else
		return array($settings, $jomcomment, $jcomment);
	}

	/**
	 * save sitesettings fields
	 */ 
	function savesitesettings($arrFormData)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();		
		$db = & JFactory::getDBO();		
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		//Get the object for site settings table.
		$objSitesettingsTable = & $this->getTable('sitesettings');		
		// Bind data to the table object.
		if (!$objSitesettingsTable->bind($arrFormData))
		{
			JError::raiseError(500, $objSitesettingsTable->getError());
		}
		// Check that the node data is valid.
		if (!$objSitesettingsTable->check())
		{
			JError::raiseError(500, $objSitesettingsTable->getError());
		}
		// Store the node in the database table.
		if (!$objSitesettingsTable->store())
		{			
			JError::raiseError(500, $objSitesettingsTable->getError());
		}		
		// page redirect
		$link = 'index.php?option=' . $option.'&layout=sitesettings';
		$mainframe->redirect($link, 'Saved Successfully');		
	}
}
?>
