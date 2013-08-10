<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Install Script File
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of Contus HD Video Share component
 */
class com_contushdvideoshareInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        $user = JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDBO();
        $groupname = 8;
        $db->setQuery("INSERT INTO `#__hdflv_upload` (`id`, `memberid`, `published`, `title`,`seotitle`, `featured`, `type`, `rate`, `ratecount`, `times_viewed`, `videos`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, `prerollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid`, `created_date`, `addedon`, `usergroupid`,`useraccess`,`islive`) VALUES
            (1, $userid, 1, 'Avatar Movie Trailer [HD]','Avatar-Movie-Trailer-[HD]', 1, 0, 9, 2, 3, '', 'Youtube', 'http://www.youtube.com/watch?v=d1_JBMrrYw8', 'http://img.youtube.com/vi/d1_JBMrrYw8/1.jpg', 'http://img.youtube.com/vi/d1_JBMrrYw8/0.jpg', '', 0, 9, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:06', '2010-06-28 16:26:39',$groupname,0,0),
            (2, $userid, 1, 'HD: Super Slo-mo Surfer! - South Pacific - BBC Two', 'HD-Super-Slo-mo-Surfer!-South-Pacific-BBC-Two',1, 0, 0, 0, 95, '', 'Youtube', 'http://www.youtube.com/watch?v=7BOhDaJH0m4', 'http://img.youtube.com/vi/7BOhDaJH0m4/1.jpg', 'http://img.youtube.com/vi/7BOhDaJH0m4/0.jpg', '', 0, 14, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:28', '2010-06-28 16:45:59',$groupname,0,0),
            (3, $userid, 1, 'Fatehpur Sikri, Taj Mahal - India (in HD)','Fatehpur-Sikri,-Taj-Mahal-India-(in HD)', 1, 0, 5, 1, 9, '', 'Youtube', 'http://www.youtube.com/watch?v=UNWROFjIwvQ', 'http://img.youtube.com/vi/UNWROFjIwvQ/1.jpg', 'http://img.youtube.com/vi/UNWROFjIwvQ/0.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:25', '2010-06-28 16:29:39',$groupname,0,0),
            (4, $userid, 1, 'East India Company (HD) PC Gameplay','East-India-Company-HD)-PC-Gameplay', 1, 0, 0, 0, 29, '', 'Youtube', 'http://www.youtube.com/watch?v=ASJjhChzkJM', 'http://img.youtube.com/vi/ASJjhChzkJM/1.jpg', 'http://img.youtube.com/vi/ASJjhChzkJM/0.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:57', '2010-06-28 17:09:46',$groupname,0,0),
            (5, $userid, 1, 'The Terminator Movie Trailer', 'The-Terminator-Movie-Trailer',1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=622AmVpUAsA', 'http://i3.ytimg.com/vi/622AmVpUAsA/default.jpg', 'http://img.youtube.com/vi/622AmVpUAsA/0.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:46', '2010-06-28 16:16:11',$groupname,0,0),
            (6, $userid, 1, 'Harry Potter and the Deathly Hallows Trailer Official HD','Harry-Potter-and-the-Deathly-Hallows-Trailer-Official-HD', 1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=_EC2tmFVNNE', 'http://img.youtube.com/vi/_EC2tmFVNNE/1.jpg', 'http://img.youtube.com/vi/_EC2tmFVNNE/0.jpg', '', 0, 11, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2011-01-24 06:01:26', '2011-01-24 11:31:26',$groupname,0,0);
            ");
        $db->query();
        $parent->getParent()->setRedirectURL('index.php?option=com_contushdvideoshare');
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {

    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {

    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {

        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
    }

}

