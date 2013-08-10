<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Configxml Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Configxml Model
 */
class Modelcontushdvideoshareconfigxml extends JModel {

    var $current_path = "/";
    var $base;

    /* function to get player settings */
    function configgetrecords() {
        $base = JURI::base();
        $this->$base = str_replace('components/com_contushdvideoshare/models/', '', $base);
        global $mainframe;        
        $db = JFactory::getDBO();
        $query = "SELECT `id`, `published`, `buffer`, `normalscale`, `fullscreenscale`, `autoplay`, `volume`, 
        		 `logoalign`, `logoalpha`, `skin_autohide`, `stagecolor`, `skin`, `embedpath`, `fullscreen`, 
        		 `zoom`, `width`, `height`, `uploadmaxsize`, `ffmpegpath`, `ffmpeg`, `related_videos`, `timer`, 
        		 `logopath`, `logourl`, `nrelated`, `shareurl`, `playlist_autoplay`, `hddefault`, `ads`, 
        		 `prerollads`, `postrollads`, `random`, `midrollads`, `midbegin`, `midinterval`, `midrandom`,
        		 `midadrotate`, `playlist_open`, `licensekey`, `vast`, `vast_pid`, `Youtubeapi`, `scaletologo`, 
        		 `googleanalyticsID`, `googleana_visible`,`IMAAds_path`, `IMAAds`
        		 FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows = $db->loadObjectList();        
        $this->configxml($settingsrows, $this->$base);
    }

    /* function to generate config xml */
    function configxml($settingsrows, $base) {
        global $mainframe;
                $googleanalyticsID=$IMAAds_path='';
        $skin = $base . "components/com_contushdvideoshare/hdflvplayer/skin/" . $settingsrows[0]->skin;
        $stagecolor = "0x" . $settingsrows[0]->stagecolor;
        
        ($settingsrows[0]->autoplay == 1) ? $autoplay = "true" : $autoplay = "false";
        ($settingsrows[0]->Youtubeapi == 1) ? $Youtubeapi = "flash" : $Youtubeapi = "php";
        ($settingsrows[0]->zoom == 1) ? $zoom = "true" : $zoom = "false";
        ($settingsrows[0]->fullscreen == 1) ? $fullscreen = "true" : $fullscreen = "false";
        ($settingsrows[0]->skin_autohide == 1) ? $skin_autohide = "true" : $skin_autohide = "false";
        ($settingsrows[0]->timer == 1) ? $timer = "true" : $timer = "false";
        ($settingsrows[0]->shareurl == 1) ? $share = "true" : $share = "false";
        ($settingsrows[0]->playlist_autoplay == 1) ? $playlist_autoplay = "true" : $playlist_autoplay = "false";
        ($settingsrows[0]->hddefault == 1) ? $hddefault = "true" : $hddefault = "false";
        ($settingsrows[0]->scaletologo == 1) ? $scaletologo = "true" : $scaletologo = "false";
                ($settingsrows[0]->googleana_visible == 1) ? $googleana_visible = "true" : $googleana_visible = "false";
        if($googleana_visible=="true")
            $googleanalyticsID=$settingsrows[0]->googleanalyticsID;
        $playlistxml = "";
        $playlist = "false";
        if ($settingsrows[0]->related_videos == "1" || $settingsrows[0]->related_videos == "3") {
            $playlist = "true";
        }
        $license = "";
        if ($settingsrows[0]->licensekey != '')
            $license = $settingsrows[0]->licensekey;
        else
            $license="";
        $buffer = $settingsrows[0]->buffer;
        $normalscale = $settingsrows[0]->normalscale;
        $fullscreenscale = $settingsrows[0]->fullscreenscale;
        $volume = $settingsrows[0]->volume;        
        $playlist_open = "false";
        $postrollads = "false";
        $prerollads = "false";
        $ads = "false";
        $vast = "false";
        $vast_pid = 0;
        ($settingsrows[0]->playlist_open == 1) ? $playlist_open = "true" : $playlist_open = "false";
        ($settingsrows[0]->postrollads == 0) ? $postrollads = "false" : $postrollads = "true";
        ($settingsrows[0]->prerollads == 0) ? $prerollads = "false" : $prerollads = "true";
        ($settingsrows[0]->midrollads == 0) ? $midrollads = "false" : $midrollads = "true";
        ($settingsrows[0]->ads == 0) ? $ads = "false" : $ads = "true";
        ($settingsrows[0]->vast == 0) ? $vast = "false" : $vast = "true";
                ($settingsrows[0]->IMAAds == 0) ? $IMAAds = "false" : $IMAAds = "true";
        if($IMAAds=="true")
            $IMAAds_path=$settingsrows[0]->IMAAds_path;
        $vast_pid = $settingsrows[0]->vast_pid;
        $playlistxml = $base . "components/com_contushdvideoshare/models/playxml.php";
                $downloadUrl = $base . "components/com_contushdvideoshare/hdflvplayer/download.php";
        if (JRequest::getVar('catid', '', 'get', 'int')) {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int') . "&catid=" . JRequest::getVar('catid', '', 'get', 'int');
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player";
        } elseif (JRequest::getVar('id', '', 'get', 'int')) {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int');
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player";
        } else {
            $playlistxml = $base . "index.php?option=com_contushdvideoshare&view=playxml&featured=true";
            $locaiton = $base . "index.php?option=com_contushdvideoshare&view=player";
        }
        $adsxml = JURI::base() . "index.php?option=com_contushdvideoshare&view=adsxml";
        $emailpath = $base . "components/com_contushdvideoshare/hdflvplayer/email.php";
        $logopath = $base . "components/com_contushdvideoshare/videos/" . $settingsrows[0]->logopath;
        $languagexml = $base . "index.php?option=com_contushdvideoshare&view=languagexml";
        $midrollxml = $base . "index.php?option=com_contushdvideoshare&view=midrollxml";
        $videoshareurl = $base . "index.php?option=com_contushdvideoshare&view=videourl";
        ob_clean();
        header("content-type:text/xml;charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<config
        license="' . $license . '"
        trackCode="' . $googleanalyticsID . '"
        IMAAds="' . $IMAAds . '"
        IMAadsXML="' . $IMAAds_path . '"
        autoplay="' . $autoplay . '"
        playlist_open="' . $playlist_open . '"
        buffer="' . $buffer . '"
        downloadUrl="' . $downloadUrl . '"
        normalscale="' . $normalscale . '"
        fullscreenscale="' . $fullscreenscale . '"
        logopath="' . $logopath . '"
        logo_target="' . $settingsrows[0]->logourl . '"
        logoalign="' . $settingsrows[0]->logoalign . '"
        Volume="' . $settingsrows[0]->volume . '"
        preroll_ads="' . $prerollads . '"
        midroll_ads="' . $midrollads . '"
        postroll_ads="' . $postrollads . '"
        HD_default="' . $hddefault . '"
        Download="true"
        logoalpha="' . $settingsrows[0]->logoalpha . '"
        skin_autohide="' . $skin_autohide . '"
        stagecolor="' . $stagecolor . '"
        skin="' . $skin . '"
        embed_visible="true"
        playlistXML="' . $playlistxml . '"
        adXML="' . $adsxml . '"
        midrollXML="' . $midrollxml . '"
        languageXML="' . $languagexml . '"
        debug="false"
        shareURL="' . $emailpath . '"
        videoshareURL="' . $videoshareurl . '"
        showPlaylist="' . $playlist . '"
        vast_partnerid="' . $vast_pid . '"
        vast="' . $vast . '"
        UseYouTubeApi="' . $Youtubeapi . '"
        scaleToHideLogo="' . $scaletologo . '"
        location="' . $locaiton . '">';
        echo '<timer>' . $timer . '</timer>';
        echo '<zoom>' . $zoom . '</zoom>';
        echo '<email>' . $share . '</email>';
        echo '<fullscreen>' . $fullscreen . '</fullscreen>';
        echo '</config>';
        exit();
    }

}
