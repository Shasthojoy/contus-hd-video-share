CREATE TABLE IF NOT EXISTS `#__hdflv_ads` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__hdflv_category` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

INSERT INTO `#__hdflv_category` (`id`, `member_id`, `category`, `seo_category`, `parent_id`, `ordering`, `lft`, `rgt`, `published`) VALUES
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
(14, 0, 'Actors', 'Actors', 0, 14, 1, 2, 1);

CREATE TABLE IF NOT EXISTS `#__hdflv_comments` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `#__hdflv_googlead` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__hdflv_googlead` (`id`, `code`, `showoption`, `closeadd`, `reopenadd`, `publish`, `ropen`, `showaddc`, `showaddm`, `showaddp`) VALUES
(1, '', 1, 10, '0', 0, 10, 0, '0', '0');

CREATE TABLE IF NOT EXISTS `#__hdflv_player_settings` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `buffer` int(10) NOT NULL,
  `normalscale` varchar(100) NOT NULL,
  `fullscreenscale` varchar(100) NOT NULL,
  `autoplay` tinyint(1) NOT NULL,
  `volume` int(10) NOT NULL,
  `logoalign` varchar(10) NOT NULL,
  `logoalpha` int(50) NOT NULL,
  `skin_autohide` tinyint(2) NOT NULL,
  `stagecolor` varchar(20) NOT NULL,
  `skin` varchar(255) NOT NULL,
  `embedpath` varchar(50) NOT NULL,
  `fullscreen` tinyint(1) NOT NULL,
  `zoom` tinyint(1) NOT NULL,
  `width` int(20) NOT NULL,
  `height` int(20) NOT NULL DEFAULT '400',
  `uploadmaxsize` int(10) NOT NULL,
  `ffmpegpath` varchar(255) NOT NULL,
  `ffmpeg` varchar(20) NOT NULL,
  `related_videos` tinyint(1) NOT NULL,
  `timer` tinyint(1) NOT NULL,
  `logopath` varchar(255) NOT NULL,
  `logourl` varchar(255) NOT NULL,
  `nrelated` int(11) NOT NULL,
  `shareurl` tinyint(1) NOT NULL,
  `playlist_autoplay` int(11) NOT NULL,
  `hddefault` int(1) NOT NULL,
  `ads` tinyint(4) NOT NULL,
  `prerollads` tinyint(4) NOT NULL,
  `postrollads` tinyint(4) NOT NULL,
  `random` tinyint(4) NOT NULL,
  `midrollads` tinyint(4) NOT NULL,
  `midbegin` int(11) NOT NULL,
  `midinterval` int(11) NOT NULL,
  `midrandom` tinyint(4) NOT NULL,
  `midadrotate` tinyint(4) NOT NULL,
  `playlist_open` tinyint(4) NOT NULL,
  `licensekey` varchar(255) NOT NULL,
  `vast` tinyint(1) NOT NULL,
  `vast_pid` int(20) NOT NULL,
  `Youtubeapi` tinyint(1) NOT NULL DEFAULT '1',
  `scaletologo` tinyint(4) NOT NULL,
  `googleanalyticsID` text NOT NULL,
  `googleana_visible` tinyint(4) NOT NULL,
`login_page_url` text NOT NULL,
`IMAAds_path` text NOT NULL,
  `IMAAds` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `#__hdflv_player_settings` (`id`, `published`, `buffer`, `normalscale`, `fullscreenscale`, `autoplay`, `volume`, `logoalign`, `logoalpha`, `skin_autohide`, `stagecolor`, `skin`, `embedpath`, `fullscreen`, `zoom`, `width`, `height`, `uploadmaxsize`, `ffmpegpath`, `ffmpeg`, `related_videos`, `timer`, `logopath`, `logourl`, `nrelated`, `shareurl`, `playlist_autoplay`, `hddefault`, `ads`, `prerollads`, `postrollads`, `random`, `midrollads`, `midbegin`, `midinterval`, `midrandom`, `midadrotate`, `playlist_open`, `licensekey`, `vast`, `vast_pid`, `Youtubeapi`, `scaletologo`, `googleanalyticsID`, `googleana_visible`,`login_page_url`, `IMAAds_path`, `IMAAds`) VALUES
(1, 1, 15, '0', '0', 1, 34, 'TL', 35, 1, '000000', 'skin_black.swf', 'http://localhost/joomlatry/', 1, 1, 700, 475, 100, 'usr/bin/ffmpeg/', '0', 1, 1, '', 'http://www.hdvideoshare.net', 8, 1, 0, 1, 0, 1, 1, 0, 0, 1, 5, 0, 0, 1, '', 0, 0, 1, 1, '', 0, '', '', 0);

CREATE TABLE IF NOT EXISTS `#__hdflv_site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `seo_option` tinyint(4) NOT NULL,
  `facebooklike` tinyint(4) NOT NULL,
  `facebookapi` varchar(100) NOT NULL,
  `featurrow` int(5) NOT NULL DEFAULT '3',
  `featurcol` int(5) NOT NULL DEFAULT '3',
  `featurwidth` int(5) NOT NULL DEFAULT '3',
  `recentrow` int(5) NOT NULL DEFAULT '3',
  `recentcol` int(5) NOT NULL DEFAULT '4',
  `recentwidth` int(5) NOT NULL DEFAULT '3',
  `categoryrow` int(5) NOT NULL DEFAULT '3',
  `categorycol` int(5) NOT NULL DEFAULT '5',
  `categorywidth` int(5) NOT NULL DEFAULT '3',
  `popularrow` int(5) NOT NULL DEFAULT '3',
  `popularcol` int(5) NOT NULL DEFAULT '4',
  `popularwidth` int(5) NOT NULL DEFAULT '3',
  `searchrow` int(5) NOT NULL DEFAULT '3',
  `searchcol` int(5) NOT NULL DEFAULT '4',
  `searchwidth` int(5) NOT NULL DEFAULT '3',
  `relatedrow` int(5) NOT NULL DEFAULT '3',
  `relatedcol` int(5) NOT NULL DEFAULT '4',
  `relatedwidth` int(5) NOT NULL DEFAULT '3',
  `memberpagerow` int(5) NOT NULL DEFAULT '3',
  `memberpagecol` int(5) NOT NULL DEFAULT '4',
  `memberpagewidth` int(5) NOT NULL DEFAULT '3',
  `homepopularvideo` tinyint(4) NOT NULL DEFAULT '0',
  `homepopularvideorow` int(5) NOT NULL DEFAULT '2',
  `homepopularvideocol` int(5) NOT NULL DEFAULT '2',
  `homepopularvideowidth` int(5) NOT NULL DEFAULT '3',
  `homefeaturedvideo` tinyint(4) NOT NULL DEFAULT '1',
  `homefeaturedvideorow` int(5) NOT NULL DEFAULT '2',
  `homefeaturedvideocol` int(5) NOT NULL DEFAULT '2',
  `homefeaturedvideowidth` int(5) NOT NULL DEFAULT '3',
  `homerecentvideo` tinyint(4) NOT NULL DEFAULT '1',
  `homerecentvideorow` int(5) NOT NULL DEFAULT '2',
  `homerecentvideocol` int(5) NOT NULL DEFAULT '2',
  `homerecentvideowidth` int(5) NOT NULL DEFAULT '3',
  `myvideorow` int(5) NOT NULL DEFAULT '5',
  `myvideocol` int(5) NOT NULL DEFAULT '2',
  `myvideowidth` int(5) NOT NULL DEFAULT '3',
  `sidepopularvideorow` int(3) NOT NULL DEFAULT '3',
  `sidepopularvideocol` int(3) NOT NULL DEFAULT '1',
  `sidefeaturedvideorow` int(3) NOT NULL DEFAULT '3',
  `sidefeaturedvideocol` int(3) NOT NULL DEFAULT '1',
  `siderelatedvideorow` int(3) NOT NULL DEFAULT '3',
  `siderelatedvideocol` int(3) NOT NULL DEFAULT '1',
  `siderecentvideorow` int(3) NOT NULL DEFAULT '3',
  `siderecentvideocol` int(3) NOT NULL DEFAULT '1',
  `allowupload` tinyint(4) NOT NULL,
  `comment` int(2) NOT NULL DEFAULT '0',
  `language_settings` varchar(100) NOT NULL DEFAULT 'English.php',
  `homepopularvideoorder` int(2) NOT NULL DEFAULT '1',
  `homefeaturedvideoorder` int(2) NOT NULL DEFAULT '2',
  `homerecentvideoorder` int(2) NOT NULL DEFAULT '3',
  `user_login` int(2) NOT NULL DEFAULT '1',
`ratingscontrol` tinyint(4) NOT NULL,
`viewedconrtol` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `#__hdflv_site_settings` (`id`, `published`, `featurrow`, `featurcol`,`featurwidth`, `recentrow`, `recentcol`, `recentwidth`,`categoryrow`, `categorycol`,`categorywidth`, `popularrow`, `popularcol`,`popularwidth`, `searchrow`, `searchcol`,`searchwidth`, `relatedrow`, `relatedcol`,`relatedwidth`, `memberpagerow`, `memberpagecol`, `memberpagewidth`,`homepopularvideo`, `homepopularvideorow`, `homepopularvideocol`, `homepopularvideowidth`,`homefeaturedvideo`, `homefeaturedvideorow`, `homefeaturedvideocol`, `homefeaturedvideowidth`,`homerecentvideo`, `homerecentvideorow`, `homerecentvideocol`, `homerecentvideowidth`,`myvideorow`, `myvideocol`,`myvideowidth`, `sidepopularvideorow`, `sidepopularvideocol`, `sidefeaturedvideorow`, `sidefeaturedvideocol`, `siderelatedvideorow`, `siderelatedvideocol`, `siderecentvideorow`, `siderecentvideocol`, `allowupload`, `comment`, `language_settings`, `homepopularvideoorder`, `homefeaturedvideoorder`, `homerecentvideoorder`, `user_login`,`ratingscontrol`,`viewedconrtol`,`seo_option`,`facebooklike`,`facebookapi`) VALUES
(1, 1, 3, 4, 20, 3, 4, 20, 3, 4, 20, 3, 4, 20, 3, 4, 20, 3, 4, 20, 3, 4, 20, 1, 1, 4, 20, 1, 1, 4, 20, 1, 1, 4, 20, 4, 2, 20, 3, 1, 2, 1, 3, 1, 3, 1, 1, 1, 'English.php', 1, 2, 3, 1,1,1,0,0,'');

CREATE TABLE IF NOT EXISTS `#__hdflv_upload` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `#__hdflv_user` (
  `member_id` int(11) NOT NULL,
  `allowupload` tinyint(4) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hdflv_video_category` (
  `vid` int(11) NOT NULL,
  `catid` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `#__hdflv_video_category` (`vid`, `catid`) VALUES
(1, '9'),
(2, '14'),
(3, '5'),
(4, '5'),
(5, '5'),
(6, '11');