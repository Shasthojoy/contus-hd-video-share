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
 * @abstract      : Contus HD Video Share Component Addads Model
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');

/**
 * Contushdvideoshare Component Administrator Addads Model
 */
class contushdvideoshareModeladdads extends JModelList {

	/**
	 * Function to add ads
	 */
	function addadsmodel()
	{
		$rs_ads = JTable::getInstance('ads', 'Table');
		$add = array('rs_ads' => $rs_ads);
		return $add;
	}
}
?>
