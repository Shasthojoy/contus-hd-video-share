<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component MyVideos View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct acesss
defined('_JEXEC') or die('Restricted access');
##  import Joomla view library
jimport('joomla.application.component.view');

## view class for the hdvideoshare myvideos

class contushdvideoshareViewmyvideos extends ContushdvideoshareView {

    function display($cachable = false, $urlparams = false) {
        $user               = JFactory::getUser();
        if ($user->get('id') == '') {
            $url            = $baseurl . "index.php?option=com_contushdvideoshare&view=player";
            header("Location: $url");
        } else {
            $model          = $this->getModel();
            $deletevideos   = $model->getmembervideo();                   ## function call for fetching member videos 
            $this->assignRef('deletevideos', $deletevideos['rows']);
            $this->assignRef('allowupload', $deletevideos['row1']);
            $myvideorowcol  = $model->getmyvideorowcol();                    ## function call for fetching my videos settings
            $this->assignRef('myvideorowcol', $myvideorowcol);
            parent::display();
        }
    }
}
?>