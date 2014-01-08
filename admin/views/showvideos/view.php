<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.access.access');
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

## view class for the hdvideoshare showvideos 
class contushdvideoshareViewshowvideos extends ContushdvideoshareView {
	
    protected $canDo;
    
    ## function to prepare view for showvideos 
    function showvideos($cachable = false, $urlparams = false) {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );	
    	if (JRequest::getVar('page') != 'comment') {
           $model = $this->getModel();
           $showvideos = $model->showvideosmodel();
           $this->assignRef('videolist', $showvideos);
    	}
        if (JRequest::getVar('page') == 'comment') {
             $model = $this->getModel('showvideos');
            $comment = $model->getcomment();
            $this->assignRef('comment', $comment);
            parent::display();
        } else {
            parent::display();
        }
        $this->addToolbar();
    }
    
    ## Setting the toolbar
    protected function addToolBar()
    {
        if (JRequest::getVar('page') == 'comment') {
            JToolBarHelper::title('Comments');
        } else if(JRequest::getVar('user', '', 'get')) {
            JToolBarHelper::title(JText::_('Admin Videos'), 'adminvideos');
        } else {
            JToolBarHelper::title(JText::_('Member Videos'), 'membervideos');
        }
        if (version_compare(JVERSION, '1.5', '==')) {
            if (JRequest::getVar('page') != 'comment') {
                JToolBarHelper::addNew('addvideos', 'New Video');
                JToolBarHelper::editList('editvideos', 'Edit');
                if(JRequest::getVar('filter_state') == 3) {        	
                    JToolBarHelper::deleteList('', 'Removevideos', 'JTOOLBAR_EMPTY_TRASH');
                } else {  
                    JToolBarHelper::trash('trash');
                }
                JToolBarHelper::publishList();
                JToolBarHelper::unpublishList();
                JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
                JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);

            } else {
                JToolBarHelper::cancel('Commentcancel','Cancel');
            }
        } else {
            require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
            ## What Access Permissions does this user have? What can (s)he do?
            $this->canDo = ContushdvideoshareHelper::getActions();
            
            if (JRequest::getVar('page') != 'comment') {
                if ($this->canDo->get('core.create')) {
                    if(JRequest::getVar('user', '', 'get')) {
                        JToolBarHelper::addNew('addvideos', 'New Video');
                }
                }
                if ($this->canDo->get('core.edit')) {
                       JToolBarHelper::editList('editvideos', 'Edit');
                }
                if ($this->canDo->get('core.delete')) {
                        if(JRequest::getVar('filter_state') == 3) {        	
                            JToolBarHelper::deleteList('', 'Removevideos', 'JTOOLBAR_EMPTY_TRASH');
                        } else {  
                            JToolBarHelper::trash('trash');
                        }
                }
                if ($this->canDo->get('core.edit.state')) {
                        JToolBarHelper::publishList();
                        JToolBarHelper::unpublishList();
                        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
                        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);
                }
                if ($this->canDo->get('core.admin')) {
                        JToolBarHelper::divider();
                        JToolBarHelper::preferences('com_contushdvideoshare');
                }
            } else {
                JToolBarHelper::cancel('Commentcancel','Cancel');
            }
        }
        
    }
}
?>   