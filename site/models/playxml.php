<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.3
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Playxml Model
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Playxml Model
 */
class Modelcontushdvideoshareplayxml extends ContushdvideoshareModel {

	function playgetrecords() {
		global $mainframe;
		$db = JFactory::getDBO();
		$playlistid = 0;
		$mid = 0;
		$itemid = 0;
		$rs_modulesettings = "";
		$moduleid = 0;
		$id = 0;
		$playlistautoplay = "false";
		$postrollads = "false";
		$prerollads = "false";
		$videoid = 0;
		$home_bol = "false";
		if (JRequest::getvar('id', '', 'get', 'int')) {
			$videoid = JRequest::getvar('id', '', 'get', 'int');

                        if($videoid!=0){
                            $query = "UPDATE #__hdflv_upload SET times_viewed=1+times_viewed WHERE id=".$videoid;
					$db->setQuery($query);
					$db->query();
                        }

			if ($videoid != "") {
				$query = "SELECT distinct a.*,b.category
						  FROM #__hdflv_upload a 
						  LEFT JOIN #__hdflv_category b on a.playlistid=b.id 
						  WHERE a.published='1' and b.published='1' and a.id=$videoid ";
				$db->setQuery($query);
				$rows = $db->loadObjectList();
			}
			if(JRequest::getvar('catid', '', 'get', 'int')) {
				$videocategory = JRequest::getvar('catid', '', 'get', 'int');
			} else {
				$videocategory = $rows[0]->playlistid;
			}
			if (count($rows) > 0) {
				$where = "and b.id=" . $videocategory . " and a.id not in($videoid)";
				// $query="select distinct a.*,b.* from #__hdflv_upload a left join #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id  where a.published='1' $where group by a.id order by a.ordering asc";
				$query = "SELECT distinct a.*,b.category
						  FROM #__hdflv_upload a 
						  LEFT JOIN #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id 
						  WHERE a.published='1' and b.published='1' and b.id=" . $videocategory . " and a.id != $videoid";
				$db->setQuery($query);
				$playlist = $db->loadObjectList();
                                // Array rotation to autoplay the videos correctly
                                $arr1 = array();
                                $arr2 = array();
                                if(count($playlist) > 0){
                                    foreach($playlist as $r):
                                        if($r->id > $rows[0]->id){      //Storing greater values in an array
                                            $query = "SELECT distinct a.*,b.category
                                                      FROM #__hdflv_upload a 
                                                      LEFT JOIN #__hdflv_category b on a.playlistid=b.id 
                                                      WHERE a.published='1' and b.published='1' and a.id=$r->id ";
                                            $db->setQuery($query);
                                            $arrGreat = $db->loadObject();
                                            $arr1[] = $arrGreat;
                                        }else{                          //Storing lesser values in an array
                                            $query = "SELECT distinct a.*,b.category
                                                      FROM #__hdflv_upload a 
                                                      LEFT JOIN #__hdflv_category b on a.playlistid=b.id 
                                                      WHERE a.published='1' and b.published='1' and a.id=$r->id ";
                                            $db->setQuery($query);
                                            $arrLess = $db->loadObject();
                                            $arr2[] = $arrLess;
                                        }
                                    endforeach;
                                }
                                
                                $playlist = array_merge($arr1,$arr2);
                                
			}
		} else {
			$query = "SELECT a.*,b.category,d.username,e.*
					  FROM #__hdflv_upload a 
					  LEFT JOIN #__users d on a.memberid=d.id 
					  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
					  LEFT JOIN #__hdflv_category b on e.catid=b.id 
					  WHERE a.published='1' and b.published='1' and a.featured='1' and a.type='0'
					  GROUP BY e.vid 
					  ORDER BY a.ordering asc"; // Query is to display recent videos in home page
			$db->setQuery($query);
			$rs_video = $db->loadObjectList();
                         if (JRequest::getvar('featured', '', 'get', 'string') && !empty($rs_video)) {
			$featured = JRequest::getvar('featured', '', 'get', 'string');
                        if($featured=="true"){
                            $query = "UPDATE #__hdflv_upload SET times_viewed=1+times_viewed WHERE id=".$rs_video[0]->id;
					$db->setQuery($query);
					$db->query();
                        }
                        }
			if (count($rs_video) == 0) {
				$query = "SELECT a.*,b.category,d.username,e.* 
						  FROM  #__hdflv_upload a 
						  LEFT JOIN #__users d on a.memberid=d.id 
						  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
						  LEFT JOIN #__hdflv_category b on e.catid=b.id 
						  WHERE a.published='1' and b.published='1' and a.type='0'
						  GROUP BY e.vid 
						  ORDER BY a.ordering asc limit 0,1"; // Query is to display recent videos in home page
				$db->setQuery($query);
				$rs_video = $db->loadObjectList();
			}
		}

		if (isset($rows) && count($rows) > 0)
		$rs_video = array_merge($rows, $playlist);
		$qry_settings = "select playlist_autoplay,hddefault from #__hdflv_player_settings LIMIT 1";
		$db->setQuery($qry_settings);
		$rs_settings = $db->loadObjectList();
		if (count($rs_settings) > 0) {
			$playlistautoplay = ($rs_settings[0]->playlist_autoplay == 1) ? $playlistautoplay = "true" : $playlistautoplay = "false";
			$hddefault=($rs_settings[0]->hddefault);
		}
		$this->showxml($rs_video, $playlistautoplay,$hddefault);
	}

	function showxml($rs_video, $playlistautoplay,$hddefault) {
		$user = JFactory::getUser();
		$rows = $uid ='';
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$uid = $user->get('id');
			if ($uid) {
				$db = &JFactory::getDBO();
				$query = $db->getQuery(true);
				$query->select('g.id AS group_id')
				->from('#__usergroups AS g')
				->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
				->where('map.user_id = ' . (int) $uid);
				$db->setQuery($query);
				$message = $db->loadObjectList();
				foreach ($message as $mess) {
					$accessid[] = $mess->group_id;
				}
			} else {
				$accessid[] = 1;
			}
		} else {
			$accessid = $user->get('aid');
		}



		ob_clean();
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<playlist autoplay="' . $playlistautoplay . '">';
		$current_path = "components/com_contushdvideoshare/videos/";
		$hdvideo = "";
		//print_r($rs_video);
		if (count($rs_video) > 0) {
			foreach ($rs_video as $rows) {
				$timage = "";
				$streamername = "";
				if (version_compare(JVERSION, '1.6.0', 'ge')) {
					$db = JFactory::getDBO();
					$query = $db->getQuery(true);
					if($rows->useraccess == 0) $rows->useraccess = 1;
					$query->select('rules as rule')
					->from('#__viewlevels AS view')
					->where('id = ' . (int) $rows->useraccess);
					$db->setQuery($query);
					$message = $db->loadResult();
					$accessLevel = json_decode($message);
				}
				if ($rows->filepath == "File" || $rows->filepath == "FFmpeg") {
					if($hddefault == 0 && $rows->hdurl != '' )
					 {
					 	$video = '';
					 }
					 else{
					 	$video = JURI::base().$current_path.$rows->videourl;
					 }
					$video = JURI::base() . $current_path . $rows->videourl;
					($rows->hdurl != "") ? $hdvideo = JURI::base() . $current_path . $rows->hdurl : $hdvideo = "";
                                        if(!empty($rows->previewurl))
                                        $preview_image = $rows->previewurl;
                                        else
                                        $preview_image='default_preview.jpg';
					$previewimage = JURI::base() . $current_path . $preview_image;
					$timage = JURI::base() . $current_path . $rows->thumburl;
					if ($rows->hdurl)
					$hd_bol = "true";
					else
					$hd_bol="false";
				}
				elseif ($rows->filepath == "Url") {
					$video = $rows->videourl;
					//$video=$rows->protected_url;

                                        if(!empty($rows->previewurl))
					$previewimage = $rows->previewurl;
                                        else
                                         $previewimage = JURI::base() . $current_path . 'default_preview.jpg';
					$timage = $rows->thumburl;

					if ($rows->hdurl)
					$hd_bol = "true";
					else
					$hd_bol="false";
					$hdvideo = $rows->hdurl;
				}
				elseif ($rows->filepath == "Youtube") {
					$video = $rows->videourl;
					$regexwidth = '/\components\/(.*?)/i';

					$str2 = strstr($rows->previewurl, 'components');

					if ($str2 != "") {
						$previewimage = JURI::base() . $rows->previewurl;
						$timage = JURI::base() . $rows->thumburl;
					} else {
						$previewimage = $rows->previewurl;
						$timage = $rows->thumburl;
					}
					$hd_bol = "false";
					$hdvideo = "";
				}
				if($rows->streameroption == "lighttpd") { $streamername = $rows->streameroption; }
				if($rows->streameroption == "rtmp") { $streamername = $rows->streamerpath; }
				$db = JFactory::getDBO();
				$query_ads = "select * from #__hdflv_ads where published=1 and id=$rows->postrollid"; //and home=1";//and id=11;";
				$db->setQuery($query_ads);
				$rs_ads = $db->loadObjectList();
				if (count($rs_ads) > 0) {
					($rows->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
				} else {
					$postrollads = "false";
				}
				$query_ads = "select * from #__hdflv_ads where published=1 and id=$rows->prerollid"; //and home=1";//and id=11;";

				$db->setQuery($query_ads);
				$rs_ads = $db->loadObjectList();
				if (count($rs_ads) > 0) {
					($rows->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
				} else {
					$prerollads = "false";
				}
				$query_ads = "select * from #__hdflv_ads where published=1 and typeofadd='mid' "; //and home=1";//and id=11;";
				$db->setQuery($query_ads);
				$rs_ads = $db->loadObjectList();
				if (count($rs_ads) > 0) {
					($rows->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
				} else {
					$midrollads = "false";
				}

				($rows->download == 0) ? $download = "false" : $download = "true";
				$member = "true";

				if (version_compare(JVERSION, '1.6.0', 'ge')) {
					$member = "false";
					foreach ($accessLevel as $useracess) {
						if (in_array("$useracess", $accessid) || $useracess == 1) {
							$member = "true";
							break;
						}
					}
				} else {
					if ($rows->useraccess != 0) {
						if ($accessid != $rows->useraccess && $accessid != 2) {
							$member = "false";
						}
					}
				}
				$settingQuery="select seo_option from #__hdflv_site_settings";
                $db->setQuery($settingQuery);
                $resultSetting = $db->loadObjectList();
                $categoryQuery="select seo_category from #__hdflv_category WHERE id=$rows->playlistid";
                $db->setQuery($categoryQuery);
                $categorySeo = $db->loadObjectList();
                if($resultSetting[0]->seo_option == 1){
                    $fbCategoryVal = "category=" . $categorySeo[0]->seo_category;
                    $fbVideoVal = "video=" . $rows->seotitle;
                }else{
                    $fbCategoryVal = "catid=" . $rows->playlistid;
                    $fbVideoVal = "id=" . $rows->id;
                    }

                 $baseUrl=JURI::base();
 $baseUrl1=parse_url($baseUrl);
                 $baseUrl1=$baseUrl1['scheme'].'://'.$baseUrl1['host'];


                 $fbPath = $baseUrl1.JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$fbCategoryVal.'&'.$fbVideoVal);
                 //$fbPath = JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$fbCategoryVal.'&'.$fbVideoVal , false);
				
				($rows->targeturl == "") ? $targeturl = "" : $targeturl = $rows->targeturl;
				($rows->postrollads == "1") ? $postrollid = $rows->postrollid : $postrollid = 0;
				($rows->prerollads == "1") ? $prerollid = $rows->prerollid : $prerollid = 0;
				$title = $rows->title;
				$rate = $rows->rate;
				$ratecount = $rows->ratecount;
				$views = $rows->times_viewed;
				if ($rows->filepath == "Youtube") {
					$download = "false";
				}
				$islive = "false";
				$date = '';
				$date = date("m-d-Y", strtotime($rows->created_date));
				if ($streamername != "")
				($rows->islive==1)?$islive="true":$islive="false";
				$tags = $rows->tags;
				if (!preg_match('/vimeo/', $video)) {
					echo '<mainvideo member = "' . $member . '" uid="'.$uid.'" date="' . $date . '" rating="' . $rate . '" views="' . $views . '" ratecount="' . $ratecount . '" category="' . $rows->playlistid . '" url="' . $video . '" isLive ="' . $islive . '" allow_download="' . $download . '" preroll_id="' . $prerollid . '" midroll="' . $midrollads . '" postroll_id="' . $postrollid . '" postroll="' . $postrollads . '" preroll="' . $prerollads . '" streamer="' . $streamername . '" Preview="' . $previewimage . '" hdpath="' . $hdvideo . '" thu_image="' . $timage . '" id="' . $rows->id . '" hd="' . $hd_bol . '" tags="' . $tags . '" fbpath = "' . $fbPath . '" >';
					echo '<title>';
					echo '<![CDATA[' . $rows->title . ']]>';
					echo '</title>';
					echo '<tagline targeturl="' . $targeturl . '">';
					if ($rows->description != "") {
						echo '<![CDATA[' . $rows->description . ']]>';
					}
					echo '</tagline>';
					echo '</mainvideo>';
				}
			}
		}
		echo '</playlist>';
		exit();
	}
}