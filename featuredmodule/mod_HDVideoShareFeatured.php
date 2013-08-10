<?php
/*
* "Featured Videos Module for ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/

defined('_JEXEC') or die('Restricted access');
require_once( dirname(__FILE__).DS.'helper.php' );
 $db =& JFactory::getDBO();
 $class	= $params->get( 'moduleclass_sfx' );
          $query = "select 	language_settings from #__hdflv_site_settings ";//and id=2";
            $db->setQuery( $query );
            $rows = $db->loadObjectList();
            $class	= $params->get( 'moduleclass_sfx' );
require_once("components/com_contushdvideoshare/language/".$rows[0]->language_settings );
$result=modfeaturedVideos::getfeaturedVideos();
$result1=modfeaturedVideos::getfeaturedVideossettings();
require(JModuleHelper::getLayoutPath('mod_HDVideoShareFeatured'));

?>
