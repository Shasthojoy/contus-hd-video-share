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
 * @Modified Date   February 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Recent Videos Module Helper
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modrecentvideos
{
	/**
	 * Function to get Recent videos
	 * 
	 * @return  getfeaturedVideos
	 */
	public static function getrecentvideos()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$limitrow = self::getrecentvideossettings();
		$thumbview = unserialize($limitrow[0]->sidethumbview);
		$length = $thumbview['siderecentvideorow'] * $thumbview['siderecentvideocol'];

		// Query is to display recent videos
		$query->select(
				array(
					'a.id', 'a.filepath', 'a.thumburl', 'a.title', 'a.description',
					'a.times_viewed', 'a.ratecount', 'a.rate', 'a.amazons3', 'a.times_viewed',
					'a.seotitle', 'b.category', 'b.seo_category', 'd.username', 'e.catid', 'e.vid')
				)
				->from('#__hdflv_upload AS a')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
				->leftJoin('#__hdflv_category AS b ON e.catid=b.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1') . ' AND ' . $db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.type') . ' = ' . $db->quote('0'))
				->group($db->escape('e.vid'))
				->order('a.id DESC');
		$db->setQuery($query, 0, $length);
		$recentvideos = $db->loadobjectList();

		return $recentvideos;
	}

	/**
	 * Function to get recent videos module settings
	 * 
	 * @return  getrecentvideossettings
	 */
	public static function getrecentvideossettings()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Query is to select the recent videos settings
		$query->select(array('dispenable', 'sidethumbview'))
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->LoadObjectList();

		return $rows;
	}
}
