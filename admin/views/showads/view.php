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
 * @abstract      : Contushdvideoshare Component Showads View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// import joomla view library
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class contushdvideoshareViewshowads extends JView {

	//Function to manage ads
    function showads() {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
        JToolBarHelper::title(JText::_('Video Ads'), 'ads');
        JToolBarHelper::addNew('addads', 'New Ad');
        JToolBarHelper::editList('editads', 'Edit');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        if(JRequest::getVar('ads_status') == 3) {        	
        	JToolBarHelper::deleteList('', 'removeads', 'JTOOLBAR_EMPTY_TRASH');
        }else {
        JToolBarHelper::trash('trash');
        }
        $model = $this->getModel();
        $showads = $model->showadsmodel();
        $this->assignRef('showads', $showads);
        parent::display();
    }

}
?>   
