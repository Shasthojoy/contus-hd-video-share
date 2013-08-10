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
 * @abstract      : Contushdvideoshare Component Ads View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport( 'joomla.application.component.view');

/**
 * 
 *  view class for the hdvideoshare component (Ads tab)
 */

class contushdvideoshareViewads extends JView
{
	/**
	 * function to add ads
	 */
	function ads()
	{
        JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
        JToolBarHelper::title( JText::_( 'Video Ads' ),'ads');
        JToolBarHelper::save('saveads','Save & Close');
        JToolBarHelper::apply('applyads','Apply');
        JToolBarHelper::cancel('CANCEL6','Cancel');
        $model = $this->getModel();
        $adslist = $model->addadsmodel();
		$this->assignRef('adslist', $adslist);
		parent::display();
	}
	
	/**
	 * function to edit ads
	 */
	
    function editads()
	{
        JToolBarHelper::title( JText::_( 'Ads' ).': [<small>Edit</small>]');
        JToolBarHelper::save('saveads','Save & Close');
        JToolBarHelper::apply('applyads','Apply');
        JToolBarHelper::cancel('CANCEL6','Cancel');
        $model = $this->getModel();
        $editlist = $model->editadsmodel();
		$this->assignRef('adslist', $editlist);
		parent::display();
	}     
}
?>   
