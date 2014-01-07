<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import Joomla view library
jimport('joomla.application.component.view');

##  view class for the hdvideoshare component (Playersettings tab)

class contushdvideoshareViewsettings extends ContushdvideoshareView {

        protected $canDo;
	##  function to display settings
	function display($cachable = false, $urlparams = false) {
            JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
            $this->addToolbar();
            $model = $this->getModel();
            ## Function to get player settings
            $playersettings = $model->showplayersettings();
            $this->assignRef('playersettings', $playersettings);
            parent::display();
	}
        ## Setting the toolbar
        protected function addToolBar()
        {
            JToolBarHelper::title(JText::_('Player Settings'), 'settings');
            if (version_compare(JVERSION, '1.5', 'ge')) {
                JToolBarHelper::apply();
            } else {
                require_once JPATH_COMPONENT . '/helpers/contushdvideoshare.php';
                ## What Access Permissions does this user have? What can (s)he do?
                $this->canDo = ContushdvideoshareHelper::getActions();
                
                if ($this->canDo->get('core.admin'))
                {
                        JToolBarHelper::apply();
                        JToolBarHelper::divider();
                        JToolBarHelper::preferences('com_contushdvideoshare');
                }
            }
        }
}
?>
