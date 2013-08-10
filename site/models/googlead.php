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
 * @abstract      : Contushdvideoshare Component Googlead Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Googlead Model
 */
class Modelcontushdvideosharegooglead extends JModel
{	
	function getgooglead()
	{
            global $db;
            $db = JFactory::getDBO();
            $query1 = "SELECT * FROM #__hdflv_googlead WHERE publish='1' and id='1'";
            $db->setQuery( $query1 );
            $fields = $db->loadObjectList();
            return  html_entity_decode(stripcslashes($fields[0]->code));

	}
}