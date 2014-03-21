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

// Import joomla model library
jimport('joomla.application.component.model');

/**
 * RSS model class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharerss extends ContushdvideoshareModel
{
	/**
	 * Function to get play records
	 * 
	 * @return  playgetrecords
	 */
	public function playgetrecords()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$type = JRequest::getvar('type', '', 'get', 'string');
		$orderby = '';

		switch ($type)
		{
			case 'popular' :
				$orderby = " a.times_viewed";

				break;

			case 'recent' :
				$orderby = "a.id";

				break;

			case 'featured' :
				$where = "a.featured='1'";
				$orderby = "";

				break;

			case 'category' :
				$playid = JRequest::getvar('catid', '', 'get', 'int');
				$where = 'a.playlistid=' . $playid;
				$orderby = '';

				break;
			default;
		}

		$query->select(array('DISTINCT a.*', 'b.category'))
				->from('#__hdflv_upload AS a')
				->leftJoin('#__hdflv_category AS b ON a.playlistid=b.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'));

		if ($where != '')
		{
			$query->where($where);
		}

		if ($orderby != '')
		{
			$query->order($db->escape($orderby . ' ' . 'DESC'));
		}

		$db->setQuery($query);
		$rs_video = $db->loadObjectList();
		$query->clear()
				->select('dispenable')
				->from('#__hdflv_site_settings')
				->where($db->quoteName('id') . ' = ' . $db->quote('1'));
		$db->setQuery($query);
		$setting_res = $db->loadResult();
		$dispenable = unserialize($setting_res);

		$this->showxml($rs_video, $dispenable);
	}

	/**
	 * Function to show RSS
	 * 
	 * @param   array  $rs_video    Video detail array
	 * @param   array  $dispenable  settings array
	 * 
	 * @return  showxml
	 */
	public function showxml($rs_video, $dispenable)
	{
		ob_clean();
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" version="2.0">';
		$config = JFactory::getConfig();
		$mainframe = JFactory::getApplication();

		if (version_compare(JVERSION, '3.0.0', 'ge'))
		{
			$siteName = $mainframe->getCfg('sitename');
		}
		else
		{
			$siteName = $config->getValue('config.sitename');
		}

		echo '<title>' . $siteName . '</title>';
		echo '<link>' . JURI::base() . '</link>';

		$current_path = "components/com_contushdvideoshare/videos/";

		if (count($rs_video) > 0)
		{
			foreach ($rs_video as $rows)
			{
				$timage = "";

				if ($rows->filepath == "File" || $rows->filepath == "FFmpeg")
				{
					if ($hddefault == 0 && $rows->hdurl != '')
					{
						$video = '';
					}
					else
					{
						if (isset($rows->amazons3) && $rows->amazons3 == 1)
						{
							$video = $dispenable['amazons3link'] . $rows->videourl;
						}
						else
						{
							$video = JURI::base() . $current_path . $rows->videourl;
						}
					}

					$video = JURI::base() . $current_path . $rows->videourl;

					if (!empty($rows->previewurl))
					{
						$preview_image = $rows->previewurl;
					}
					else
					{
						$preview_image = 'default_preview.jpg';
					}

					$previewimage = JURI::base() . $current_path . $preview_image;
					$timage = JURI::base() . $current_path . $rows->thumburl;
				}
				elseif ($rows->filepath == "Url")
				{
					$video = $rows->videourl;

					if (!empty($rows->previewurl))
					{
						$previewimage = $rows->previewurl;
					}
					else
					{
						$previewimage = JURI::base() . $current_path . 'default_preview.jpg';
					}

					$timage = $rows->thumburl;
				}
				elseif ($rows->filepath == "Youtube")
				{
					$video = $rows->videourl;
					$str2 = strstr($rows->previewurl, 'components');

					if ($str2 != "")
					{
						$previewimage = JURI::base() . $rows->previewurl;
						$timage = JURI::base() . $rows->thumburl;
					}
					else
					{
						$previewimage = $rows->previewurl;
						$timage = $rows->thumburl;
					}
				}

				$db = JFactory::getDBO();
				$query = $db->getQuery(true);
				$query->select('dispenable')
						->from('#__hdflv_site_settings');
				$db->setQuery($query);
				$resultSetting = $db->loadResult();
				$dispenable = unserialize($resultSetting);

				$query->clear()
						->select('seo_category')
						->from('#__hdflv_category')
						->where($db->quoteName('id') . ' = ' . $db->quote($rows->playlistid));
				$db->setQuery($query);
				$categorySeo = $db->loadObjectList();

				if ($dispenable['seo_option'] == 1)
				{
					$fbCategoryVal = "category=" . $categorySeo[0]->seo_category;
					$fbVideoVal = "video=" . $rows->seotitle;
				}
				else
				{
					$fbCategoryVal = "catid=" . $rows->playlistid;
					$fbVideoVal = "id=" . $rows->id;
				}

				$baseUrl = JURI::base();
				$baseUrl1 = parse_url($baseUrl);
				$baseUrl1 = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];

				$fbPath = $baseUrl1 . JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal);
				$views = $rows->times_viewed;
				$date = date("m-d-Y", strtotime($rows->created_date));

				echo '<item>';
				echo '<videoId>' . $rows->id . '</videoId>';
				echo '<videoUrl>' . $video . '</videoUrl>';
				echo '<thumbImage>' . $timage . '</thumbImage>';
				echo '<previewImage>' . $previewimage . '</previewImage>';
				echo '<views>' . $views . '</views>';
				echo '<createdDate>' . $date . '</createdDate>';
				echo '<title>';
				echo '<![CDATA[' . $rows->title . ']]>';
				echo '</title>';
				echo '<description>';
				echo '<![CDATA[' . $rows->description . ']]>';
				echo '</description>';
				echo '<tags>';
				echo '<![CDATA[' . $rows->tags . ']]>';
				echo '</tags>';
				echo '<link>' . $fbPath . '</link>';
				echo '<generator>Video_Share_Feed</generator>';
				echo '<docs>http://blogs.law.harvard.edu/tech/rss</docs>';
				echo '</item>';
			}
		}

		echo '</rss>';
		exit();
	}
}
