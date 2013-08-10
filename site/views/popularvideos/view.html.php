<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Popular Videos View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * view class for the hdvideoshare popularvideos
 */
class contushdvideoshareViewpopularvideos extends JView
{
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		/* function call for fetching popular videos */
		$popularvideos = $model->getpopularvideos();
		$this->assignRef('popularvideos', $popularvideos);
		/* function call for fetching featured videos settings */
		$popularvideosrowcol = $model->getpopularvideorowcol();
		$this->assignRef('popularvideosrowcol', $popularvideosrowcol);
		parent::display();
	}
}
?>