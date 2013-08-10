<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Showads Model
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
// import Joomla pagination library
jimport('joomla.html.pagination');
//Import filesystem libraries.
jimport('joomla.filesystem.file');

/**
 * Contushdvideoshare Component Administrator Showads Model
 */

class contushdvideoshareModelshowads extends JModelList {

	/**
	 * Constructor
	 * global variable initialization
	 */

	function __construct() {
		global $mainframe,$db,$option;
		parent::__construct();
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$option = JRequest::getCmd('option');
	}

	/**
	 * fuction to show ads
	 */

	function showadsmodel(){
		
		global $db,$mainframe,$option;
		
		// filter variable for ads order
		$strFilterAdsName = $mainframe->getUserStateFromRequest($option . 'filter_order_ads', 'filter_order', 'adsname', 'cmd');
		// filter variable for ads order direction
		$strFilterAdsDir = $mainframe->getUserStateFromRequest($option . 'filter_order_Dir_ads', 'filter_order_Dir', 'asc', 'word');
		// filter variable for ads name search		
		$strSearchAds = $mainframe->getUserStateFromRequest($option . 'ads_search', 'ads_search', '', 'string');
		// filter variable for ads status search
		$strFilterAdsStatus = $mainframe->getUserStateFromRequest($option . 'ads_status', 'ads_status', '', 'int');
		// filter variable for ads type search
		$strFilterAdsType = $mainframe->getUserStateFromRequest($option . 'ads_type', 'ads_type', '', 'string');
		
		/**
		 * for page navigation
		 * get default list limit from global settings
		 * and limit start @ initial value is 0
		 * */ 
		
		$limit = $mainframe->getUserStateFromRequest($option.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'limitstart', 'limitstart', 0, 'int');

		$where = ' WHERE ';	
		
		// filtering based on search keyword
		if ($strSearchAds)
		{		
			$where .= " adsname LIKE '%$strSearchAds%'";						
			$arrAdsFilter['ads_search'] = $strSearchAds;						
		}
		
		// filtering based on status
		if($strFilterAdsStatus) {			
			if($strFilterAdsStatus == 1) {
				$strFilterStatusval = 1;
			}elseif ($strFilterAdsStatus == 2) {
				$strFilterStatusval = 0;
			}else {
				$strFilterStatusval = -2;
			}
				if($strSearchAds) 
				$where .= ' AND '; 
				$where .= " published = $strFilterStatusval";	
									 			
			$arrAdsFilter['ads_status'] = $strFilterAdsStatus;				
		} else {	
			if ($strSearchAds)
			$where .= ' AND '; 		
			$where .= " published != -2";
		}
		
		// filtering based on ads type
		if ($strFilterAdsType)
		{		
            $strFilterTypeval = ($strFilterAdsType == '1')?'prepost':'mid';			
			$where .= ' AND '; 
			$where .= ' typeofadd = "'.$strFilterTypeval.'" ';
			$arrAdsFilter['ads_type'] = $strFilterAdsType;						
		}
		
		// assign filter variables
		$arrAdsFilter['filter_order_Dir_ads'] = $strFilterAdsDir;
		$arrAdsFilter['filter_order_ads'] = $strFilterAdsName;
		
		$query = "SELECT `id`,`published`,`adsname`,`filepath`,`postvideopath`,`targeturl`,`clickurl`,
        		  `impressionurl`,`impressioncounts`,`clickcounts`,`adsdesc`,`typeofadd`
        		  FROM #__hdflv_ads 
				  $where
				  ORDER BY $strFilterAdsName $strFilterAdsDir";
				  
		$db->setQuery($query);
		$arrAdsCount = $db->loadObjectList();
		// set count for pagination
		$strAdsCount = count($arrAdsCount);
		// set pagination
		$pageNav = new JPagination($strAdsCount, $limitstart, $limit);
		$query .= " LIMIT $pageNav->limitstart,$pageNav->limit";	  
		$db->setQuery($query);
		$arrAds = $db->loadObjectList();	
		
		/**
		 * get the most recent database error code
		 * display the last database error message in a standard format
		 *
		 */
		if ($db->getErrorNum())
		{
			JError::raiseWarning($db->getErrorNum(), $db->stderr());
		}	
				
		return array('adsList' => $arrAds, 'adsFilter' => $arrAdsFilter, 'limitstart' => $limitstart, 'pageNav' => $pageNav);
	}

	/**
	 * function to save ads
	 */

	function saveads($task){
		global $option,$mainframe,$db;
		$objAdTable = JTable::getInstance('ads', 'Table');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$id = $cid[0];
		$objAdTable->load($id);
		$arrFormData = JRequest::get('POST');
		/**
		 * function to bind object values
		 */
		
		if (!$objAdTable->bind($arrFormData))
		{
			JError::raiseWarning(500, $objAdTable->getError());
		}
		
		$strFileOption = $arrFormData['fileoption'];
		$vpath=VPATH."/";
		
		/**
		 * function to save form data
		 */
		
		if (!$objAdTable->store()) 
		{
			JError::raiseWarning(500, $objAdTable->getError());
		}
		
		/**
		 * function to user check in process
		 */
		
		$objAdTable->checkin();
		$strAdId = $objAdTable->id;

		if($strFileOption == "Url")
		{
			$postvideopath = $arrFormData['posturl-value'];
			$query="UPDATE #__hdflv_ads 
			        SET filepath='$strFileOption',postvideopath='$postvideopath' 
			        WHERE id=$strAdId";
			$db->setQuery($query );
			$db->query();
		}
		
		/**
		 * VPATH to get target path
		 * target path @ /components/com_contushdvideoshare/videos
		 * FVPATH to get temporary path
		 * temp path @ /components/com_contushdvideoshare/images/uploads
		 * */		
		
		if($strFileOption == 'File')
		{
		$target_path ='';
		$normal_video = $arrFormData['normalvideoform-value'];
		$video_name=explode("uploads/", $normal_video);
		$vpath = VPATH."/";
		$file_video = '';
		if(isset($video_name[1])) {
			$file_video = $video_name[1];
		}
		if($file_video)
		{
			$ext = $this->getFileExt($file_video);
			$strTmpPath = FVPATH."/images/uploads/".$file_video;
			$strTargetPath = $vpath.$strAdId."_ads".".".$ext;
			$file_name=$strAdId."_ads".".".$ext;
			
			if (JFile::exists($strTargetPath))
			{
				JFile::delete($strTargetPath);
			}
			
			/**
			 * function to files move from temp path to target path
			 * Temp path @ /components/com_contushdvideoshare/images/uploads
			 * Target path @ /components/com_hdvideoshare/videos/			 
			 */			
			
			rename($strTmpPath, $strTargetPath);
			
			/**
			 * query to update video path and fileoption
			 */
			
			$strFileOption="File";
			$query = "UPDATE #__hdflv_ads
                	  SET postvideopath='$file_name',filepath='$strFileOption' 
                	  WHERE id = $strAdId ";
			$db->setQuery( $query );
			$db->query();
		}
		}
		
		if($strFileOption == ''){
			
			/**
			 * query to update file path
			 */
			
			$strFileOption = '';
			$query = "UPDATE #__hdflv_ads
                	  SET filepath='$strFileOption' 
                	  WHERE id = $strAdId ";
			$db->setQuery( $query );
			$db->query();
		}
		
		/**
		 * function to set redirect URL for SAVE and APPLY action.
		 */

		switch ($task)
		{
			case 'applyads':
				$link = 'index.php?option=' . $option .'&layout=ads&task=editads&cid[]='. $strAdId;
				break;
			case 'saveads':
			default:
				$link = 'index.php?option=' . $option.'&layout=ads';
				break;
		}
		$msg = 'Saved Successfully';
		
		// set to redirect
		$mainframe->redirect($link, $msg);
	}

	/**
	 * function to get file extension
	 */

	function getFileExt($strFileName)
	{
		$strFileName = strtolower($strFileName) ;
		return JFile::getExt($strFileName);
	}

	/**
	 * function to publish and unpublish ads
	 */

	function statusChange($ads) {
		global $mainframe;
		if ($ads['task'] == 'publish') {
			$publish = 1;
			$msg = 'Published Successfully';
		} elseif($ads['task'] == 'trash') {
			$publish = -2;
			$msg = 'Trashed Successfully';
		} else {
			$publish = 0;
			$msg = 'Unpublished Successfully';
		}
		$cids = $ads['cid'];
		$adsTable =& JTable::getInstance('ads', 'Table');
		$adsTable->publish($cids, $publish);
		$link = 'index.php?option=com_contushdvideoshare&layout=ads';
		$mainframe->redirect($link, $msg);
	}
}
?>
