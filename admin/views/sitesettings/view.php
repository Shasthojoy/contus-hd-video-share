<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Sitesettings View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
## import Joomla view library
jimport( 'joomla.application.component.view');
## Contushdvideoshare Component Administrator Sitesettings View

class contushdvideoshareViewsitesettings extends ContushdvideoshareView
{
     protected $canDo;
    ## function to prepare view for sitesettings 
    function display($cachable = false, $urlparams = false)
    {
        if(JRequest::getVar('task')=='edit' || JRequest::getVar('task')=='' )
        {
            JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
            $this->addToolbar();
            
            $model = $this->getModel();            
            $setting = $model->getsitesetting();
            ## assign data to the view
            $this->assignRef('sitesettings', $setting[0]);
            $this->assignRef('jomcomment', $setting[1]);
            $this->assignRef('jcomment', $setting[2]);
            ## display the view
            parent::display();
        }
    }
        ## Setting the toolbar
        protected function addToolBar()
        {
            JToolBarHelper::title(JText::_('Site Settings'),'sitesettings');
            if (version_compare(JVERSION, '2.5.0', 'ge') || version_compare(JVERSION, '1.6', 'ge') || version_compare(JVERSION, '1.7', 'ge') || version_compare(JVERSION, '3.0', 'ge')) {
                require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
                ## What Access Permissions does this user have? What can (s)he do?
                $this->canDo = ContushdvideoshareHelper::getActions();
                if ($this->canDo->get('core.admin'))
                {
                        JToolBarHelper::apply();
                        JToolBarHelper::divider();
                        JToolBarHelper::preferences('com_contushdvideoshare');
                }
                
                
            } else {
                JToolBarHelper::apply();
            }
                
        }
}
?>