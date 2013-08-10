<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Category Module Helper
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/* Contushdvideoshare Category Module Helper */
class modcategorylist {
	/* function to get category list */
	public static function getcategorylist() {
		$db =  JFactory::getDBO();
		$query = "SELECT id,category,seo_category
        		  FROM #__hdflv_category 
        		  WHERE parent_id=0 AND published=1 
        		  ORDER BY ordering asc";
		$db->setQuery($query);
		$rs = $db->loadObjectList();
		return $rs;
	}

}

?>
