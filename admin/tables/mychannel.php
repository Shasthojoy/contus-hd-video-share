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
 * @abstract      : Contus HD Video Share Component Mychannel Table
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for mychannel
class Tablemychannel extends JTable {

    var $id = null;
    var $user_id = null;
    var $channel_name = null;
    var $description = null;
    var $about_me = null;
    var $tags = null;
    var $logo = null;
    var $website = null;
    var $country = null;
    var $channel_views = null;
    var $total_uploads=null;
    var $recent_activity=null;
    var $created_date=null;
    var $updated_date=null;    
    
    function __construct(&$db) {
        parent::__construct('#__hdflv_channel', 'id', $db);
    }
}
?>