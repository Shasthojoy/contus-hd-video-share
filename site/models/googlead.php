<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2011 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   February 2014
 * */
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * Googlead model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharegooglead extends ContushdvideoshareModel
{
	/**
	 * Function to get google adsense
	 * 
	 * @return  getgooglead
	 */
	public function getgooglead()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*')
				->from('#__hdflv_googlead')
				->where($db->quoteName('publish') . ' = ' . $db->quote('1'))
				->where($db->quoteName('id') . ' = ' . $db->quote('1'));
		$db->setQuery($query);
		$fields = $db->loadObjectList();

		return html_entity_decode(stripcslashes($fields[0]->code));
	}
}
