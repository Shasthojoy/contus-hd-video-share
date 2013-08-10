<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Impressionclicks Model
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Impressionclicks Model
 */
class Modelcontushdvideoshareimpressionclicks extends JModelList {

	/* function to get & update the impression clicks to the Ads*/
    function impressionclicks() {
        global $mainframe;
        $db = JFactory::getDBO();
        $click = JRequest::getVar('click', 'get', '', 'string');
        $id = JRequest::getVar('id', 'get', '', 'int');
        if ($click != 'click') {
            $query = "UPDATE #__hdflv_ads SET clickcounts = clickcounts+1  WHERE `id` = $id";
        }
        else {
            $query = "UPDATE #__hdflv_ads SET impressioncounts= impressioncounts+1 WHERE `id` = $id";
        }
        $db->setQuery($query);
        $db->query();
        exit();
    }
}
?>
