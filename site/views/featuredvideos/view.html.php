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
 * @abstract      : Contushdvideoshare Component Featured Videos View
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
 * view class for the hdvideoshare featured videos
 */
class contushdvideoshareViewfeaturedvideos extends JView
{
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		/* function call for fetching featured videos */
		$featuredvideos = $model->getfeaturedvideos();
		$this->assignRef('featuredvideos', $featuredvideos);
		/* function call for fetching featured videos settings */
		$featurevideosrowcol = $model->getfeaturevideorowcol();
		$this->assignRef('featurevideosrowcol', $featurevideosrowcol);
		parent::display();
	}
}
?>