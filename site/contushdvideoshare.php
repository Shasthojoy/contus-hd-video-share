<?php

/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/

defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT.DS.'controller.php' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_contushdvideoshare'.DS.'tables');
//define('VPATH1', realpath(dirname(__FILE__).'../../../../components/com_contushdvideoshare/videos') );
$controller = new contushdvideoshareController();

$controller->execute( JRequest::getVar('task') );



$controller->redirect();
?>