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
 * @abstract      : Contushdvideoshare Component Googlead View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class contushdvideoshareViewmemberdetails extends JView {
//Function to manage member details
    function display($cachable = false, $urlparams = false) {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
        JToolBarHelper::title('Member Details', 'memberdetails');
        JToolBarHelper::custom($task = 'allowupload', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable User upload', $listSelect = true);
        JToolBarHelper::custom($task = 'unallowupload', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable User upload', $listSelect = true);
        JToolBarHelper::publishList('publish', 'Active');
        JToolBarHelper::unpublishList('unpublish', 'Deactive');
        $model = $this->getModel('memberdetails');
        $memberdetails = $model->getmemberdetails();
        $this->assignRef('memberdetails', $memberdetails);
        parent::display();
    }

}

?>