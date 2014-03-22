<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2014 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   March 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Category Module Helper class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modcategorylist
{
	/**
	 * Function to get category list
	 * 
	 * @return  getcategorylist
	 */
	public static function getcategorylist()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('a.id'),
			$db->quoteName('a.category'),
			$db->quoteName('a.seo_category'),
			'COUNT(DISTINCT b.id) AS level'
			);
		$query->clear()
				->select($fields)
				->from($db->quoteName('#__hdflv_category') . ' AS a')
				->leftJoin('#__hdflv_category AS b ON a.lft > b.lft AND a.rgt < b.rgt')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->group($db->escape('a.id' . ' ,' . 'a.category' . ' , ' . 'a.lft' . ' , ' . 'a.rgt'))
				->order($db->quoteName('a.lft'));
		$db->setQuery($query);
		$rs = $db->loadObjectList();

		return $rs;
	}

	/**
	 * Function to get parent category list
	 * 
	 * @param   int  $id  parent category id
	 * 
	 * @return  getcategorylist
	 */
	public static function getparentcategory($id)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*')
					->from('#__hdflv_category')
					->where($db->quoteName('parent_id') . ' IN ( ' . $db->quote($id) . ' ) AND ' . $db->quoteName('published') . ' = ' . $db->quote('1'))
					->order($db->quoteName('category'));
		$db->setQuery($query);
		$rs = $db->loadObjectList();

		return $rs;
	}

	/**
	 * Function to get category settings
	 * 
	 * @return  getcategorysettings
	 */
	public static function getcategorysettings()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Query is to select the popular videos row
		$query->select('dispenable')
			->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->loadResult();

		return $rows;
	}
}
