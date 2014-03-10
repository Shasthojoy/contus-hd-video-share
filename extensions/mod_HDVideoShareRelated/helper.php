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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Related Videos Module Helper
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modrelatedvideos
{
	/**
	 * Function to get Related videos
	 * 
	 * @return  getrelatedvideos
	 */
	public static function getrelatedvideos()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$limitrow = self::getrelatedvideossettings();
		$thumbview = unserialize($limitrow[0]->sidethumbview);
		$length = $thumbview['siderelatedvideorow'] * $thumbview['siderelatedvideocol'];

		/* CODE FOR SEO OPTION OR NOT - START */
		$video = JRequest::getVar('video');
		$id = JRequest::getInt('id');
		$flagVideo = is_numeric($video);

		if (isset($video) && $video != "")
		{
			if ($flagVideo != 1)
			{
				// Joomla router replaced to : from - in query string
				$videoTitle = JRequest::getString('video');
				$videoid = str_replace(':', '-', $videoTitle);

				if ($videoid != "")
				{
					if (!version_compare(JVERSION, '3.0.0', 'ge'))
					{
						$videoid = $db->getEscaped($videoid);
					}
				}

				$query->select('playlistid')
				->from('#__hdflv_upload')
				->where($db->quoteName('seotitle') . ' = ' . $db->quote($videoid));
			}
			else
			{
				$videoid = JRequest::getInt('video');
				$query->select('playlistid')
				->from('#__hdflv_upload')
				->where($db->quoteName('id') . ' = ' . $db->quote($videoid));
			}
		}
		elseif (isset($id) && $id != '')
		{
			$videoid = JRequest::getInt('id');
			$query->select('playlistid')
				->from('#__hdflv_upload')
				->where($db->quoteName('id') . ' = ' . $db->quote($videoid));
		}

		if (isset($query))
		{
			$db->setQuery($query);
			$video = $db->loadResult();
		}

		// CODE FOR SEO OPTION OR NOT - END
		if (isset($videoid) && (isset($video)) && !empty($video))
		{
			$query->clear()
				->select(
						array(
							'a.id', 'a.filepath', 'a.thumburl', 'a.title', 'a.description',
							'a.times_viewed', 'a.ratecount', 'a.rate', 'a.amazons3', 'a.times_viewed',
							'a.seotitle', 'b.category', 'b.seo_category', 'd.username', 'e.catid', 'e.vid'
							)
						)
				->from('#__hdflv_upload AS a')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
				->leftJoin('#__hdflv_category AS b ON e.catid=b.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1') . ' AND ' . $db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.playlistid') . ' = ' . $db->quote($video))
				->group($db->escape('e.vid'))
				->order('rand()');
			$db->setQuery($query, 0, $length);
			$relatedvideos = $db->loadObjectList();

			return $relatedvideos;
		}
	}

	/**
	 * Function to get realted videos module settings
	 * 
	 * @return  getrelatedvideossettings
	 */
	public static function getrelatedvideossettings()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Query is to select the realted videos settings
		$query->select(array('dispenable', 'sidethumbview'))
			->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows;
	}
}
