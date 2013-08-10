<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Featured Videos Module
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
require_once( dirname(__FILE__) . DS . 'helper.php' );
$db =  JFactory::getDBO();
$document = JFactory::getDocument();
if(version_compare(JVERSION,'1.7.0','ge')) {
	$version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
	$version='1.6';
} else {
	$version='1.5';
        $document->addStyleSheet( JURI::base().'components/com_contushdvideoshare/css/tool_tip_15.css' );
}
if($version == '1.5'){
	if(!class_exists('JHtmlString')){
		JLoader::register('JHtmlString', JPATH_SITE.'/components/com_contushdvideoshare/string.php');
	}
}
if(version_compare(JVERSION,'1.6.0','ge')) {
	$jlang = JFactory::getLanguage();
        $jlang->load('mod_HDVideoShareFeatured', JPATH_SITE, $jlang->get('tag'), true);
        $jlang->load('mod_HDVideoShareFeatured', JPATH_SITE, null, true);
}
$class	= $params->get( 'moduleclass_sfx' );
$result = modfeaturedVideos::getfeaturedVideos();
$result1 = modfeaturedVideos::getfeaturedVideossettings();
require(JModuleHelper::getLayoutPath('mod_HDVideoShareFeatured'));
?>
