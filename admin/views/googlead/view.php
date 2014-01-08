<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Googlead View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import Joomla view library
jimport('joomla.application.component.view');
## Contushdvideoshare Component GoogleAd View

class contushdvideoshareViewgooglead extends ContushdvideoshareView {
	
        protected $canDo;
        ## Function to get google ad
	function display($cachable = false, $urlparams = false) {
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
                $this->addToolbar();
		$model = $this->getModel();		
		$googlead = $model->getgooglead();
		$this->assignRef('googlead', $googlead);
		parent::display();
	}
        ## Setting the toolbar
        protected function addToolBar()
        {
            JToolBarHelper::title(JText::_('Google AdSense'),'googlead');
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