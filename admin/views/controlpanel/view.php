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
 * @abstract      : Contushdvideoshare Component Controlpanel View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class contushdvideoshareViewcontrolpanel extends JView {
	// function to prepare controlpanel view
    function display($cachable = false, $urlparams = false) {
        if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '') {
            $model = $this->getModel();
            $controlpaneldetails = $model->controlpaneldetails();
            $this->assignRef('controlpaneldetails', $controlpaneldetails);
            parent::display();
        }
    }
}
?>
