<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2011 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   February 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Define DS
if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

require_once dirname(__FILE__) . DS . 'helper.php';
$document = JFactory::getDocument();

if (version_compare(JVERSION, '1.7.0', 'ge'))
{
	$version = '1.7';
}
elseif (version_compare(JVERSION, '1.6.0', 'ge'))
{
	$version = '1.6';
}
else
{
	$version = '1.5';
	$document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/tool_tip_15.css');
}

if (version_compare(JVERSION, '1.6.0', 'ge'))
{
	$jlang = JFactory::getLanguage();
	$jlang->load('mod_HDVideoSharePopular', JPATH_SITE, $jlang->get('tag'), true);
	$jlang->load('mod_HDVideoSharePopular', JPATH_SITE, null, true);
}

$class = $params->get('moduleclass_sfx');
$result = ModpopularVideos::getpopularVideos();
$result1 = ModpopularVideos::getpopularVideossettings();
require JModuleHelper::getLayoutPath('mod_HDVideoSharePopular');
