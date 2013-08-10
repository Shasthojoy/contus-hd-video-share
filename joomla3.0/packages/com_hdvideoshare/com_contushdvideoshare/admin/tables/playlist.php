<?php
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Playlist Table
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class Tableplaylist extends JTable {
    var $id = null;
    var $category = null;
    var $seo_category = null;
    var $parent_id = null;
    var $ordering = null;
    var $published = null;
    var $member_id = null;

    function __construct(&$db) {
        parent::__construct('#__hdflv_category', 'id', $db);
    }	
}
?>