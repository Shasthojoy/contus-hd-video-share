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
 * @abstract      : Contushdvideoshare Component Adminvideos View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// user access levels
jimport('joomla.access.access');
// import Joomla view library
jimport( 'joomla.application.component.view');

/**
 * hdvideoshare component administrator adminvideos view page
 *
 */ 
class contushdvideoshareViewadminvideos extends JView
{
	/**
	 * function to prepare view for adminvideos view
	 */ 
	function adminvideos()
	{
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
		if(JRequest::getVar('user','','get') && JRequest::getVar('user','','get') == 'admin')
		{
			JToolBarHelper::title( JText::_( 'Admin Videos' ),'adminvideos' );
		}
		else
		{
			JToolBarHelper::title( JText::_( 'Member Videos' ),'membervideos' );
		}
		JToolBarHelper::save('savevideos','Save');
		JToolBarHelper::apply('applyvideos','Apply');
		JToolBarHelper::cancel('CANCEL7','Cancel');
		$model = $this->getModel();
		$videoslist = $model->addvideosmodel();
		$this->assignRef('editvideo', $videoslist);
		parent::display();
	}
	
	/**
	 * function to prepare view for adminvideos edit page
	 */ 
	function editvideos()
	{
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
		if(JRequest::getVar('user','','get') && JRequest::getVar('user','','get') == 'admin')
		{
			JToolBarHelper::title( JText::_( 'Admin Videos' ),'adminvideos' );
		}
		else {
			JToolBarHelper::title( JText::_( 'Member Videos' ),'membervideos' );
		}
		JToolBarHelper::save('savevideos','Save');
		JToolBarHelper::apply('applyvideos','Apply');
		JToolBarHelper::cancel('CANCEL7','Cancel');
		$model = $this->getModel();
		$editvideoslist = $model->editvideosmodel();
		$this->assignRef('editvideo', $editvideoslist);
		parent::display();
	}
}
?>
