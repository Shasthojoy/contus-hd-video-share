<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2014 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   March 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Define DS
if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

require_once dirname(__FILE__) . DS . 'helper.php';

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
}

$class = $params->get('moduleclass_sfx');

if (version_compare(JVERSION, '1.6.0', 'ge'))
{
	$jlang = JFactory::getLanguage();
	$jlang->load('com_contushdvideoshare', JPATH_SITE, 'en-GB', true);
	$jlang->load('com_contushdvideoshare', JPATH_SITE, null, true);
}

$result = Modcategorylist::getcategorylist();
$result_settings = Modcategorylist::getcategorysettings();
require JModuleHelper::getLayoutPath('mod_HDVideoShareCategories');
