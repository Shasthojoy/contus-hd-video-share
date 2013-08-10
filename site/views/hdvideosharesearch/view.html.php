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
 * @abstract      : Contushdvideoshare Component Hdvideoshare Search View
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
 * view class for the hdvideoshare search videos
 */
class contushdvideoshareViewhdvideosharesearch extends JView
{
function display($cachable = false, $urlparams = false)
	{
            $model = $this->getModel();
            /* function call for fetching search results */
            $search = $model->getsearch();
            $this->assignRef('search', $search);
            /* function call for fetching my videos settings */
            $searchrowcol = $model->getsearchrowcol();
            $this->assignRef('searchrowcol', $searchrowcol);
            parent::display();
	}
}
?>