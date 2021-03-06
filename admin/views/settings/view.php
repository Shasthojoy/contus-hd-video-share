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

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * Admin settings view class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class ContushdvideoshareViewsettings extends ContushdvideoshareView
{
	protected $canDo;

	/**
	 * Function to view for manage categories
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   boolean  $urlparams  An array of safe url parameters and their variable types
	 *
	 * @return  ContushdvideoshareViewsettings		This object to support chaining.
	 * 
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		JHTML::stylesheet('styles.css', 'administrator/components/com_contushdvideoshare/css/');
		$this->addToolbar();
		$model = $this->getModel();

		// Function to get player settings
		$playersettings = $model->showplayersettings();
		$this->assignRef('playersettings', $playersettings);
		parent::display();
	}

	/**
	 * Function to Setting the toolbar
	 * 
	 * @return  addToolBar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('Player Settings'), 'settings');

		if (version_compare(JVERSION, '2.5.0', 'ge') || version_compare(JVERSION, '1.6', 'ge')
			|| version_compare(JVERSION, '1.7', 'ge') || version_compare(JVERSION, '3.0', 'ge'))
		{
			require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';

			// What Access Permissions does this user have? What can (s)he do?
			$this->canDo = ContushdvideoshareHelper::getActions();

			if ($this->canDo->get('core.admin'))
			{
				JToolBarHelper::apply();
				JToolBarHelper::divider();
				JToolBarHelper::preferences('com_contushdvideoshare');
			}
		}
		else
		{
			JToolBarHelper::apply();
		}
	}
}
