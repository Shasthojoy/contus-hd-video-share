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
 * @abstract      : Contushdvideoshare Component Sortorder Model 
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die();
// import joomla model library
jimport('joomla.application.component.model');

class contushdvideoshareModelsortorder extends JModel {


	//Function to change sort order when drags the row
	function videosortordermodel()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$listitem=JRequest::getvar('listItem');
		$ids = implode(',', $listitem);
		$sql = 'UPDATE `#__hdflv_upload` SET `ordering` = CASE id ';
		foreach ($listitem as $position => $item) {
			$sql .= sprintf("WHEN %d THEN %d ", $item, $position);
		}
		$sql .= ' END WHERE id IN ('.$ids.')';
		$db->setQuery($sql);
		$db->query();	
		exit();

	}
	
	
	



}
?>
