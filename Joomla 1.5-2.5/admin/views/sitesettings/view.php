<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Sitesettings View Page
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport( 'joomla.application.component.view');
/**
 * Contushdvideoshare Component Administrator Sitesettings View
 */ 
class contushdvideoshareViewsitesettings extends JView
{
	/**
	 * function to prepare view for sitesettings 
	 */ 
    function display($cachable = false, $urlparams = false)
    {
        if(JRequest::getVar('task')=='edit' || JRequest::getVar('task')=='' )
        {
        	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
            JToolBarHelper::title(JText::_('Site Settings'),'sitesettings');
            JToolBarHelper::apply();
            $model = $this->getModel();            
            $setting = $model->getsitesetting();
            // assign data to the view
            $this->assignRef('sitesettings', $setting[0]);
            $this->assignRef('jomcomment', $setting[1]);
            $this->assignRef('jcomment', $setting[2]);
            // display the view
            parent::display();
        }
    }
}
?>
