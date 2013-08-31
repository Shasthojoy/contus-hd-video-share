<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Channelsettings Table
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
/*
 ***********************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
// table for channelsettings
class Tablechannelsettings extends JTable {
    var $id = null;
    var $channel_id = null;
    var $player_width = null;
    var $player_height = null;
    var $video_row = null;
    var $video_colomn = null;
    var $recent_videos = null;
    var $popular_videos = null;
    var $top_videos = null;
    var $playlist = null;
    var $type=null;
    var $start_videotype=null;
    var $start_video=null;
    var $start_playlist=null;
    var $fb_comment=null;
    var $logo=null;
    

    function __construct(&$db) {
        parent::__construct('#__hdflv_channelsettings', 'id', $db);
    }
}
?>