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
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * Related videos model class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharerelatedvideos extends ContushdvideoshareModel
{
	/**
	 * Function to display a Related videos
	 * 
	 * @return  getrelatedvideos
	 */
	public function getrelatedvideos()
	{
		$db = $this->getDBO();
		$query = $db->getQuery(true);
		$limitrow = $this->getrelatedvideosrowcol();
		$rows = '';
		$videoid = $category = $video = '';

		// CODE FOR SEO OPTION OR NOT - START
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

				$db->setQuery($query);
				$video = $db->loadResult();
			}
			else
			{
				$videoid = JRequest::getInt('video');
				$query->select('playlistid')
						->from('#__hdflv_upload')
						->where($db->quoteName('id') . ' = ' . $db->quote($videoid));
				$db->setQuery($query);
				$video = $db->loadResult();
			}
		}
		elseif (isset($id) && $id != '')
		{
			$videoid = JRequest::getInt('id');
			$query->select('playlistid')
					->from('#__hdflv_upload')
					->where($db->quoteName('id') . ' = ' . $db->quote($videoid));
			$db->setQuery($query);
			$video = $db->loadResult();
		}

		if (!isset($video) && $video == '')
		{
			$video = 0;
		}

		if (!isset($videoid) && $videoid == '')
		{
			$videoid = 0;
		}

		// Query for getting the pagination values for related video page
		$query->clear()
				->select(array('COUNT(a.id)'))
				->from('#__hdflv_upload AS a')
				->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
				->leftJoin('#__hdflv_category AS b ON e.catid=b.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.playlistid') . ' = ' . $db->quote($video));
		$db->setQuery($query);
		$total = $db->loadResult();
		$pageno = 1;

		if (JRequest::getVar('page', '', 'post', 'int'))
		{
			$pageno = JRequest::getVar('page', '', 'post', 'int');
		}

		$thumbview = unserialize($limitrow[0]->thumbview);
		$length = $thumbview['relatedrow'] * $thumbview['relatedcol'];
		$pages = ceil($total / $length);

		if ($pageno == 1)
		{
			$start = 0;
		}
		else
		{
			$start = ($pageno - 1) * $length;
		}

		if (isset($videoid) && (isset($video)) && !empty($video))
		{
			$query->clear()
					->select(
							array(
								$db->quoteName('a.id'), $db->quoteName('a.filepath'), $db->quoteName('a.thumburl'),
								$db->quoteName('a.title'), $db->quoteName('a.description'),
								$db->quoteName('a.times_viewed'), $db->quoteName('a.ratecount'),
								$db->quoteName('a.rate'), $db->quoteName('a.amazons3'), $db->quoteName('a.seotitle'),
								$db->quoteName('b.id') . ' AS catid', $db->quoteName('b.category'),
								$db->quoteName('b.seo_category'), $db->quoteName('e.catid'), $db->quoteName('e.vid')
							)
					)
					->from('#__hdflv_upload AS a')
					->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
					->leftJoin('#__hdflv_category AS b ON e.catid=b.id')
					->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
					->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
					->where($db->quoteName('a.playlistid') . ' = ' . $db->quote($video))
					->group($db->escape('a.id'))
					->order('rand()');
			$db->setQuery($query, $start, $length);
			$rows = $db->loadObjectList();
		}

		if (count($rows) > 0)
		{
			$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;
		}

		return $rows;
	}

	/**
	 * Function to get thumb settings
	 * 
	 * @return  getrelatedvideosrowcol
	 */
	public function getrelatedvideosrowcol()
	{
		$db = $this->getDBO();
		$query = $db->getQuery(true);

		// Query is to select the popular videos row
		$query->select(array('thumbview', 'dispenable'))
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->LoadObjectList();

		return $rows;
	}
}
