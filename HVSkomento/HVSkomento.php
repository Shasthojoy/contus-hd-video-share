<?php
/**
 * @name          : Joomla HVS Komento Plugin
 * @version	  : 1.0
 * @package       : Apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2013 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Joomla HVS Komento Plugin for Contus HD Video Share
 * @Creation Date : July 2013
 * @Modified Date : July 2013
 * */

## No direct acesss
defined('_JEXEC') or die('Restricted access');
## Include Joomla Library files for plugin
jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

class plgSystemHVSkomento extends JPlugin {

    public function __construct($subject, $config) {
        parent::__construct($subject, $config);
        $app = JFactory::getApplication();
        $options = JRequest::getVar("option");
        ## Avoid Loading language in Front end and for other components in Admin
        if ( $app->isAdmin() && $options == "com_komento" ) {
            $this->loadLanguage();
            ## Load Language file for HVS Komento Plugin
            $this->loadLanguage('plg_System_hvskomento', JPATH_ADMINISTRATOR);
        }
    }

    ## Method to load the komento js,css
    public function onAfterDispatch() {
        $app = JFactory::getApplication();
        if ($app->isSite())
            $this->getVideoDetails();
    }

    ## Method to display the komento comments after video player.
    public function onAfterRender() {

        $app = JFactory::getApplication();
        ## Avoid loading plugin in Admin
        if ($app->isSite()) {
            $komentoComments = $this->getVideoDetails();

            if ($komentoComments != "") {
                ## Get source code of the current page
                $buffer = JResponse::getBody();
                $pattern = '<div id="commentappended"';
                $replacement = $komentoComments . '<style type="text/css">body .kmt-notification{z-index: 999 !important;}</style><div id="commentappended"';
                $buffer = str_replace($pattern, $replacement, $buffer);
                ## Bind Komento comment before Commentappend id in HD Video Share component
                JResponse::setBody($buffer);
                return true;
            }
        }
    }

    ## Method to get current video details.
    public function getVideoDetails() {

        $video = $id = NULL;
        $options = JRequest::getVar("option");
        $view = JRequest::getVar("view");

        $video = JRequest::getVar('video');
        if ($video == "")
            $video = JRequest::getVar('id');

        $db = JFactory::getDbo();

        ## CODE FOR SEO OPTION
        $video = JRequest::getVar('video');
        $id = JRequest::getInt('id');
        $flagVideo = is_numeric($video);
        if ( isset( $video ) && $video != "" ) {
            if ( $flagVideo != 1 ) {
                ## Joomla router will replace : into - from query string
                $videoTitle = JRequest::getString('video');
                $video = str_replace(':', '-', $videoTitle);
                if (!empty($video)) {
                    ## Get video ID from video Title
                    $query = "SELECT a.id FROM #__hdflv_upload a WHERE a.published='1' AND a.seotitle='" . $video . "'";
                    $db->setQuery($query);
                    $videoid = $db->loadResult();
                }
            } else {
                $videoid = JRequest::getInt('video');
            }
        } else if ( isset( $id ) && $id != '' ) {
            $videoid = JRequest::getInt('id');
        }

        ## Check whether Commenting system is set to "None" in HD Video Share Site Settings.
        $db->setQuery('SELECT comment FROM #__hdflv_site_settings WHERE id=1');
        $comment_type = $db->loadResult();
        $instance = JURI::getInstance();

        if ( $comment_type == 0 && $options == "com_contushdvideoshare" && $view == "player" && $video != "" ) {

                $db->setQuery('SELECT a.id,a.title,a.times_viewed as hits,b.username as created_by,a.playlistid as catid
            			   FROM #__hdflv_upload a
            			   LEFT JOIN #__users b ON a.memberid=b.id
            			   WHERE a.id=' . $videoid);
                ## Fetch Video detail as an objecy and pass it to Komento
                $article = $db->loadObject();
                $options = array();
                ## Set current link as Permalink
                $article->permalink = $instance->toString();
                ## Include Komento library file
                require_once( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_komento' . DIRECTORY_SEPARATOR . 'bootstrap.php' );
                ## Load data in to Komento Commenting System
                $comments = Komento::commentify('com_contushdvideoshare', $article, $options);
                ## Return Komento result
                return $comments;
            }
        return;
    }

}

