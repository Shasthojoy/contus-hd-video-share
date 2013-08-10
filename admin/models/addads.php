<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Addads Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
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
class contushdvideoshareModeladdads extends JModel {

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
