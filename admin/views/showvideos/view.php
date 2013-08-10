<?php

/*
 * "ContusHDVideoShare Component" - Version 1.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
// no direct access

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the backend of the details Component edit task
 *
 * @package    HelloWorld
 */
class contushdvideoshareViewshowvideos extends JView {

    function showvideos() {

        $user = & JFactory::getUser();

        JToolBarHelper::title(JText::_('Upload Videos'), 'generic.png');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);
        $userId = (JRequest::getVar('userid', '', 'get', 'int')) ? JRequest::getVar('userid', '', 'get', 'int') : 0;
        if (($user->usertype == "Super Administrator") && ($userId == 62) ||  ($userId == 0)) {
            JToolBarHelper::deleteList('', 'Removevideos');
            JToolBarHelper::editList('editvideos', 'Edit');
            if ( ((($user->usertype == "Administrator") || ($user->usertype == "Manager")) && ($userId == 0)) || (($user->usertype == "Super Administrator") && ($userId == 62)))
            {
            JToolBarHelper::addNew('addvideos', 'New Video');
            }
        }
        $model = $this->getModel();
        $showvideos = $model->showvideosmodel();

        $this->assignRef('videolist', $showvideos);
        if (JRequest::getVar('page') == 'comment') {
            JToolBarHelper::title('Commetn' . ': [<small>Edit</small>]');
            JToolBarHelper::cancel();
            $model = $this->getModel('showvideos');
            $comment = $model->getcomment();
            $this->assignRef('comment', $comment);
            parent::display();
        } else {
            parent::display();
        }
    }

}
?>   
