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
 * @abstract      : Contushdvideoshare Component MyVideos View
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
 * view class for the hdvideoshare myvideos
 */
class contushdvideoshareViewmyvideos extends JView
{
function display($cachable = false, $urlparams = false)
	{
			$model = $this->getModel();
			/* function call for fetching member videos */
            $deletevideos = $model->getmembervideo();
            $this->assignRef('deletevideos', $deletevideos['rows']);
            $this->assignRef('allowupload', $deletevideos['row1']);
            /* function call for fetching my videos settings */
            $myvideorowcol = $model->getmyvideorowcol();
            $this->assignRef('myvideorowcol', $myvideorowcol);
            parent::display();
	}
}
?>