<?php
/*
 * ********************************************************* */
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Installation File
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
/*
 * ********************************************************* */
/**
 * Description :    Installation file
 */
//No direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);
// Imports
jimport('joomla.installer.installer');
$installer = new JInstaller();
$upgra = '';

function AddColumnIfNotExists(&$errorMsg, $table, $column, $attributes = "INT( 11 ) NOT NULL DEFAULT '0'", $after = '') {
    $db = & JFactory::getDBO();
    $columnExists = false;
    $upgra = 'upgrade';
    $query = 'SHOW COLUMNS FROM ' . $table;

    $db->setQuery($query);
    if (!$result = $db->query()) {
        return false;
    }
    $columnData = $db->loadObjectList();
    foreach ($columnData as $valueColumn) {
        if ($valueColumn->Field == $column) {
            $columnExists = true;
            break;
        }
    }

    if (!$columnExists) {
        if ($after != '') {
            $query = 'ALTER TABLE ' . $db->nameQuote($table) . ' ADD ' . $db->nameQuote($column) . ' ' . $attributes . ' AFTER ' . $db->nameQuote($after) . ';';
        } else {
            $query = 'ALTER TABLE ' . $db->nameQuote($table) . ' ADD ' . $db->nameQuote($column) . ' ' . $attributes . ';';
        }
        $db->setQuery($query);
        if (!$result = $db->query()) {
            return false;
        }
        $errorMsg = 'notexistcreated';
    }

    return true;
}

function AddMebercolumn() {
    $db = & JFactory::getDBO();
    $query = 'ALTER TABLE `#__hdflv_upload` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL';
    $db->setQuery($query);
    $query = "alter TABLE #__hdflv_site_settings add (`featurwidth` int(11) DEFAULT '20',`recentwidth` int(11) DEFAULT '20',`categorywidth` int(11) DEFAULT '20',`popularwidth` int(11) DEFAULT '20',`searchwidth` int(11) DEFAULT '20',`relatedwidth` int(11) DEFAULT '20',`memberpagewidth` int(11) DEFAULT '20',`homepopularvideowidth` int(11) DEFAULT '20',`homefeaturedvideowidth` int(11) DEFAULT '20',`homerecentvideowidth` int(11) DEFAULT '20',`myvideowidth` int(11) DEFAULT '20')";
    $db->setQuery($query);
    if (!$result = $db->query()) {
        return false;
    }
    $query = 'ALTER TABLE `#__hdflv_user` DROP `id`';
    $db->setQuery($query);
    if (!$result = $db->query()) {
        return false;
    }
    $query = 'ALTER TABLE `#__hdflv_user` ADD PRIMARY KEY ( `member_id` )';
    $db->setQuery($query);
    if (!$result = $db->query()) {
        return false;
    }
}

// Install success. Joomla's module installer
// creates an additional module instance during
// upgrade. This seems to confuse users, so
// let's remove that now.
$db = &JFactory::getDBO();
$result = '';
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $query = ' SELECT * FROM ' . $db->nameQuote('#__extensions') . 'where type="component" and element="com_contushdvideoshare" LIMIT 1;';
    $db->setQuery($query);
    $result = $db->loadResult();
} else {
    $query = 'SELECT id FROM #__hdflv_player_settings ';
    $db->setQuery($query);
    //$db->setQuery("SELECT * FROM #__components where parent=0 and admin_menu_link ='option=com_contushdvideoshare' LIMIT 1;");
    $result = $db->loadResult();

    $query = 'UPDATE  #__components ' .
            'SET name = "Contus HD Video Share" ' .
            'WHERE name = "COM_HDVIDEOSHARE"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Member Videos" ' .
            'WHERE name = "COM_HDVIDEOSHARE_MEMBER_VIDEOS"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Member Details" ' .
            'WHERE name = "COM_HDVIDEOSHARE_MEMBER_DETAILS"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Admin Videos" ' .
            'WHERE name = "COM_HDVIDEOSHARE_ADMIN_VIDEOS"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Category" ' .
            'WHERE name = "COM_HDVIDEOSHARE_CATEGORY"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Player Settings" ' .
            'WHERE name = "COM_HDVIDEOSHARE_PLAYER_SETTINGS"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Site Settings" ' .
            'WHERE name = "COM_HDVIDEOSHARE_SITE_SETTINGS"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Google Adsense" ' .
            'WHERE name = "COM_HDVIDEOSHARE_GOOGLE_ADSENSE"';
    $db->setQuery($query);
    $db->query();

    $query = 'UPDATE  #__components ' .
            'SET name = "Video Ads" ' .
            'WHERE name = "COM_HDVIDEOSHARE_ADS"';
    $db->setQuery($query);
    $db->query();
}

if (empty($result)) {

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `adsname` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `postvideopath` varchar(255) NOT NULL,
  `home` int(11) NOT NULL,
  `targeturl` varchar(255) NOT NULL,
  `clickurl` varchar(255) NOT NULL,
  `impressionurl` varchar(255) NOT NULL,
  `impressioncounts` int(11) NOT NULL DEFAULT '0',
  `clickcounts` int(11) NOT NULL DEFAULT '0',
  `adsdesc` varchar(500) NOT NULL,
  `typeofadd` varchar(50) NOT NULL,
  `imaaddet` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `seo_category` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;");
    $db->query();

    $db->setQuery("INSERT INTO `#__hdflv_category` (`id`, `member_id`, `category`, `seo_category`, `parent_id`, `ordering`, `lft`, `rgt`, `published`) VALUES
(1, 0, 'Speeches', 'Speeches', 0, 1, 19, 20, 1),
(2, 0, 'Interviews', 'Interviews', 0, 2, 11, 12, 1),
(3, 0, 'Talk Shows', 'Talk-Shows-', 0, 3, 21, 22, 1),
(4, 0, 'News & Info', 'News-Info', 0, 4, 15, 16, 1),
(5, 0, 'Documentary', 'Documentary', 0, 5, 7, 8, 1),
(6, 0, 'Travel', 'Travel', 0, 6, 25, 26, 1),
(7, 0, 'Cooking', 'Cooking', 0, 7, 5, 6, 1),
(8, 0, 'Music', 'Music', 0, 8, 13, 14, 1),
(9, 0, 'Trailers', 'Trailers', 0, 9, 23, 24, 1),
(10, 0, 'Religious', 'Religious', 0, 10, 17, 18, 1),
(11, 0, 'TV Serials & Shows', 'TV-Serials-Shows', 0, 11, 27, 28, 1),
(12, 0, 'Greetings', 'Greetings', 0, 12, 9, 10, 1),
(13, 0, 'Comedy', 'Comedy', 0, 13, 3, 4, 1),
(14, 0, 'Actors', 'Actors', 0, 14, 1, 2, 1);");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_googlead` (
  `id` int(2) NOT NULL,
  `code` text NOT NULL,
  `showoption` tinyint(1) NOT NULL,
  `closeadd` int(6) NOT NULL,
  `reopenadd` tinytext NOT NULL,
  `publish` int(1) NOT NULL,
  `ropen` int(6) NOT NULL,
  `showaddc` tinyint(1) NOT NULL DEFAULT '0',
  `showaddm` tinyint(4) NOT NULL DEFAULT '0',
  `showaddp` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    $db->query();

    $db->setQuery("INSERT INTO `#__hdflv_googlead` (`id`, `code`, `showoption`, `closeadd`, `reopenadd`, `publish`, `ropen`, `showaddc`, `showaddm`, `showaddp`) VALUES
(1, '', 1, 10, '0', 0, 10, 0, '0', '0');");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_player_settings` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `player_colors` longtext NOT NULL,
  `player_icons` longtext NOT NULL,
  `player_values` longtext NOT NULL,
  `uploadmaxsize` int(10) NOT NULL,
  `logopath` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
    $db->query();
$player_colors= 'a:18:{s:21:"sharepanel_up_BgColor";s:0:"";s:23:"sharepanel_down_BgColor";s:0:"";s:19:"sharepaneltextColor";s:0:"";s:15:"sendButtonColor";s:0:"";s:19:"sendButtonTextColor";s:0:"";s:9:"textColor";s:0:"";s:11:"skinBgColor";s:0:"";s:13:"seek_barColor";s:0:"";s:15:"buffer_barColor";s:0:"";s:13:"skinIconColor";s:0:"";s:11:"pro_BgColor";s:0:"";s:15:"playButtonColor";s:0:"";s:17:"playButtonBgColor";s:0:"";s:17:"playerButtonColor";s:0:"";s:19:"playerButtonBgColor";s:0:"";s:19:"relatedVideoBgColor";s:0:"";s:15:"scroll_barColor";s:0:"";s:14:"scroll_BgColor";s:0:"";}';
$player_icons = 'a:27:{s:8:"autoplay";s:1:"1";s:17:"playlist_autoplay";s:1:"1";s:13:"playlist_open";s:1:"1";s:13:"skin_autohide";s:1:"1";s:10:"fullscreen";s:1:"1";s:4:"zoom";s:1:"1";s:5:"timer";s:1:"1";s:7:"showTag";s:1:"1";s:8:"shareurl";s:1:"1";s:11:"emailenable";s:1:"1";s:14:"login_page_url";s:17:"http://apptha.com";s:13:"volumevisible";N;s:12:"embedVisible";s:1:"1";s:15:"progressControl";s:1:"1";s:9:"hddefault";s:1:"1";s:12:"imageDefault";s:1:"1";s:14:"enabledownload";s:1:"1";s:10:"prerollads";s:1:"1";s:11:"postrollads";s:1:"0";s:6:"imaads";s:1:"1";s:13:"volumecontrol";s:1:"1";s:7:"adsSkip";s:1:"0";s:10:"midrollads";s:1:"0";s:8:"midbegin";s:1:"2";s:9:"midrandom";s:1:"0";s:11:"midadrotate";s:1:"0";s:17:"googleana_visible";s:1:"0";}';
$player_values = 'a:20:{s:6:"buffer";s:1:"3";s:5:"width";s:3:"600";s:6:"height";s:3:"400";s:11:"normalscale";s:1:"2";s:15:"fullscreenscale";s:1:"2";s:6:"volume";s:2:"50";s:8:"nrelated";i:8;s:10:"ffmpegpath";s:15:"/usr/bin/ffmpeg";s:10:"stagecolor";s:8:"0x000000";s:10:"licensekey";s:31:"SX3B-SL7VFIQ-WBCTIL6AWWIRCONTUS";s:7:"logourl";s:43:"http://stationfi.com/images/custom-logo.png";s:9:"logoalpha";s:3:"100";s:9:"logoalign";s:2:"BL";s:15:"adsSkipDuration";s:1:"3";s:17:"googleanalyticsID";s:0:"";s:8:"midbegin";s:1:"2";s:11:"midinterval";s:1:"1";s:14:"related_videos";s:1:"1";s:16:"relatedVideoView";s:4:"side";s:14:"login_page_url";s:17:"http://apptha.com";}';
    $db->setQuery("INSERT INTO `#__hdflv_player_settings` (`id`, `published`, `uploadmaxsize`, `logopath`, `player_colors`, `player_icons`, `player_values`) VALUES
(1, 1, 100, '', '$player_colors', '$player_icons', '$player_values');
");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `thumbview` longtext NOT NULL,
  `homethumbview` longtext NOT NULL,
  `homethumbview` longtext NOT NULL,
  `dispenable` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
    $db->query();
$homethumbview = 'a:15:{s:16:"homepopularvideo";s:1:"1";s:19:"homepopularvideorow";s:1:"1";s:19:"homepopularvideocol";s:1:"4";s:17:"homefeaturedvideo";s:1:"1";s:20:"homefeaturedvideorow";s:1:"1";s:20:"homefeaturedvideocol";s:1:"4";s:15:"homerecentvideo";s:1:"1";s:18:"homerecentvideorow";s:1:"1";s:18:"homerecentvideocol";s:1:"4";s:21:"homepopularvideoorder";s:1:"3";s:22:"homefeaturedvideoorder";s:1:"2";s:20:"homerecentvideoorder";s:1:"1";s:21:"homepopularvideowidth";s:2:"20";s:22:"homefeaturedvideowidth";s:2:"20";s:20:"homerecentvideowidth";s:2:"20";}';
$disenable = 'a:10:{s:11:"allowupload";s:1:"1";s:10:"user_login";s:1:"1";s:14:"ratingscontrol";s:1:"1";s:13:"viewedconrtol";s:1:"1";s:10:"seo_option";s:1:"1";s:17:"language_settings";s:11:"English.php";s:9:"disqusapi";s:15:"karthilocalhost";s:11:"facebookapi";s:0:"";s:7:"comment";s:1:"5";s:12:"facebooklike";s:1:"1";}';
$thumbview = 'a:24:{s:9:"featurrow";s:1:"3";s:9:"featurcol";s:1:"4";s:9:"recentrow";s:1:"3";s:9:"recentcol";s:1:"4";s:11:"categoryrow";s:1:"3";s:11:"categorycol";s:1:"4";s:10:"popularrow";s:1:"3";s:10:"popularcol";s:1:"4";s:9:"searchrow";s:1:"3";s:9:"searchcol";s:1:"4";s:10:"relatedrow";s:1:"3";s:10:"relatedcol";s:1:"4";s:11:"featurwidth";s:2:"20";s:11:"recentwidth";s:2:"20";s:13:"categorywidth";s:2:"20";s:12:"popularwidth";s:2:"20";s:11:"searchwidth";s:2:"20";s:12:"relatedwidth";s:2:"20";s:15:"memberpagewidth";s:2:"20";s:13:"memberpagerow";s:1:"3";s:13:"memberpagecol";s:1:"4";s:10:"myvideorow";s:1:"3";s:10:"myvideocol";s:1:"4";s:12:"myvideowidth";s:2:"20";}';
$sidethumbview = 'a:8:{s:19:"sidepopularvideorow";s:1:"1";s:19:"sidepopularvideocol";s:1:"4";s:20:"sidefeaturedvideorow";s:1:"1";s:20:"sidefeaturedvideocol";s:1:"4";s:19:"siderelatedvideorow";s:1:"1";s:19:"siderelatedvideocol";s:1:"4";s:18:"siderecentvideorow";s:1:"1";s:18:"siderecentvideocol";s:1:"4";}';
    $db->setQuery("INSERT INTO `jos_hdflv_site_settings` (`id`, `published`, `homethumbview`, `dispenable`, `thumbview`, `sidethumbview`) VALUES
(1, 1, '$homethumbview', '$disenable', '$thumbview', '$sidethumbview');");
    $db->query();


    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_upload` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `seotitle` varchar(255) CHARACTER SET utf8 NOT NULL,
  `featured` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `rate` int(11) NOT NULL,
  `ratecount` int(11) NOT NULL,
  `times_viewed` int(11) NOT NULL,
  `videos` varchar(255) CHARACTER SET utf8 NOT NULL,
  `filepath` varchar(10) CHARACTER SET utf8 NOT NULL,
  `videourl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `thumburl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `previewurl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `hdurl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `home` int(11) NOT NULL,
  `playlistid` int(11) NOT NULL,
  `duration` varchar(20) CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) NOT NULL,
  `streamerpath` varchar(255) CHARACTER SET utf8 NOT NULL,
  `streameroption` varchar(255) CHARACTER SET utf8 NOT NULL,
  `postrollads` tinyint(4) NOT NULL,
  `prerollads` tinyint(4) NOT NULL,
  `midrollads` tinyint(4) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `targeturl` varchar(255) CHARACTER SET utf8 NOT NULL,
  `download` tinyint(4) NOT NULL,
  `prerollid` int(11) NOT NULL,
  `postrollid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `addedon` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `usergroupid` varchar(250)CHARACTER SET utf8 NOT NULL,
  `tags` text CHARACTER SET utf8 NOT NULL,
  `useraccess` int(11) NOT NULL DEFAULT '0',
  `islive` tinyint(1) NOT NULL DEFAULT '0',
  `imaads` int(11) NOT NULL DEFAULT '0',
  `embedcode` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
    $db->query();
    if (version_compare(JVERSION, '1.6.0', 'ge')) {

        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $query = $db->getQuery(true);
        $query->select('g.id AS group_id')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $groupname = $ugp->group_id;
        $user = & JFactory::getUser();
        $userid = $user->get('id');
        $db->setQuery("INSERT INTO `#__hdflv_upload` (`id`, `memberid`, `published`, `title`,`seotitle`, `featured`, `type`, `rate`, `ratecount`, `times_viewed`, `videos`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, `prerollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid`, `created_date`, `addedon`, `usergroupid`,`useraccess`,`islive`,`imaads`,`embedcode`) VALUES
(1, $userid, 1, 'The Hobbit: The Desolation of Smaug International Trailer','The-Hobbit-The-Desolation-of-Smaug-International-Trailer', 1, 0, 9, 2, 3, '', 'Youtube', 'http://www.youtube.com/watch?v=TeGb5XGk2U0', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', '', 0, 9, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:06', '2010-06-28 16:26:39',$groupname,0,0,0,''),
(2, $userid, 1, 'Iron Man 3', 'Iron-Man-3',1, 0, 0, 0, 95, '', 'Youtube', 'http://www.youtube.com/watch?v=Ke1Y3P9D0Bc', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', '', 0, 14, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:28', '2010-06-28 16:45:59',$groupname,0,0,0,''),
(3, $userid, 1, 'GI JOE 2 Retaliation Trailer 2','GI-JOE-2-Retaliation-Trailer-2', 1, 0, 5, 1, 9, '', 'Youtube', 'http://www.youtube.com/watch?v=mKNpy-tGwxE', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:25', '2010-06-28 16:29:39',$groupname,0,0,0,''),
(4, $userid, 1, 'UP HD 1080p Trailer','UP-HD-1080p-Trailer', 1, 0, 0, 0, 29, '', 'Youtube', 'http://www.youtube.com/watch?v=1cRuA64m_lY', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:57', '2010-06-28 17:09:46',$groupname,0,0,0,''),
(5, $userid, 1, 'Chipwrecked: Survival Tips', 'Chipwrecked-Survival-Tips',1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=dLIEKGNYbVU', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:46', '2010-06-28 16:16:11',$groupname,0,0,0,''),
(6, $userid, 1, 'THE TWILIGHT SAGA: BREAKING DAWN PART 2','THE-TWILIGHT-SAGA-BREAKING-DAWN-PART-2', 1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=ey0aA3YY0Mo', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', '', 0, 11, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2011-01-24 06:01:26', '2011-01-24 11:31:26',$groupname,0,0,0,'');
");
        $db->query();


// Joomla! 1.7 code here
    } else {
        $groupname = '25';

        $db->setQuery("INSERT INTO `#__hdflv_upload` (`id`, `memberid`, `published`, `title`,`seotitle`, `featured`, `type`, `rate`, `ratecount`, `times_viewed`, `videos`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, `prerollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid`, `created_date`, `addedon`, `usergroupid`,`useraccess`,`islive`,`imaads`,`embedcode`) VALUES
(1, 62, 1, 'The Hobbit: The Desolation of Smaug International Trailer','The-Hobbit-The-Desolation-of-Smaug-International-Trailer', 1, 0, 9, 2, 3, '', 'Youtube', 'http://www.youtube.com/watch?v=TeGb5XGk2U0', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', '', 0, 9, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:06', '2010-06-28 16:26:39',$groupname,0,0,0,''),
(2, 62, 1, 'Iron Man 3', 'Iron-Man-3',1, 0, 0, 0, 95, '', 'Youtube', 'http://www.youtube.com/watch?v=Ke1Y3P9D0Bc', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', '', 0, 14, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:28', '2010-06-28 16:45:59',$groupname,0,0,0,''),
(3, 62, 1, 'GI JOE 2 Retaliation Trailer 2','GI-JOE-2-Retaliation-Trailer-2', 1, 0, 5, 1, 9, '', 'Youtube', 'http://www.youtube.com/watch?v=mKNpy-tGwxE', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:25', '2010-06-28 16:29:39',$groupname,0,0,0,''),
(4, 62, 1, 'UP HD 1080p Trailer','UP-HD-1080p-Trailer', 1, 0, 0, 0, 29, '', 'Youtube', 'http://www.youtube.com/watch?v=1cRuA64m_lY', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:57', '2010-06-28 17:09:46',$groupname,0,0,0,''),
(5, 62, 1, 'Chipwrecked: Survival Tips', 'Chipwrecked-Survival-Tips',1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=dLIEKGNYbVU', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:46', '2010-06-28 16:16:11',$groupname,0,0,0,''),
(6, 62, 1, 'THE TWILIGHT SAGA: BREAKING DAWN PART 2','THE-TWILIGHT-SAGA-BREAKING-DAWN-PART-2', 1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=ey0aA3YY0Mo', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', '', 0, 11, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2011-01-24 06:01:26', '2011-01-24 11:31:26',$groupname,0,0,0,'');
");
        $db->query();
    }
    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_user` (
  `member_id` int(11) NOT NULL,
  `allowupload` tinyint(4) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    $db->query();

    $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflv_video_category` (
  `vid` int(11) NOT NULL,
  `catid` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
    $db->query();

    $db->setQuery("INSERT INTO `#__hdflv_video_category` (`vid`, `catid`) VALUES
(1, '9'),
(2, '14'),
(3, '5'),
(4, '5'),
(5, '5'),
(6, '11');");
    $db->query();
} else {

    $upgra = 'upgrade';

    $db = JFactory::getDBO();
    $db->setQuery("ALTER TABLE  `#__hdflv_player_settings` ADD  `IMAAds_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                            ADD  `IMAAds` TINYINT( 4 ) NOT NULL");
    $db->query();
    $db->setQuery("ALTER TABLE  `#__hdflv_player_settings` ADD  `login_page_url` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
    $db->query();

    $updateDid = '';
    $updateDid = AddColumnIfNotExists($errorMsg, "#__hdflv_upload", "useraccess");

    $updateLive = AddColumnIfNotExists($errorMsg, "#__hdflv_upload", "islive", "TINYINT( 1 ) NOT NULL DEFAULT '0'");

    $updateDidface = AddColumnIfNotExists($errorMsg, "#__hdflv_site_settings", "facebookapi");

    $updateMid = AddColumnIfNotExists($errorMsg, "#__hdflv_category", "member_id");

    $updateGoogleAd = AddColumnIfNotExists($errorMsg, "#__hdflv_googlead", "showaddc", "TINYINT( 1 ) NOT NULL DEFAULT '0'");
    $updateGoogleAd1 = AddColumnIfNotExists($errorMsg, "#__hdflv_googlead", "showaddm", "TINYINT NOT NULL DEFAULT '0'");
    $updateGoogleAd2 = AddColumnIfNotExists($errorMsg, "#__hdflv_googlead", "showaddp", "TINYINT NOT NULL DEFAULT '0'");

    $updateCategory = AddColumnIfNotExists($errorMsg, "#__hdflv_category", "lft", "INT( 11 ) NOT NULL", "ordering");
    $updateCategory1 = AddColumnIfNotExists($errorMsg, "#__hdflv_category", "rgt", "INT( 11 ) NOT NULL", "lft");

    $hdflvUsertable = AddMebercolumn();

    if (!$updateDid) {
        $msgSQL .= "error adding 'playlist_autoplay' column to 'hdflvplayersettings' table <br />";
    }

    if (!$updateLive) {
        $msgSQL .= "error adding 'islive' column to 'hdflvupload' table <br />";
    }

    if (!$updateDidface) {
        $msgSQL .= "error adding 'facebookapi' column to 'hdflv_site_settings' table <br />";
    }

    if (!$updateMid) {
        $msgSQL .= "error adding 'member_id' column to 'category' table <br />";
    }

    if (!$updateGoogleAd || !$updateGoogleAd1 || !$updateGoogleAd2) {
        $msgSQL .= "error updating columns in 'googlead' table <br />";
    }

    if (!$updateCategory || !$updateCategory1) {
        $msgSQL .= "error adding columns in 'hdflv_category' table <br />";
    }
}
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoShareCategories');
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoShareFeatured');
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoSharePopular');
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoShareRecent');
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoShareRelated');
$installer->install($this->parent->getPath('source') . '/extensions/mod_HDVideoShareSearch');
$installer->install($this->parent->getPath('source') . '/extensions/hvsarticle');
if (version_compare(JVERSION, '1.5.0', 'ge')) {
    $componentPath = str_replace("com_installer", "com_contushdvideoshare", JPATH_COMPONENT_ADMINISTRATOR);
    if (file_exists($componentPath . '/admin.contushdvideoshare.php')) {
        unlink($componentPath . '/admin.contushdvideoshare.php');
    }
}
if (version_compare(JVERSION, '2.5.0', 'ge') || version_compare(JVERSION, '1.6.0', 'ge') || version_compare(JVERSION, '1.7.0', 'ge')) {
    if (file_exists($componentPath . '/contushdvideoshare.xml')) {
        unlink($componentPath . '/contushdvideoshare.xml');
    }
    if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }
    $root = str_replace('administrator' . DS, '', $componentPath);

    if (JFile::exists($root . DS . 'views' . DS . 'category' . DS . 'tmpl' . DS . 'default.j3.xml')) {
        JFile::delete($root . DS . 'views' . DS . 'category' . DS . 'tmpl' . DS . 'default.j3.xml');
    }

    $rootPath = str_replace("administrator" . DS . "components" . DS . "com_installer", "", JPATH_COMPONENT_ADMINISTRATOR);


    if (JFile::exists($rootPath . '/modules/mod_HDVideoShareCategories/mod_HDVideoShareCategories.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoShareCategories/mod_HDVideoShareCategories.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoShareCategories/mod_HDVideoShareCategories.j3.xml', $rootPath . '/modules/mod_HDVideoShareCategories/mod_HDVideoShareCategories.xml');

    if (JFile::exists($rootPath . '/modules/mod_HDVideoShareFeatured/mod_HDVideoShareFeatured.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoShareFeatured/mod_HDVideoShareFeatured.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoShareFeatured/mod_HDVideoShareFeatured.j3.xml', $rootPath . '/modules/mod_HDVideoShareFeatured/mod_HDVideoShareFeatured.xml');

    if (JFile::exists($rootPath . '/modules/mod_HDVideoSharePopular/mod_HDVideoSharePopular.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoSharePopular/mod_HDVideoSharePopular.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoSharePopular/mod_HDVideoSharePopular.j3.xml', $rootPath . '/modules/mod_HDVideoSharePopular/mod_HDVideoSharePopular.xml');

    if (JFile::exists($rootPath . '/modules/mod_HDVideoShareRecent/mod_HDVideoShareRecent.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoShareRecent/mod_HDVideoShareRecent.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoShareRecent/mod_HDVideoShareRecent.j3.xml', $rootPath . '/modules/mod_HDVideoShareRecent/mod_HDVideoShareRecent.xml');

    if (JFile::exists($rootPath . '/modules/mod_HDVideoShareRelated/mod_HDVideoShareRelated.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoShareRelated/mod_HDVideoShareRelated.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoShareRelated/mod_HDVideoShareRelated.j3.xml', $rootPath . '/modules/mod_HDVideoShareRelated/mod_HDVideoShareRelated.xml');

    if (JFile::exists($rootPath . '/modules/mod_HDVideoShareSearch/mod_HDVideoShareSearch.xml')) {
        JFile::delete($rootPath . '/modules/mod_HDVideoShareSearch/mod_HDVideoShareSearch.xml');
    }
    JFile::move($rootPath . '/modules/mod_HDVideoShareSearch/mod_HDVideoShareSearch.j3.xml', $rootPath . '/modules/mod_HDVideoShareSearch/mod_HDVideoShareSearch.xml');
    JFile::move($rootPath . '/plugins/content/hvsarticle/hvsarticle.j3.xml', $rootPath . '/plugins/content/hvsarticle/hvsarticle.xml');
}
?>

<div style="float: left;">
    <a href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank">
        <img src="components/com_contushdvideoshare/assets/contushdvideoshare-logo.png" alt="Joomla! HDVideoShare" align="left" />
    </a>
</div>
<div style="float:right;">
    <a href="http://www.apptha.com/" target="_blank">
        <img src="components/com_contushdvideoshare/assets/contus.jpg" alt="contus products" align="right" />
    </a>
</div>
<br><br>

<h2 align="center">HD Video Share Installation Status</h2>
<table class="adminlist">
    <thead>
        <tr>
            <th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
            <th><?php echo JText::_('Status'); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    <tbody>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo JText::_('HDVideoShare - Component'); ?></td>
            <td style="text-align: center;">
<?php
//check installed components
$db = JFactory::getDBO();
$db->setQuery("SELECT id FROM #__hdflv_player_settings LIMIT 1");
$id = $db->loadResult();
if ($id) {
    if ($upgra == 'upgrade') {
        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
    } else {
        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
    }
} else {
    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
}
?>
            </td>
        </tr>
        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Categories - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareCategories' LIMIT 1");
                }
                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD Video Share Featured - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareFeatured' LIMIT 1");
                }

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Related - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRelated' LIMIT 1");
                }

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD Video Share Popular - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoSharePopular' LIMIT 1");
                }

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Recent - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRecent' LIMIT 1");
                }

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>



        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD Video Share Search - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareSearch' LIMIT 1");
                }

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HVS Article Plugin - ' . JText::_('Plugin'); ?></td>
            <td style="text-align: center;">
<?php
if (version_compare(JVERSION, '1.6.0', 'ge')) {
        $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hvsarticle' AND folder = 'content' LIMIT 1");
} else {
        $db->setQuery("SELECT id FROM #__plugins WHERE element = 'hvsarticle' LIMIT 1");
}

                $id = $db->loadResult();
                if ($id) {
                    if ($upgra == 'upgrade') {
                        echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
                    } else {
                        echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                    }
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

    </tbody>
</table>