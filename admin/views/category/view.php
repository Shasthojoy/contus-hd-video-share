<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Category View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import Joomla view library
jimport('joomla.application.component.view');
## hdvideoshare component category administrator view
class contushdvideoshareViewcategory extends ContushdvideoshareView {

        protected $canDo;
	## view for manage categories
	function display($cachable = false, $urlparams = false) {
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
		if (JRequest::getVar('task') == 'edit') {
			JToolBarHelper::title('Category' . ': [<small>Edit</small>]','category');
			JToolBarHelper::save();
			JToolBarHelper::apply();
			JToolBarHelper::cancel();
			$model = $this->getModel();
			$id = JRequest::getVar('cid');
			$category = $model->getcategorydetails($id[0]);
			$this->assignRef('category', $category[0]);
			$this->assignRef('categorylist', $category[1]);
			parent::display();
		}
		if (JRequest::getVar('task') == 'add') { 
			JToolBarHelper::title('Category' . ': [<small>Add</small>]','category');
			JToolBarHelper::save();
			JToolBarHelper::cancel();
			$model = $this->getModel();
			$category = $model->getNewcategory();
			$this->assignRef('category', $category[0]);
			$this->assignRef('categorylist', $category[1]);
			parent::display();
		}
		if (JRequest::getVar('task') == '') {
                        $this->addToolbar();
			$model = $this->getModel('category');
			$category = $model->getcategory();
			$this->assignRef('category', $category);
			parent::display();
		}
	}
        ## Setting the toolbar
        protected function addToolBar()
        {
            if (version_compare(JVERSION, '1.5', '==')) {
                JToolBarHelper::addNew();
                JToolBarHelper::editList();
                if(JRequest::getVar('category_status') == 3) {        	
                    JToolBarHelper::deleteList('', 'remove', 'JTOOLBAR_EMPTY_TRASH');
                }else {			
                        JToolBarHelper::trash('trash');	
                }
                JToolBarHelper::publishList();
                JToolBarHelper::unpublishList();
            } else {
            require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
            ## What Access Permissions does this user have? What can (s)he do?
                $this->canDo = ContushdvideoshareHelper::getActions();
                JToolBarHelper::title('Category', 'category');
                if ($this->canDo->get('core.create')) {
                        JToolbarHelper::addNew();
                }
                    
                if ($this->canDo->get('core.edit')) {
                        JToolBarHelper::editList();
                }
                if ($this->canDo->get('core.delete')) {
                    if(JRequest::getVar('category_status') == 3) {        	
                        JToolBarHelper::deleteList('', 'remove', 'JTOOLBAR_EMPTY_TRASH');
                    }else {			
                            JToolBarHelper::trash('trash');	
                    }
                }
                if ($this->canDo->get('core.edit.state')) {   
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