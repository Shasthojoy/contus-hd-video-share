<?php
/**
 * @name       HVS Article Plugin
 * @SVN        1.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2014 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   July 2013
 * @Modified Date   March 2014
 * */

/**
 * HVS Article Plugin installation class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class PlgContenthvsarticleInstallerScript
{
	/**
	 * Joomla installation hook for plugin
	 * 
	 * @param   string  $parent  parent value
	 * 
	 * @return  install
	 */
	public function install($parent)
	{
	}

	/**
	 * Joomla uninstallation hook for plugin
	 * 
	 * @param   string  $parent  parent value
	 * 
	 * @return  uninstall
	 */
	public function uninstall($parent)
	{
	}

	/**
	 * Joomla update hook for plugin
	 * 
	 * @param   string  $parent  parent value
	 * 
	 * @return  update
	 */
	public function update($parent)
	{
	}

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
	 * Joomla after installation hook for plugin
	 * 
	 * @param   string  $type    type
	 * @param   string  $parent  parent value
	 * 
	 * @return  postflight
	 */
	public function postflight($type, $parent)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		if (version_compare(JVERSION, '1.7.0', 'ge'))
		{
			$query->update($db->quoteName('#__extensions'))
					->set($db->quoteName('enabled') . ' = ' . $db->quote('1'))
					->where($db->quoteName('element') . ' = ' . $db->quote('hvsarticle'));
			$db->setQuery($query);
			$db->query();
		}
		elseif (version_compare(JVERSION, '1.6.0', 'ge'))
		{
			$query->update($db->quoteName('#__extensions'))
					->set($db->quoteName('enabled') . ' = ' . $db->quote('1'))
					->where($db->quoteName('element') . ' = ' . $db->quote('hvsarticle'));
			$db->setQuery($query);
			$db->query();
		}
		else
		{
			$query->update($db->quoteName('#__plugins'))
					->set($db->quoteName('enabled') . ' = ' . $db->quote('1'))
					->where($db->quoteName('element') . ' = ' . $db->quote('hvsarticle'));
			$db->setQuery($query);
			$db->query();
		}

		$root = JPATH_SITE;
		JFile::move($root . '/plugins/content/hvsarticle/hvsarticle.j3.xml', $root . '/plugins/content/hvsarticle/hvsarticle.xml');
	}
}
