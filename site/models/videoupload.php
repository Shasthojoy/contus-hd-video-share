<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Videoupload Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
##  No direct access to this file
defined('_JEXEC') or die('Restricted access');
##  import joomla model library
jimport('joomla.application.component.model');
## Import filesystem libraries.
jimport('joomla.filesystem.file');

## Contushdvideoshare Component Videoupload Model

class Modelcontushdvideosharevideoupload extends ContushdvideoshareModel {

    ## initializing constructor
    function __construct() {
        parent::__construct();
    }

    ##  function to display the category in the upload page
    function getupload() {
        $user = JFactory::getUser();
        $member_id = $user->get('id');
        $db = $this->getDBO();
        $value = $updateform = $streamerpath = $streameroption = $streamname = $url = $previewurl = $flv = $hd = $hq = $ftype = $success = $editvideo1 = "";
         $editvideo1 = "";
         $s3status = 0;
        $flagVideo = 1;
         $query = 'SELECT `dispenable` FROM #__hdflv_site_settings  WHERE `id` = 1';
		$db->setQuery($query);
		$setting_res = $db->loadResult();
                $dispenable = unserialize($setting_res);
 
        if(!version_compare(JVERSION, '3.0.0', 'ge'))
        $task_edit=JRequest::getVar('type', '', 'get', 'string');
        else
            $task_edit=JRequest::getVar('type');
            if ($task_edit == 'edit') {
                $video = JRequest::getVar('video');
            $id = JRequest::getInt('id');
            if (isset($video) && $video != "") {
                if ($flagVideo != 1) {
                    ##  joomla router replaced to : from - in query string
                    $videoTitle = JRequest::getString('video');
                    $videoid = str_replace(':', '-', $videoTitle);
                } else {
                    $videoid = JRequest::getInt('video');
                }
            } else if (isset($id) && $id != '') {
                $videoid = JRequest::getInt('id');
            }

            if ($flagVideo != 1) {
            $editvideo = "SELECT  a.`id`, a.`memberid`, a.`published`, a.`title`, a.`seotitle`, a.`islive`,
						 a.`featured`, a.`type`, a.`rate`, a.`ratecount`, a.`times_viewed`, a.`videos`, a.`filepath`,
						 a.`videourl`, a.`thumburl`, a.`previewurl`, a.`hdurl`, a.`home`, a.`playlistid`, a.`duration`,
						 a.`ordering`, a.`streamerpath`, a.`streameroption`, a.`postrollads`, a.`prerollads`,
						 a.`midrollads`,a.`description`, a.`targeturl`, a.`download`, a.`prerollid`, a.`postrollid`,
						 a.`created_date`,a.`addedon`, a.`usergroupid`, a.`tags`, a.`useraccess`,b.vid,b.catid,c.`id`,
						 c.`member_id`, c.`category`, c.`seo_category`, c.`parent_id`, c.`ordering`, c.`lft`, c.`rgt`,
						 c.`published`
						 FROM #__hdflv_upload a
             			 LEFT JOIN #__hdflv_video_category b ON a.id=b.vid
             			 LEFT JOIN #__hdflv_category c ON c.id=b.catid
             			 WHERE a.seotitle=" . $videoid;
           } else {
                $editvideo = "SELECT  a.`id`, a.`memberid`, a.`published`, a.`title`, a.`seotitle`, a.`islive`,
						 a.`featured`, a.`type`, a.`rate`, a.`ratecount`, a.`times_viewed`, a.`videos`, a.`filepath`,
						 a.`videourl`, a.`thumburl`, a.`previewurl`, a.`hdurl`, a.`home`, a.`playlistid`, a.`duration`,
						 a.`ordering`, a.`streamerpath`, a.`streameroption`, a.`postrollads`, a.`prerollads`,
						 a.`midrollads`,a.`description`, a.`targeturl`, a.`download`, a.`prerollid`, a.`postrollid`,
						 a.`created_date`,a.`addedon`, a.`usergroupid`, a.`tags`, a.`useraccess`,b.vid,b.catid,c.`id`,
						 c.`member_id`, c.`category`, c.`seo_category`, c.`parent_id`, c.`ordering`, c.`lft`, c.`rgt`,
						 c.`published`
						 FROM #__hdflv_upload a
             			 LEFT JOIN #__hdflv_video_category b ON a.id=b.vid
             			 LEFT JOIN #__hdflv_category c ON c.id=b.catid
             			 WHERE a.id=" . $videoid;
            }
            $db->setQuery($editvideo);
            $editvideo1 = $db->loadObjectList();
        }

                
                
        $url = "";
        $ftype = "";
        $success = "";
        $videourl = JRequest::getVar('videourl', '', 'post', 'string');
        $normalvideoformval = JRequest::getVar('normalvideoformval', '', 'post', 'string');
        $normalvideoforms3status = JRequest::getVar('normalvideoforms3status', '', 'post', 'string');
        $hdvideoforms3status = JRequest::getVar('hdvideoforms3status', '', 'post', 'string');
        $thumbimageforms3status = JRequest::getVar('thumbimageforms3status', '', 'post', 'string');
        $previewimageforms3status = JRequest::getVar('previewimageforms3status', '', 'post', 'string');
        $seltype = JRequest::getVar('seltype');
        if ($normalvideoforms3status == 1 || $hdvideoforms3status == 1 || $thumbimageforms3status == 1 || $previewimageforms3status == 1) {
                $s3status = 1;
            }
        
         if (JRequest::getVar('videotype') == 'edit') {
             
            if ($seltype == 0 || $seltype == 2 || $seltype == 3) {
                $normalvideoformval = '';
            }
        }
        $query = 'SELECT `id`, `member_id`, `category`, `seo_category`, `parent_id`, `ordering`, `lft`, `rgt`,
    			  `published`
    			  FROM #__hdflv_category
    			  WHERE published=1 AND (member_id = 0 OR member_id = ' . $member_id . ')
    			  ORDER BY category ASC';
        $db->setQuery($query);
        $category1 = $db->loadObjectList();
        if ($category1 === null)
            JError::raiseError(500, 'Category was empty');
        $flv = "";
        $hd = "";
        $img = "components/com_contushdvideoshare/images/default_thumb.jpg";
       if(version_compare(JVERSION, '3.0.0', 'ge')){
           $input = JFactory::getApplication()->input;
           $uploadbutton=$input->get('uploadbtn');
       }else{
           $uploadbutton=JRequest::getCmd('uploadbtn');
       }
         if ($uploadbutton) {
            if ($user->get('id')) {
                $memberid = $user->get('id'); ## Setting the loginid into session
            }
             if ($videourl == "1" || $normalvideoformval ) { ##  Checking for normal file type of videos
                if (strlen($normalvideoformval) > 0) {

                    $normalflv = substr($normalvideoformval, 16, strlen($normalvideoformval)); ##  Getting the normal video name
                    $flv = substr($normalflv, strrpos($normalflv, "/") + 1, strlen($normalflv));
                    $ftype = "File";
                    $url = $flv;
                } elseif (strlen(JRequest::getVar('ffmpeg', '', 'post', 'string')) > 0) {
                    $VPATH1 = JPATH_COMPONENT . '/videos/';
                    $EZFFMPEG_BIN_PATH = '/usr/bin/ffmpeg';
                    $path = substr(JRequest::getVar('ffmpeg', '', 'post', 'string'), 16, strlen(JRequest::getVar('ffmpeg', '', 'post', 'string'))); ##  Getting the normal video name
                    $filename = explode('.', $path);
                    $vpath = $VPATH1;
                    $destFile = $vpath . $path;
                    $target_path2 = $VPATH1 . $filename[0] . ".flv";
                    if ($filename[1] != "flv") {
                        exec($EZFFMPEG_BIN_PATH . ' ' . "-i" . ' ' . $destFile . ' ' . "-sameq" . ' ' . $target_path2 . '  2>&1');
                    }
                    $videofile = $destFile;
                    ob_start();
                    passthru("/usr/bin/ffmpeg -i \"{$videofile}\" 2>&1");
                    ob_end_clean();
                    $url = $filename[0] . ".flv";
                    $flv = $filename[0] . ".flv";
                    $hd = " "; ##  Getting Hd path
                    $hq = " "; ##  Getting Hq path
                    $img = $filename[0] . ".jpg"; ##  Getting thumb path
                    $ftype = "FFmpeg";
                }
                $hdvideo = substr(JRequest::getVar('hdvideoformval', '', 'post', 'string'), 16, strlen(JRequest::getVar('hdvideoformval', '', 'post', 'string'))); ##  Getting the hd video name
                $hd = substr($hdvideo, strrpos($hdvideo, "/") + 1, strlen($hdvideo));
                $thumimg = substr(JRequest::getVar('thumbimageformval', '', 'post', 'string'), 16, strlen(JRequest::getVar('thumbimageformval', '', 'post', 'string'))); ##  Getting the thumb image name
                $img = substr($thumimg, strrpos($thumimg, "/") + 1, strlen($thumimg));
                $previewimg = substr(JRequest::getVar('previewimageformval', '', 'post', 'string'), 16, strlen(JRequest::getVar('previewimageformval', '', 'post', 'string'))); ##  Getting the preview image name
                $previewurl = substr($previewimg, strrpos($previewimg, "/") + 1, strlen($previewimg));
            } else {                                                                        ##  checking condition for urls
                $flv            = JRequest::getVar('Youtubeurl', '', 'post', 'string');     ##  Getting Flv path
                $url            = $flv;
                $ftype          = "Url";
                $streamerpath   = $streamname = $updatestreamer = '';
                $streamname     = JRequest::getVar('streamname', '', 'post', 'string');
                $isLive         = JRequest::getVar('islive-value', '', 'post', 'string');
                if (!empty($streamname) && $seltype == 3) {
                    $streameroption     = "rtmp";
                    $streamerpath       = $streamname;
                    $updatestreamer     .= ",streamerpath='$streamname'";
                    $updatestreamer     .= ",streameroption='$streameroption'";
                    $updatestreamer     .= ",islive='$isLive'";
                }
                $hd             = JRequest::getVar('hdurl', '', 'post', 'string');          ##  Getting Hd path
                $hq             = JRequest::getVar('hq', '', 'post', 'string');             ##  Getting Hq path
                $img            = JRequest::getVar('thumburl', '', 'post', 'string');       ##  Getting Image path
                $uploadFile     = JRequest::getVar('thumburl', null, 'files', 'array');
                
                if ($uploadFile["name"] != "") {
                    $img = JURI::base() . "components/com_contushdvideoshare/videos/" . $uploadFile["name"];
                    $previewurl = JURI::base() . "components/com_contushdvideoshare/videos/" . $uploadFile["name"];

                        if ((($uploadFile["type"] == "image/gif") || ($uploadFile["type"] == "image/jpeg") || ($uploadFile["type"] == "image/png"))) {
                            move_uploaded_file($_FILES["thumburl"]["tmp_name"], "components/com_contushdvideoshare/videos/" . $_FILES["thumburl"]["name"]);
                        } else {
                            $img = JURI::base() . "components/com_contushdvideoshare/images/default_thumb.jpg";
                            $previewurl = JURI::base() . "components/com_contushdvideoshare/images/default_preview.jpg";
                        }
                    }
                    
                if ($img == "") {
                    if (strpos($url, 'youtube') > 0) {
                        $ftype = "Youtube";
                        $imgstr = explode("v=", $url);
                        $imgval = explode("&", $imgstr[1]);
                        $previewurl = "http://img.youtube.com/vi/" . $imgval[0] . "/maxresdefault.jpg";
                        $img = "http://img.youtube.com/vi/" . $imgval[0] . "/mqdefault.jpg";
                    } else if (strpos($url, 'youtu.be') > 0) {
                        $imgstr = explode("/", $url);
                        $previewurl = "http://img.youtube.com/vi/" . $imgstr[3] . "/maxresdefault.jpg";
                        $img = "http://img.youtube.com/vi/" . $imgstr[3] . "/mqdefault.jpg";
                        $url = "http://www.youtube.com/watch?v=" . $imgstr[3];
                        $ftype = "Youtube";
                    } else if (strpos($url, 'vimeo') > 0) {
                        $ftype = "Youtube";
                        $split = explode("/", $url);
                        if (ini_get('allow_url_fopen')) {
                            $doc = new DOMDocument();
                            $doc->load('http://vimeo.com/api/v2/video/' . $split[3] . '.xml');
                            $videotags = $doc->getElementsByTagName('video');
                            foreach ($videotags as $videotag) {
                                $imgnode = $videotag->getElementsByTagName('thumbnail_medium');
                                $img = $imgnode->item(0)->nodeValue;
                            }
                        } else {
                            $url = "http://vimeo.com/api/v2/video/" . $split[3] . ".xml";
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            $result = curl_exec($curl);
                            curl_close($curl);
                            $xml = simplexml_load_string($result);
                            $img = $xml->video->thumbnail_medium;
                        }
                    } else if(strpos($url,'dailymotion') > 0) {         ##  check video url is dailymotion
                        $split      = explode("/",$url);
                        $ftype      = "Youtube";
                        $split_id   = explode("_",$split[4]);
                        $img        = $previewurl = 'http://www.dailymotion.com/thumbnail/video/'.$split_id[0];
                    } else if(strpos($url,'viddler') > 0) {             ##  check video url is viddler
			$imgstr = explode("/", $url);
                        $ftype  = "Youtube";
			$img    = $previewurl = "http://cdn-thumbs.viddler.com/thumbnail_2_" . $imgstr[4] . "_v1.jpg";
                    } else {
                            $img = $this->imgURL($url);
                            $url1 = $this->catchURL($url);
                            $url = $url1[0];
                        }
                }
            }

            $gettitle           = JRequest::getVar('title', '', 'post', 'string');
            $title              = $db->quote($gettitle);
            $getdescription     = JRequest::getVar('description', '', 'post', 'string');
            $description        = $db->quote($getdescription);
            $gettagname         = JRequest::getVar('tagname', '', 'post', 'string');
            $tags               = JRequest::getVar('tags1', '', 'post', 'string');
            $type               = JRequest::getVar('type', '', 'post', 'string');
            if($type==1){
                $useraccess     = 2;
            } else {
                $useraccess     = 0;
            }
            $download           = JRequest::getVar('download', '', 'post');
            $db                 = JFactory::getDBO();
            $tagname1           = $gettagname;
            $split_tagname      = explode(',', $tagname1);
            $tagname            = implode(',', $split_tagname);
            $categoryquery      = "SELECT id FROM #__hdflv_category WHERE category IN('$tagname')";
            $db->setQuery($categoryquery);
            $result             = $db->LoadObjectList();
            foreach ($result as $category) {
                $cid = $category->id;
            }
            $cdate              = date("Y-m-d h:m:s");
            $value              = '';
            $updateform         = "";
            ## Code for seo option

            $set_seoTitle               = $title;
            $stripslash_seoTitle        = stripslashes($set_seoTitle);
            $lowercase_seoTitle         = strtolower($stripslash_seoTitle);
            $stripspace_seoTitle        = preg_replace('/[&:\s]+/i', '-', $lowercase_seoTitle);
            $strip_specialchrs_seoTitle = preg_replace('/[#!@$%^.,:;\/&*(){}\"\'\[\]<>|?]+/i', '', $stripspace_seoTitle);
            $seoTitle                   = preg_replace('/---|--+/i', '-', $strip_specialchrs_seoTitle);

            if(!version_compare(JVERSION, '3.0.0', 'ge')) {
                $videotype              = JRequest::getVar('videotype', '', 'post', 'string');
            } else {
                $videotype = JRequest::getVar('videotype');
            }
            if ($videotype == 'edit') {
                if ($ftype == '') {
                    if (JRequest::getVar('video_filetype', '', 'post', 'string')) {
                        $ftype          = JRequest::getVar('video_filetype', '', 'post', 'string');
                    }
                }
                if ($previewurl != '')
                    $updateform         .= ",previewurl='$previewurl'";
               else
                    $updateform         .= ",previewurl=''";
                if ($hd != '')
                    $updateform         .= ",hdurl='$hd'";
                else
                    $updateform         .= ",hdurl=''";
                if ($url != '')
                    $updateform         .= ",videourl='$url'";
                else
                    $updateform         .= ",videourl=''";
                if ($img != '')
                    $updateform         .= ",thumburl='$img'";
                else
                    $updateform         .= ",thumburl=''";
                if ($seltype == 0 || $seltype == 2 || $seltype == 1) {
                    $updatestreamer     .= ",streamerpath=''";
                    $updatestreamer     .= ",streameroption=''";
                }
                $query                  = 'UPDATE #__hdflv_upload SET filepath="' . $ftype . '",amazons3="'.$s3status.'", tags= "' . $tags . '",title=' . $title . ',seotitle="' . $seoTitle . '",useraccess="' . $useraccess . '",type="' . $type . '",download="' . $download . '",description=' . $description . $updateform . $updatestreamer . ' WHERE id=' . JRequest::getVar('videoid', '', 'post', 'int');
                $db->setQuery($query);
                $db->query();

                $deletecategory         = "DELETE FROM #__hdflv_video_category WHERE vid='" . JRequest::getVar('videoid', '', 'post', 'int') . "'";
                $db->setQuery($deletecategory);
                $db->query();
                $value                  = JRequest::getVar('videoid', '', 'post', 'int');
            } else {
                if ($previewurl == "") {
                    $previewurl         = $img;
                }
                $user                   = JFactory::getUser();
                $userid                 = $user->get('id');
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $query              = $db->getQuery(true);
                    $query->select('g.id AS group_id')
                            ->from('#__usergroups AS g')
                            ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                            ->where('map.user_id = ' . (int) $userid);
                    $db->setQuery($query);
                    $ugp                = $db->loadObject();
                } else {
                    $query              = 'SELECT gid AS group_id FROM #__users
                                            WHERE id = ' . (int) $userid;
                    $db->setQuery($query);
                    $ugp                = $db->loadObject();
                }

                $usergroup              = $ugp->group_id;
                if(isset($dispenable['adminapprove']) && $dispenable['adminapprove'] == 1) {
                    $adminapprove       = 0;
                } else {
                    $adminapprove       = 1;
                }
                $query                  = 'INSERT INTO #__hdflv_upload(islive,streamerpath,amazons3,streameroption,title,seotitle,filepath,videourl,thumburl,previewurl,published,
                                        type,memberid,description,created_date,addedon,usergroupid,playlistid,hdurl,tags,download,useraccess)
                                        VALUES ("' . $isLive . '","' . $streamerpath . '","'.$s3status.'","' . $streameroption . '",' . $title . ',"' . $seoTitle . '","' . $ftype . '","' . $url . '","' . $img . '","' . $previewurl . '",
                                        "'.$adminapprove.'","'.$type.'","' . $memberid . '",' . $description . ',"' . $cdate . '","' . $cdate . '","' . $usergroup . '",
                                        "' . $cid . '","' . $hd . '","' . $tags . '","' . $download . '","'.$useraccess.'")';
                $db->setQuery($query);
                $db->query();
                $db_insert_id           = $db->insertid();
                $value                  = $db_insert_id;
            }
                $cid                    = $category->id;
                $insertquery            = "INSERT INTO #__hdflv_video_category(vid,catid) VALUES ('$value','$cid')";
                $db->setQuery($insertquery);
                $db->query();
            if (count($result) > 0) {
                if ($videotype == 'edit') {
                    $insertquery        = "UPDATE #__hdflv_upload SET playlistid='" . $cid . "'
                			  WHERE id='" . JRequest::getVar('videoid', '', 'post', 'int') . "'";
                    $db->setQuery($insertquery);
                    $db->query();
                }
            }
            
            ## Alert admin regarding new video upload
            $mailer             = JFactory::getMailer(); ## define joomla mailer
            $config             = JFactory::getConfig();
            $query              = "SELECT d.email,d.username
                                FROM #__users d 
                                WHERE d.id = ".$memberid; ##  Query is to display recent videos in home page
            $db->setQuery($query);
            $user_details       = $db->loadObject();
            $sender             = $config->get('mailfrom');
            $mailer->setSender($user_details->email);
            $featureVideoVal    = "id=" . $value;
            $mailer->addRecipient($sender);
            $subject            = 'New video added by '.$user_details->username .' on your site.';
            $baseurl            = JURI::base();
            $video_url          = $baseurl.'index.php?option=com_contushdvideoshare&view=player&'. $featureVideoVal.'&adminview=true';
            $get_html_message   = file_get_contents($baseurl . '/components/com_contushdvideoshare/emailtemplate/membervideoupload.html');
            $update_baseurl     = str_replace("{baseurl}", $baseurl, $get_html_message);
            $update_username    = str_replace("{username}", $user_details->username, $update_baseurl);
            $message            = str_replace("{video_url}", $video_url, $update_username);
            $mailer->isHTML(true);
            $mailer->setSubject($subject);
            $mailer->Encoding = 'base64';
            $mailer->setBody($message);
            $mailer->Send();
            
            $success            = "Your video Uploaded Successfully";
            $url                = JRoute::_($baseurl . 'index.php?option=com_contushdvideoshare&view=myvideos');
            header("Location: $url");
        }
        return array($category1, $success, $editvideo1);
    }

    ## function to get ffmpeg video information
    function ezffmpeg_vdofile_infos($src_filepath) {
        $FLVTOOL_BIN_PATH                               = '/usr/bin/ffmpeg';
        $commandline                                    = $FLVTOOL_BIN_PATH . " -i " . $src_filepath;
        $exec_return                                    = $this->ezffmpeg_exec($commandline);
        $exec_return_content                            = explode("\n", $exec_return);
        $error_line_id                                  = $this->ezffmpeg_array_search('error', $exec_return_content);
        if ($error_line_id) {
            $error_line                                 = trim($exec_return_content[$error_line_id]);
            $return_array['status']                     = -1;
            $return_array['error_msg']                  = $error_line;
        } else {
            $return_array['status']                     = 1;
            $infos_line_id                              = $this->ezffmpeg_array_search('Duration:', $exec_return_content);
            if ($infos_line_id) {
                $infos_line                             = trim($exec_return_content[$infos_line_id]);
                $infos_cleaning                         = explode(': ', $infos_line);

                $infos_datas                            = explode(',', $infos_cleaning[1]);
                $return_array['vdo_duration_format']    = trim($infos_datas[0]);
                $return_array['vdo_duration_seconds']   = $this->ezffmpeg_common_time_to_seconds($return_array['vdo_duration_format']);

                $return_array['vdo_bitrate']            = trim($infos_cleaning[3]);
            }
            $infos_line_video_id                        = $this->ezffmpeg_array_search('Video:', $exec_return_content);
            if ($infos_line_video_id) {
                $infos_line                             = trim($exec_return_content[$infos_line_video_id]);
                $infos_cleaning                         = explode(': ', $infos_line);
            }
            $infos_line_audio_id                        = $this->ezffmpeg_array_search('Audio:', $exec_return_content);
            if ($infos_line_audio_id) {
                $infos_line                             = trim($exec_return_content[$infos_line_audio_id]);
                $infos_cleaning                         = explode(': ', $infos_line);
                $infos_datas                            = explode(',', $infos_cleaning[2]);
            }
        }
        return $return_array;
    }
    ## function to get seconds
    function ezffmpeg_common_time_to_seconds($timestamp) {
        $timestamp_datas            = explode(':', $timestamp);
        $nb_seconds                 = $timestamp_datas[2];
        $nb_minutes                 = $timestamp_datas[1];
        $nb_hours                   = $timestamp_datas[0];
        $return_val                 = ($nb_hours * 3600) + ($nb_minutes * 60) + $nb_seconds;
        return($return_val);
    }

    ## function to execute commands
    function ezffmpeg_exec($commandline) {
        $read           = '';
        $handle         = popen($commandline . ' 2>&1', 'r');
        while (!feof($handle)) {
            $read       .= fread($handle, 2096);
        }
        pclose($handle);
        return($read);
    }

    ## function to search ffmpeg value
    function ezffmpeg_array_search($needle, $array_lines) {
        $return_val         = false;
        reset($array_lines);
        foreach ($array_lines as $num_line => $line_content) {
            if (strpos($line_content, $needle) !== false) {
                return $num_line;
            }
        }
        return $return_val;
    }

    ##  function to get image from url (youtube,metacafe,etc.)
    function getVideoType($location, $add = 0) {
        if (preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $location, $vresult)) {
            $type = 'youtube';
        } elseif (preg_match('/http:\/\/(.*?)blip\.tv\/file\/[0-9]+/', $location, $vresult)) {
            $type = 'bliptv';
        } elseif (preg_match('/http:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/', $location, $vresult)) {
            $type = 'break';
        } elseif (preg_match('/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $location, $vresult)) {
            $type = 'metacafe';
        } elseif (preg_match('/http:\/\/video\.google\.com\/videoplay\?docid=[^&]+/', $location, $vresult)) {
            $type = 'google';
        } elseif (preg_match('/http:\/\/www\.dailymotion\.com\/video\/+/', $location, $vresult)) {
            $type = 'dailymotion';
            $vresult[0] = $location;
        }
        return $type;
    }

    ## function to get image from url (youtube,metacafe,etc.)
    function imgURL($url) {
        $type = $this->getVideoType($url);

        switch ($type) {
            case "youtube":
                $location_img_url   = str_replace('http://www.youtube.com/watch?v=', '', $this->url);
                $img                = 'http://img.youtube.com/vi/' . $location_img_url . '/1.jpg';
                break;
            case "bliptv":
                $contents           = trim($this->file_get_contents_curl($url));
                preg_match('/rel=\"image_src\" href=\"http:\/\/[^\"]+/', $contents, $result_img);
                preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                $img                = $result_img[0];
                break;
            case "break":
                $contents           = trim($this->file_get_contents_curl($url));
                preg_match('/meta name=\"embed_video_thumb_url\" content=\"http:\/\/[^\"]+/', $contents, $result_img);
                preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                $img                = $result_img[0];
                break;
            case "metacafe":
                $contents           = trim($this->file_get_contents_curl($url));
                preg_match('/thumb_image_src=http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $contents, $result_img);
                preg_match('/http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $result_img[0], $result_img);
                $img                = urldecode($result_img[0]);
                break;
            case "google":
                $contents           = trim($this->file_get_contents_curl($url));
                preg_match('/http:\/\/[0-9]\.(.*?)\.com\/ThumbnailServer2%3Fapp%3D(.*?)%26contentid%3D(.*?)%26offsetms%3D(.*?)%26itag%3D(.*?)%26hl%3D(.*?)%26sigh%3D[^\\\\]+/', $contents, $result);
                $img                = urldecode($result[0]);
                break;
            case "dailymotion":
                $contents           = trim($this->file_get_contents_curl($url));
                $img                = str_replace('www.dailymotion.com', 'www.dailymotion.com/thumbnail', $this->url);
                break;
            default:
                $img                = JURI::base() . "components/com_contushdvideoshare/images/default_thumb.jpg";
        }
        return $img;
    }

    ##  function to get conents from url
    function get_site_settings() {
        $db                 = $this->getDBO();
        $query              = 'SELECT `dispenable` FROM #__hdflv_site_settings  WHERE `id` = 1';
        $db->setQuery($query);
        $setting_res        = $db->loadResult();
        return $dispenable  = unserialize($setting_res);
    }
    ##  function to get conents from url
    function file_get_contents_curl($url) {
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data   = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    ##  function to save video from url
    function catchURL($url) {
        $type                       = $this->getVideoType($url);
        $vid_location               = array();
        $vid_location[0]            = $url;

        switch ($type) {
            case "bliptv":
                $newInfo            = trim($this->file_get_contents_curl($url));
                preg_match('/http:\/\/(.*?)blip\.tv\/file\/get\/(.*?)\.flv/', $newInfo, $result);
                $vid_location[0]    = urldecode($result[0]);
                break;

            case "break":
                $newInfo            = trim($this->file_get_contents_curl($url));
                preg_match('/sGlobalFileName=\'[^\']+/', $newInfo, $resulta);
                $resulta            = str_replace('sGlobalFileName=\'', '', $resulta[0]);
                preg_match('/sGlobalContentFilePath=\'[^\']+/', $newInfo, $resultb);
                $resultb            = str_replace('sGlobalContentFilePath=\'', '', $resultb[0]);
                $vid_location[0]    = 'http://media1.break.com/dnet/media/' . $resultb . '/' . $resulta . '.flv';
                break;

            case "metacafe":
                $newInfo            = trim($this->file_get_contents_curl($url));
                preg_match('/mediaURL=http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $newInfo, $result);
                preg_match('/http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $result[0], $result);
                $vid_location[0]    = urldecode(str_replace('&gdaKey', '?__gda__', $result[0]));
                break;

            case "google":
                $newInfo            = trim($this->file_get_contents_curl($url));
                preg_match('/http:\/\/(.*?)googlevideo.com\/videoplayback%3F[^\\\\]+/', $newInfo, $result);
                $vid_location[0]    = urldecode($result[0]);
                break;
            case "dailymotion":
                $newInfo            = trim($this->file_get_contents_curl($url));
                preg_match('/"video", "(.*?)"/', $newInfo, $result);
                $flv                = preg_split('/@@(.*?)\|\|/', urldecode($result[1]));
                $vid_location[0]    = $flv[0];
                break;
        }
        return $vid_location;
    }
}
?>