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
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * Category view class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class ContushdvideoshareViewcategory extends ContushdvideoshareView
{
	/**
	 * Function to set layout and model for view page.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   boolean  $urlparams  An array of safe url parameters and their variable types
	 *
	 * @return  ContushdvideoshareViewcategory		This object to support chaining.
	 * 
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();

		// Calling the function in models categoryview.php
		$getcategoryview = $model->getcategory();

		// Assigning reference for the results
		$this->assignRef('categoryview', $getcategoryview);
		$categorrowcol = $model->getcategoryrowcol();
		$this->assignRef('categoryrowcol', $categorrowcol);
		$getcategoryListVal = $model->getcategoryList();
		$this->assignRef('categoryList', $getcategoryListVal);
		$getplayersettings = $model->getplayersettings();
		$this->assignRef('player_values', $getplayersettings);
		$getcategoryid = $model->getcategoryid();
		$this->assignRef('getcategoryid', $getcategoryid);
		$homeAccessLevel = $model->getHTMLVideoAccessLevel();
		$this->assignRef('homepageaccess', $homeAccessLevel);
		parent::display();
	}
}
