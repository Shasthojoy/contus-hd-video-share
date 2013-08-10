<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Administrator Player Settings Controller
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import joomla controller library
jimport('joomla.application.component.controller');

/**
 * Contushdvideoshare Component Administrator Player settings Controller
 */

class contushdvideoshareControllersettings extends JController {

	/**
	 * Function to display the player settings
	 */

	function display($cachable = false, $urlparams = false)
	{
		$viewName = JRequest::getVar('view', 'settings');
		$viewLayout = JRequest::getVar('layout', 'settings');
		$view = $this->getView($viewName);
		if ($model = $this->getModel('settings'))
		{
			$view->setModel($model, true);
		}
		$view->setLayout($viewLayout);
		$view->display();
	}

	/**
	 * Function to save player settings
	 */

	function apply()
	{
		$model = $this->getModel('settings');
		$model->saveplayersettings();
	}
}
?>
