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

// Import joomla model library
jimport('joomla.application.component.model');

/**
 * Playxml model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideoshareplayxml extends ContushdvideoshareModel
{
	/**
	 * Function to get videos for player
	 * 
	 * @return  playgetrecords
	 */
	public function playgetrecords()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$videoid = 0;
		$vid = JRequest::getvar('id');
		$categ_id = JRequest::getvar('catid');
		$mid = JRequest::getString('mid');
		$adminview = JRequest::getString('adminview');

		if ($adminview == true)
		{
			$publish = '';
		}
		else
		{
			$publish = $db->quoteName('a.published') . ' = ' . $db->quote('1');
		}

		if ($vid != 0)
		{
			$query->update($db->quoteName('#__hdflv_upload'))
					->set(array($db->quoteName('times_viewed') . '= 1+times_viewed'))
					->where($db->quoteName('id') . ' = ' . $db->quote($vid));
			$db->setQuery($query);
			$db->query();

			$query->clear()
					->select(array('DISTINCT a.*', 'b.category'))
					->from('#__hdflv_upload AS a')
					->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

			if ($publish != '')
			{
				$query->where($publish);
			}

			$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
					->where($db->quoteName('a.id') . ' = ' . $db->quote($vid))
					->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
			$db->setQuery($query);
			$rows = $db->loadObjectList();

			if (!empty($categ_id) && $rows[0]->playlistid != $categ_id)
			{
				$rows = array();
			}
		}

		if ($mid == 'playerModule')
		{
			if (count($rows) > 0)
			{
				$query->clear()
						->select(array('DISTINCT a.*', 'b.category'))
						->from('#__hdflv_upload AS a')
						->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id or a.playlistid=b.parent_id');

				if ($publish != '')
				{
					$query->where($publish);
				}

				$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('a.featured') . ' = ' . $db->quote('1'))
						->where($db->quoteName('a.id') . ' = ' . $db->quote($vid))
						->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'))
						->order($db->escape('a.id' . ' ' . 'DESC'));
				$db->setQuery($query, 3);
				$playlist_loop = $db->loadObjectList();

				// Array rotation to autoplay the videos correctly
				$arr1 = $arr2 = array();

				if (count($playlist_loop) > 0)
				{
					foreach ($playlist_loop as $r)
					{
						if ($r->id > $rows[0]->id)
						{
							// Storing greater values in an array
							$query->clear()
									->select(array('DISTINCT a.*', 'b.category'))
									->from('#__hdflv_upload AS a')
									->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

							if ($publish != '')
							{
								$query->where($publish);
							}

							$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
									->where($db->quoteName('a.id') . ' = ' . $db->quote($r->id))
									->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
							$db->setQuery($query);
							$arrGreat = $db->loadObject();
							$arr1[] = $arrGreat;
						}
						else
						{
							// Storing lesser values in an array
							$query->clear()
									->select(array('DISTINCT a.*', 'b.category'))
									->from('#__hdflv_upload AS a')
									->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

							if ($publish != '')
							{
								$query->where($publish);
							}

							$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
									->where($db->quoteName('a.id') . ' = ' . $db->quote($r->id))
									->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
							$db->setQuery($query);
							$arrLess = $db->loadObject();
							$arr2[] = $arrLess;
						}
					}
				}

				$playlist = array_merge($arr2, $arr1);
			}
		}
		elseif ($vid)
		{
			$videoid = $vid;

			if ($categ_id)
			{
				$videocategory = $categ_id;
			}
			else
			{
				$videocategory = $rows[0]->playlistid;
			}

			if ($rows[0]->playlistid == $categ_id)
			{
				if (count($rows) > 0)
				{
					$query->clear()
							->select(array('DISTINCT a.*', 'b.category'))
							->from('#__hdflv_upload AS a')
							->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

					if ($publish != '')
					{
						$query->where($publish);
					}

					$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
							->where(
									'('
									. $db->quoteName('b.id') . ' = ' . $db->quote($videocategory)
									. ' OR ' . $db->quoteName('b.parent_id') . ' = ' . $db->quote($videocategory)
									. ')'
							)
							->where($db->quoteName('a.id') . ' != ' . $db->quote($videoid))
							->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
					$db->setQuery($query);
					$playlist_loop = $db->loadObjectList();

					// Array rotation to autoplay the videos correctly
					$arr1 = $arr2 = array();

					if (count($playlist_loop) > 0)
					{
						foreach ($playlist_loop as $r)
						{
							if ($r->id > $rows[0]->id)
							{
								// Storing greater values in an array
								$query->clear()
										->select(array('DISTINCT a.*', 'b.category'))
										->from('#__hdflv_upload AS a')
										->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

								if ($publish != '')
								{
									$query->where($publish);
								}

								$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
										->where($db->quoteName('a.id') . ' = ' . $db->quote($r->id))
										->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
								$db->setQuery($query);
								$arrGreat = $db->loadObject();
								$arr1[] = $arrGreat;
							}
							else
							{
								// Storing lesser values in an array
								$query->clear()
										->select(array('DISTINCT a.*', 'b.category'))
										->from('#__hdflv_upload AS a')
										->leftJoin('#__hdflv_video_category AS b ON a.playlistid=b.id');

								if ($publish != '')
								{
									$query->where($publish);
								}

								$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
										->where($db->quoteName('a.id') . ' = ' . $db->quote($r->id))
										->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'));
								$db->setQuery($query);
								$arrLess = $db->loadObject();
								$arr2[] = $arrLess;
							}
						}
					}

					$playlist = array_merge($arr1, $arr2);
				}
			}
			else
			{
				$playlist = array();
			}
		}
		else
		{
			$query->clear()
					->select(
							array(
								'a.*', 'b.category', 'b.seo_category', 'd.username', 'e.*'
							)
					)
					->from('#__hdflv_upload AS a')
					->leftJoin('#__users AS d ON a.memberid=d.id')
					->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
					->leftJoin('#__hdflv_category AS b ON e.catid=b.id');

			if ($publish != '')
			{
				$query->where($publish);
			}

			$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
					->where($db->quoteName('a.featured') . ' = ' . $db->quote('1'))
					->where($db->quoteName('a.type') . ' = ' . $db->quote('0'))
					->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'))
					->group($db->escape('e.vid'))
					->order($db->escape('a.ordering' . ' ' . 'ASC'));

			// Query is to display recent videos in home page
			$db->setQuery($query);
			$rs_video = $db->loadObjectList();

			if (JRequest::getvar('featured') && !empty($rs_video))
			{
				$featured = JRequest::getvar('featured');

				if ($featured == "true")
				{
					$query->clear()
							->update($db->quoteName('#__hdflv_upload'))
							->set(array($db->quoteName('times_viewed') . '= 1+times_viewed'))
							->where($db->quoteName('id') . ' = ' . $db->quote($rs_video[0]->id));
					$db->setQuery($query);
					$db->query();
				}
			}

			if (count($rs_video) == 0)
			{
				$query->clear()
						->select(
								array(
									'a.*', 'b.category', 'b.seo_category', 'd.username', 'e.*'
								)
						)
						->from('#__hdflv_upload AS a')
						->leftJoin('#__users AS d ON a.memberid=d.id')
						->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
						->leftJoin('#__hdflv_category AS b ON e.catid=b.id');

				if ($publish != '')
				{
					$query->where($publish);
				}

				$query->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('a.type') . ' = ' . $db->quote('0'))
						->where($db->quoteName('a.filepath') . ' != ' . $db->quote('Embed'))
						->group($db->escape('e.vid'))
						->order($db->escape('a.ordering' . ' ' . 'ASC'));

				// Query is to display recent videos in home page
				$db->setQuery($query, 0, 1);
				$rs_video = $db->loadObjectList();
			}
		}

		if (isset($rows) && count($rows) > 0)
		{
			$rs_video = array_merge($rows, $playlist);
		}

		$this->showxml($rs_video);
	}

	/**
	 * Function to show playxml
	 * 
	 * @param   array  $rs_video  video detail in array format
	 * 
	 * @return  showxml
	 */
	public function showxml($rs_video)
	{
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$rows = $uid = $hdvideo = $timage = $streamername = $targeturl = $subtitle = '';
		$postrollid = $prerollid = 0;
		$download = $playlistautoplay = $islive = "false";
		$member = "true";
		$current_path = "components/com_contushdvideoshare/videos/";
		$adminview = JRequest::getString('adminview');

		if (version_compare(JVERSION, '1.6.0', 'ge'))
		{
			$uid = $user->get('id');

			if ($uid)
			{
				$query->select('g.id AS group_id')
						->from('#__usergroups AS g')
						->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
						->where('map.user_id = ' . (int) $uid);
				$db->setQuery($query);
				$message = $db->loadObjectList();

				foreach ($message as $mess)
				{
					$accessid[] = $mess->group_id;
				}
			}
			else
			{
				$accessid[] = 1;
			}
		}
		else
		{
			$accessid = $user->get('aid');
		}

		$query->clear()
				->select('dispenable')
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$resultSetting = $db->loadResult();
		$dispenable = unserialize($resultSetting);

		// Get player settings
		$query->clear()
				->select('player_icons')
				->from('#__hdflv_player_settings');
		$db->setQuery($query, 1);
		$rs_settings = $db->loadResult();
		$player_icons = unserialize($rs_settings);

		if ($player_icons['playlist_autoplay'] == 1)
		{
			$playlistautoplay = "true";
		}

		$hddefault = $player_icons['hddefault'];

		// Generate Playlist xml here
		ob_clean();
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<playlist autoplay="' . $playlistautoplay . '">';

		if (count($rs_video) > 0)
		{
			foreach ($rs_video as $rows)
			{
				// Get user access level
				if (version_compare(JVERSION, '1.6.0', 'ge'))
				{
					if ($rows->useraccess == 0)
					{
						$rows->useraccess = 1;
					}

					$query->clear()
							->select('rules as rule')
							->from('#__viewlevels AS view')
							->where('id = ' . (int) $rows->useraccess);
					$db->setQuery($query);
					$message = $db->loadResult();
					$accessLevel = json_decode($message);
				}

				// Get details of upload and FFMPEG type videos
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
							$video = "http://" . $dispenable['amazons3name']
									. ".s3.amazonaws.com/components/com_contushdvideoshare/videos/" . $rows->videourl;
						}
						else
						{
							$video = JURI::base() . $current_path . $rows->videourl;
						}
					}

					if (isset($rows->amazons3) && $rows->amazons3 == 1)
					{
						$video = "http://" . $dispenable['amazons3name']
								. ".s3.amazonaws.com/components/com_contushdvideoshare/videos/" . $rows->videourl;
					}
					else
					{
						$video = JURI::base() . $current_path . $rows->videourl;
					}

					if ($rows->hdurl != "")
					{
						if (isset($rows->amazons3) && $rows->amazons3 == 1)
						{
							$hdvideo = "http://" . $dispenable['amazons3name']
									. ".s3.amazonaws.com/components/com_contushdvideoshare/videos/" . $rows->hdurl;
						}
						else
						{
							$hdvideo = JURI::base() . $current_path . $rows->hdurl;
						}
					}

					if (!empty($rows->previewurl))
					{
						$preview_image = $rows->previewurl;
					}
					else
					{
						$preview_image = 'default_preview.jpg';
					}

					if (isset($rows->amazons3) && $rows->amazons3 == 1 && !empty($rows->previewurl))
					{
						$previewimage = "http://" . $dispenable['amazons3name']
								. ".s3.amazonaws.com/components/com_contushdvideoshare/videos/" . $rows->previewurl;
					}
					else
					{
						$previewimage = JURI::base() . $current_path . $preview_image;
					}

					if (isset($rows->amazons3) && $rows->amazons3 == 1)
					{
						$timage = "http://" . $dispenable['amazons3name']
								. ".s3.amazonaws.com/components/com_contushdvideoshare/videos/" . $rows->thumburl;
					}
					else
					{
						$timage = JURI::base() . $current_path . $rows->thumburl;
					}

					if ($rows->hdurl)
					{
						$hd_bol = "true";
					}
					else
					{
						$hd_bol = "false";
					}
				}

				// Get details of URL type videos
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

					if ($rows->hdurl)
					{
						$hd_bol = "true";
					}
					else
					{
						$hd_bol = "false";
					}

					$hdvideo = $rows->hdurl;
				}

				// Get details of Youtube type videos
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

					$hd_bol = "false";
					$hdvideo = "";
				}

				// Get streaming option
				if ($rows->streameroption == "lighttpd")
				{
					$streamername = $rows->streameroption;
				}

				// Get RTMP path
				if ($rows->streameroption == "rtmp")
				{
					$streamername = $rows->streamerpath;
				}

				// Get subtitles
				$subtitle1 = $rows->subtitle1;
				$subtitle2 = $rows->subtitle2;
				$subtitle_path = JURI::base() . $current_path;

				if (!empty($subtitle1) && !empty($subtitle2))
				{
					$subtitle = $subtitle_path . $subtitle1 . ',' . $subtitle_path . $subtitle2;
				}
				elseif (!empty($subtitle1))
				{
					$subtitle = $subtitle_path . $subtitle1;
				}
				elseif (!empty($subtitle2))
				{
					$subtitle = $subtitle_path . $subtitle2;
				}

				// Get post roll ad id for video
				$query->clear()
						->select('*')
						->from('#__hdflv_ads')
						->where($db->quoteName('published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('id') . ' = ' . $db->quote($rows->postrollid));
				$db->setQuery($query);
				$rs_postads = $db->loadObjectList();
				$postroll = ' allow_postroll = "false"';
				$postroll_id = ' postroll_id = "0"';

				if (count($rs_postads) > 0)
				{
					if ($rows->postrollads == 1)
					{
						$postroll = ' allow_postroll = "true"';
						$postroll_id = ' postroll_id = "' . $rows->postrollid . '"';
					}
				}

				// Get pre roll ad id for video
				$query->clear()
						->select('*')
						->from('#__hdflv_ads')
						->where($db->quoteName('published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('id') . ' = ' . $db->quote($rows->prerollid));
				$db->setQuery($query);
				$rs_preads = $db->loadObjectList();
				$preroll = ' allow_preroll = "false"';
				$preroll_id = ' preroll_id = "0"';

				if (count($rs_preads) > 0)
				{
					if ($rows->prerollads == 1)
					{
						$preroll = ' allow_preroll = "true"';
						$preroll_id = ' preroll_id = "' . $rows->prerollid . '"';
					}
				}

				// Get mid ad id for video
				$query->clear()
						->select('*')
						->from('#__hdflv_ads')
						->where($db->quoteName('published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('typeofadd') . ' = ' . $db->quote('mid'));
				$db->setQuery($query);
				$rs_ads = $db->loadObjectList();
				$midroll = ' allow_midroll = "false"';

				if (count($rs_ads) > 0)
				{
					if ($rows->midrollads == 1)
					{
						$midroll = ' allow_midroll = "true"';
					}
				}

				// Get ima ad for video
				$query->clear()
						->select('*')
						->from('#__hdflv_ads')
						->where($db->quoteName('published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('typeofadd') . ' = ' . $db->quote('ima'));
				$db->setQuery($query);
				$rs_imaads = $db->loadObjectList();
				$imaad = ' allow_ima = "false"';

				if (count($rs_imaads) > 0)
				{
					if ($rows->imaads == 1)
					{
						$imaad = ' allow_ima = "true"';
					}
				}

				// Get download option for particular video
				if ($rows->download == 1)
				{
					$download = "true";
				}

				// Video restriction based on access level starts here
				if (version_compare(JVERSION, '1.6.0', 'ge'))
				{
					$member = "false";

					foreach ($accessLevel as $useracess)
					{
						if (in_array("$useracess", $accessid) || $useracess == 1)
						{
							$member = "true";
							break;
						}
					}
				}
				else
				{
					if ($rows->useraccess != 0)
					{
						if ($accessid != $rows->useraccess && $accessid != 2)
						{
							$member = "false";
						}
					}
				}

				// Video restriction based on access level ends here
				$query->clear()
						->select('seo_category')
						->from('#__hdflv_category')
						->where($db->quoteName('id') . ' = ' . $db->quote($rows->playlistid));
				$db->setQuery($query);

				// Get seo category title
				$seo_category = $db->loadResult();

				if ($dispenable['seo_option'] == 1)
				{
					// If seo option enabled
					$fbCategoryVal = "category=" . $seo_category;
					$fbVideoVal = "video=" . $rows->seotitle;
				}
				else
				{
					// If seo option disabled
					$fbCategoryVal = "catid=" . $rows->playlistid;
					$fbVideoVal = "id=" . $rows->id;
				}

				// Genearte Base URL
				$baseUrl = JURI::base();
				$baseUrl1 = parse_url($baseUrl);
				$baseUrl1 = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];

				// Generate URL for every video
				$fbPath = $baseUrl1 . JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal);

				if ($rows->targeturl != "")
				{
					// Get target url for a video
					$targeturl = $rows->targeturl;
				}

				if ($rows->postrollads == "1")
				{
					// Get pre roll id for a video
					$postrollid = $rows->postrollid;
				}

				if ($rows->prerollads == "1")
				{
					// Get post roll id for a video
					$prerollid = $rows->prerollid;
				}

				// Get title of the video
				$title = $rows->title;

				// Get view count of the video
				$views = $rows->times_viewed;

				// Get tag name for video
				$tags = $rows->tags;

				// Get video ID
				$video_id = $rows->id;

				// Get video Description
				$description = $rows->description;

				if ($rows->filepath == "Youtube" || $rows->filepath == "Url")
				{
					// Display download option for youtube videos
					$download = "false";
				}

				if ($streamername != "")
				{
					if ($rows->islive == 1)
					{
						// Check for RTMP video is live one or not
						$islive = "true";
					}
				}

				if (!empty($adminview))
				{
					$member = "true";
				}

				// Restrict playxml for vimeo videos.
				if (!preg_match('/vimeo/', $video))
				{
					echo '<mainvideo member="' . $member . '" uid="' . $uid . '" subtitle ="' . $subtitle . '"
						views="' . $views . '"
						streamer_path="' . $streamername . '"
						video_isLive="' . $islive . '"
						video_id = "' . htmlspecialchars($video_id) . '"
						fbpath = "' . $fbPath . '"
						video_url = "' . htmlspecialchars($video) . '"
						thumb_image = "' . htmlspecialchars($timage) . '"
						preview_image = "' . htmlspecialchars($previewimage) . '"
						' . $midroll . '
						' . $imaad . '
						' . $postroll . '
						' . $preroll . '
						' . $postroll_id . '
						' . $preroll_id . '
						Tag =  "' . $tags . '"
						allow_download = "' . $download . '"
						video_hdpath = "' . $hdvideo . '"
						copylink = "">
						<title><![CDATA[' . htmlspecialchars($title) . ']]></title>
						<tagline targeturl="' . $targeturl . '">
							<![CDATA[' . strip_tags($description) . ']]></tagline>
						</mainvideo>';
				}
			}
		}

		echo '</playlist>';
		exit();
	}
}
