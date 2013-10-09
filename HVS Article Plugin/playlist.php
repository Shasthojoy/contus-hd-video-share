<?php
/**
 * @name 	        HVS Article Plugin
 * @version	        1.0
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2013 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	HVS Article Plugin file.
 * @Creation Date	July 2013
 * @modified Date	July 2013
 */

## No direct access to this file
define('_JEXEC', 1);

$path = explode("plugins", dirname(__FILE__));
define('JPATH_BASE', $path[0]);
define('DS', DIRECTORY_SEPARATOR);

require_once ( JPATH_BASE .DS . 'configuration.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
$mainframe =& JFactory::getApplication('site');

$streamername = NULL;
$type = JRequest::getVar('type');
$order = $query = NULL;
switch ($type) {
    case 'rec':
        $order = "ORDER BY `id` DESC ";
        break;
    case 'fea':
        $query = "AND `featured`=1 ";
        break;
    case 'pop':
         $order = "ORDER BY `times_viewed` DESC ";
        break;
}

$db = JFactory::getDbo();

//Query to get video settings
$qry_settings = "SELECT playlist_autoplay, hddefault "
        . "FROM #__hdflv_player_settings "
        . "LIMIT 1";
$db->setQuery($qry_settings);
$settings = $db->loadObject();

//Query to get Video details
$query = "SELECT a.*, b.category, d.username,e.* "
        . "FROM #__hdflv_upload a "
        . "LEFT JOIN #__users d ON a.memberid=d.id "
        . "LEFT JOIN #__hdflv_video_category e ON e.vid=a.id "
        . "LEFT JOIN #__hdflv_category b ON e.catid=b.id "
        . "WHERE a.published='1' AND b.published='1' $query AND a.type='0'"
        . "GROUP BY e.vid "
        . $order;
$db->setQuery($query);
$records = $db->loadObjectList();

$accessid = getUserAccessId();


ob_clean();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<playlist autoplay="true">';
$current_path = "components/com_contushdvideoshare/videos/";
$user = JFactory::getUser();
$uid = $user->get('id');

foreach ($records as $record) {

    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        if ($record->useraccess == 0)
            $record->useraccess = 1;
        $db = JFactory::getDbo();
        $query = "SELECT rules FROM #__viewlevels "
                . " WHERE id = " . $record->useraccess;
        $db->setQuery($query);
        $message = $db->loadResult();
        $accessLevel = json_decode($message);
    }

    //To check video access for members
    $member = "true";
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        $member = "false";
        foreach ($accessLevel as $useracess) {

            if ( (is_array($useracess) && in_array("$useracess", $accessid)) || $useracess == 1) {
                $member = "true";
                break;
            }
        }
    } else {
        if ($record->useraccess != 0) {
            if ($accessid != $record->useraccess && $accessid != 2) {
                $member = "false";
            }
        }
    }
       
        
    //To get the video url
        
    if ($record->filepath == "File" || $record->filepath == "FFmpeg") {
        if ($hddefault == 0 && $record->hdurl != '') {
            $video = '';
        } else {
            $video = JURI::base() . $current_path . $record->videourl;
        }
        $video = JURI::base() . $current_path . $record->videourl;
        ($record->hdurl != "") ? $hdvideo = JURI::base() . $current_path . $record->hdurl : $hdvideo = "";
        if (!empty($record->previewurl))
            $preview_image = $record->previewurl;
        else
            $preview_image='default_preview.jpg';
        $previewimage = JURI::base() . $current_path . $preview_image;
        $timage = JURI::base() . $current_path . $record->thumburl;
        if ($record->hdurl)
            $hd_bol = "true";
        else
            $hd_bol="false";
    }
    elseif ($record->filepath == "Url") {
        $video = $record->videourl;
      
        if (!empty($record->previewurl))
            $previewimage = $record->previewurl;
        else
            $previewimage = JURI::base() . $current_path . 'default_preview.jpg';
        $timage = $record->thumburl;

        if ($record->hdurl)
            $hd_bol = "true";
        else
            $hd_bol="false";
        $hdvideo = $record->hdurl;
    }
    elseif ($record->filepath == "Youtube") {
        $video = $record->videourl;
        $regexwidth = '/\components\/(.*?)/i';

        $str2 = strstr($record->previewurl, 'components');

        if ($str2 != "") {
            $previewimage = JURI::base() . $record->previewurl;
            $timage = JURI::base() . $record->thumburl;
        } else {
            $previewimage = $record->previewurl;
            $timage = $record->thumburl;
        }
        $hd_bol = "false";
        $hdvideo = "";
    }
    $streamername = NULL;
    if ($record->streameroption == "lighttpd") {
        $streamername = $record->streameroption;
    }
    if ($record->streameroption == "rtmp") {
        $streamername = $record->streamerpath;
    }

    // To get the fb path
    
    $settingQuery = "select seo_option from #__hdflv_site_settings";
    $db->setQuery($settingQuery);
    $resultSetting = $db->loadObjectList();
    $categoryQuery = "select seo_category from #__hdflv_category WHERE id=$record->playlistid";
    $db->setQuery($categoryQuery);
    $categorySeo = $db->loadObjectList();
    if ($resultSetting[0]->seo_option == 1) {
        $fbCategoryVal = "category=" . $categorySeo[0]->seo_category;
        $fbVideoVal = "video=" . $record->seotitle;
    } else {
        $fbCategoryVal = "catid=" . $record->playlistid;
        $fbVideoVal = "id=" . $record->id;
    }
    $baseUrl = JURI::base();
    $baseUrl1 = parse_url($baseUrl);
    $baseUrl1 = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];
    $fbPath = $baseUrl1 . '/index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal;
    
    
// To get the ads details

    $query_ads = "select * from #__hdflv_ads where published=1 and id=$record->postrollid"; //and home=1";//and id=11;";
    $db->setQuery($query_ads);
    $rs_ads = $db->loadObjectList();
    if (count($rs_ads) > 0) {
        ($record->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
    } else {
        $postrollads = "false";
    }
    $query_ads = "select * from #__hdflv_ads where published=1 and id=$record->prerollid"; //and home=1";//and id=11;";

    $db->setQuery($query_ads);
    $rs_ads = $db->loadObjectList();
    if (count($rs_ads) > 0) {
        ($record->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
    } else {
        $prerollads = "false";
    }
    $query_ads = "select * from #__hdflv_ads where published=1 and typeofadd='mid' "; //and home=1";//and id=11;";
    $db->setQuery($query_ads);
    $rs_ads = $db->loadObjectList();
    if (count($rs_ads) > 0) {
        ($record->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
    } else {
        $midrollads = "false";
    }

    ($record->targeturl == "") ? $targeturl = "" : $targeturl = $record->targeturl;
    ($record->postrollads == "1") ? $postrollid = $record->postrollid : $postrollid = 0;
    ($record->prerollads == "1") ? $prerollid = $record->prerollid : $prerollid = 0;
    
    // To get the other values

    $islive = "false";
    $date = '';
    $date = date("m-d-Y", strtotime($record->created_date));
    $category =$record->playlistid;
    $rate = $record->rate;
    if ($record->filepath == "Youtube") {
        $download = "false";
    }
    $islive = "false";
    if ($streamername != "")
        ($record->islive == 1) ? $islive = "true" : $islive = "false";
    $ratecount = $record->ratecount;
    $views = $record->times_viewed;
    $tags = $record->tags;
    if ($streamername != "")
        ($record->islive == 1) ? $islive = "true" : $islive = "false";
    $tags = $record->tags;
    
    
    
    echo '<mainvideo member = "' . $member . '" uid="' . $uid . '" date="' . $date . '" rating="' . $rate . '" views="' . $views . '" ratecount="' . $ratecount . '" category="' .  $category . '" url="' . $video . '" isLive ="' . $islive . '" allow_download="' . $download . '" preroll_id="' . $prerollid . '" midroll="' . $midrollads . '" postroll_id="' . $postrollid . '" postroll="' . $postrollads . '" preroll="' . $prerollads . '" streamer="' . $streamername . '" Preview="' . $previewimage . '" hdpath="' . $hdvideo . '" thu_image="' . $timage . '" id="' . $record->id . '" hd="' . $hd_bol . '" tags="' . $tags . '" fbpath = "' . $fbPath . '" >';
    echo '<title>';
    echo '<![CDATA[' . $record->title . ']]>';
    echo '</title>';
    echo '<tagline targeturl="' . $targeturl . '">';
    if ($record->description != "") {
        echo '<![CDATA[' . $record->description . ']]>';
    }
    echo '</tagline>';
    echo '</mainvideo>';
}
echo "</playlist>";
exit;

function getUserAccessId() {
    $user = JFactory::getUser();
    $uid = '';
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
}
?>
