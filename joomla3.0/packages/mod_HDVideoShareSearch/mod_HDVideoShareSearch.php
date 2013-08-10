<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Search Module
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper.php' );
$db = JFactory::getDBO();
if(version_compare(JVERSION,'1.7.0','ge')) {
	$version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
	$version='1.6';
} else {
	$version='1.5';
}
if($version == '1.5'){
	if(!class_exists('JHtmlString')){
		JLoader::register('JHtmlString', JPATH_SITE.'/components/com_contushdvideoshare/string.php');
	}
}
if(version_compare(JVERSION,'1.6.0','ge')) {
	$jlang = JFactory::getLanguage();
        $jlang->load('mod_HDVideoShareSearch', JPATH_SITE, $jlang->get('tag'), true);
        $jlang->load('mod_HDVideoShareSearch', JPATH_SITE, null, true);
}
$class	= $params->get( 'moduleclass_sfx' );
$searchvideo = modsearchvideo::getsearchvideo();
require(JModuleHelper::getLayoutPath('mod_HDVideoShareSearch'));
?>
