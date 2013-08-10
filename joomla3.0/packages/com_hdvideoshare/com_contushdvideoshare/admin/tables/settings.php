<?php
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Settings Table
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');
// table for settings
class Tablesettings extends JTable {
    var $id = null;
    var $published = null;
    var $buffer = null;
    var $normalscale = null;
    var $fullscreenscale = null;
    var $autoplay = null;
    var $volume = null;
    var $logoalign = null;
    var $logoalpha = null;
    var $skin_autohide = null;
    var $stagecolor = null;
    var $skin = null;
    var $embedpath = null;
    var $fullscreen = null;
    var $zoom = null;
    var $width = null;
    var $height = null;
    var $uploadmaxsize = null;
    var $ffmpeg = null;
    var $ffmpegpath = null;
    var $related_videos = null;
    var $timer = null;
    var $logopath = null;
    var $logourl = null;
    var $nrelated = null;
    var $shareurl = null;
    var $playlist_autoplay = null;
    var $hddefault = null;
    var $ads = null;
    var $prerollads = null;
    var $postrollads = null;
    var $random = null;
    var $midrollads = null;
    var $midbegin = null;
    var $midinterval = null;
    var $midrandom = null;
    var $midadrotate = null;
    var $playlist_open = null;
    var $licensekey = null;
    var $Youtubeapi = null;
    var $scaletologo = null;
    var $googleana_visible=null;
    var $googleanalyticsID = null;
    var $facebookapi = null;
    var $IMAAds_path = null;
    var $IMAAds = null;

    function __construct(&$db) {
        parent::__construct('#__hdflv_player_settings', 'id', $db);
    }
}
?>