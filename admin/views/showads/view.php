<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showads View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access
defined('_JEXEC') or die('Restricted access');
## import joomla view library
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class contushdvideoshareViewshowads extends ContushdvideoshareView {

    protected $canDo;    
    ##Function to manage ads
    function showads() {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
        $this->addToolbar();
        $model = $this->getModel();
        $showads = $model->showadsmodel();
        $this->assignRef('showads', $showads);
        parent::display();
    }
    
    ## Setting the toolbar
    protected function addToolBar()
    {
        JToolBarHelper::title(JText::_('Video Ads'), 'ads');
        if (version_compare(JVERSION, '1.5', 'ge')) {
            JToolBarHelper::addNew('addads', 'New Ad');
            JToolBarHelper::editList('editads', 'Edit');
            if(JRequest::getVar('ads_status') == 3) {        	
                JToolBarHelper::deleteList('', 'removeads', 'JTOOLBAR_EMPTY_TRASH');
            } else {
                JToolBarHelper::trash('trash');
            }
            JToolBarHelper::publishList();
            JToolBarHelper::unpublishList();
        } else {
            require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
            ## What Access Permissions does this user have? What can (s)he do?
            $this->canDo = ContushdvideoshareHelper::getActions();
            if ($this->canDo->get('core.create'))
            {
                    JToolBarHelper::addNew('addads', 'New Ad');
            }
            if ($this->canDo->get('core.edit'))
            {
                   JToolBarHelper::editList('editads', 'Edit');
            }
            if ($this->canDo->get('core.delete'))
            {
                    if(JRequest::getVar('ads_status') == 3) {        	
                        JToolBarHelper::deleteList('', 'removeads', 'JTOOLBAR_EMPTY_TRASH');
                    } else {
                        JToolBarHelper::trash('trash');
                    }
            }
            if ($this->canDo->get('core.edit.state'))
            {
                    JToolBarHelper::publishList();
                    JToolBarHelper::unpublishList();
            }
            if ($this->canDo->get('core.admin'))
            {
                    JToolBarHelper::divider();
                    JToolBarHelper::preferences('com_contushdvideoshare');
            }
        }
    }
}
?>   