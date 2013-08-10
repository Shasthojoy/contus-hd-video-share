<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Video Upload View
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * hdvideoshare component videoupload view page
 *
 */
class contushdvideoshareViewvideoupload extends JViewLegacy
{
	/**
	 * function to prepare view for videoupload view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		//get category
		$category = $model->getupload();
		$this->assignRef('videocategory', $category[0]);
                $this->assignRef('upload', $category[1]);
                $this->assignRef('videodetails', $category[2]);                 
		parent::display();
	}
}
?>