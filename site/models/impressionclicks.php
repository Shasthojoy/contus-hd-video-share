<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Impressionclicks Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die();
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Impressionclicks Model
 */
class Modelcontushdvideoshareimpressionclicks extends JModel {

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
