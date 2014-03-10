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

// Import Joomla filesystem library
jimport('joomla.filesystem.folder');

// Import Joomla installer library
jimport('joomla.installer.installer');

// Import Joomla environment library
jimport('joomla.environment.uri');

/**
 * Featured Videos Module installer file
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Mod_HDVideoShareRandomInstallerScript
{
	/**
	 * Joomla before installation hook for plugin
	 * 
	 * @param   string  $type    type
	 * @param   string  $parent  parent value
	 * 
	 * @return  preflight
	 */
	public function preflight($type, $parent)
	{
	}

	/**
	 * Joomla installation hook for plugin
	 * 
	 * @param   string  $parent  parent value
	 * 
	 * @return  install
	 */
	public function install($parent)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->update($db->quoteName('#__modules'))
				->set($db->quoteName('published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('module') . ' = ' . $db->quote('mod_HDVideoShareRandom'));
		$db->setQuery($query);
		$db->query();

		$query->clear()
				->select('id')
				->from('#__modules')
				->where($db->quoteName('module') . ' = ' . $db->quote('mod_HDVideoShareRandom'));
		$db->setQuery($query);
		$db->query();
		$mid4 = $db->loadResult();

		$query->clear()
				->insert($db->quoteName('#__modules_menu'))
				->columns($db->quoteName('moduleid'))
				->values($db->quote($mid4));
		$db->setQuery($query);
		$db->query();
	}

	/**
	 * Joomla after installation hook for plugin
	 * 
	 * @param   string  $type    type
	 * @param   string  $parent  parent value
	 * 
	 * @return  postflight
	 */
	public function postflight($type, $parent)
	{
	}

	/**
	 * Joomla uninstallation hook for plugin
	 * 
	 * @return  uninstall
	 */
	public function uninstall()
	{
	}
}
