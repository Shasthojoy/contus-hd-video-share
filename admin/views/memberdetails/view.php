<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Memberdetails View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import Joomla view library
jimport('joomla.application.component.view');

class contushdvideoshareViewmemberdetails extends ContushdvideoshareView {
    
    protected $canDo;
    ## Function to manage member details
    function display($cachable = false, $urlparams = false) {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
        $this->addToolbar();
        $model = $this->getModel('memberdetails');
        $memberdetails = $model->getmemberdetails();
        $this->assignRef('memberdetails', $memberdetails);
        parent::display();
    }
    ## Setting the toolbar
    protected function addToolBar()
    {
        JToolBarHelper::title('Member Details', 'memberdetails');
        if (version_compare(JVERSION, '1.5', 'ge')) {
            JToolBarHelper::custom($task = 'allowupload', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable User upload', $listSelect = true);
            JToolBarHelper::custom($task = 'unallowupload', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable User upload', $listSelect = true);
            JToolBarHelper::publishList('publish', 'Active');
            JToolBarHelper::unpublishList('unpublish', 'Deactive');
        } else {
        require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
        ## What Access Permissions does this user have? What can (s)he do?
            $this->canDo = ContushdvideoshareHelper::getActions();
            if ($this->canDo->get('core.admin'))
            {
                JToolBarHelper::custom($task = 'allowupload', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable User upload', $listSelect = true);
                JToolBarHelper::custom($task = 'unallowupload', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable User upload', $listSelect = true);
                JToolBarHelper::publishList('publish', 'Active');
                JToolBarHelper::unpublishList('unpublish', 'Deactive');
                JToolBarHelper::divider();
                JToolBarHelper::preferences('com_contushdvideoshare');
            }
    }
}
}
?>