<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controller.php' );
$cache = JFactory::getCache('com_contusvideoshare');
$cache->clean();
date_default_timezone_set('UTC');
if(version_compare(JVERSION,'1.7.0','ge')) {
    $version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
    $version='1.6';
} else {
    $version='1.5';
}
if($version == '1.5'){
    JLoader::register('JHtmlString', JPATH_COMPONENT.'/string.php');
}
JTable::addIncludePath(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_contushdvideoshare'.DIRECTORY_SEPARATOR.'tables');
$controller = new contushdvideoshareController();
$controller->execute( JRequest::getVar('task') );
$controller->redirect();
?>