<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Edit Channel View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * hdvideoshare component search channel view page
 *
 */
class contushdvideoshareViewsearchchannel extends JView
{
	/**
	 * function to prepare view for search channel view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		$searchValue = JRequest::getVar('other_channel');
		$applyChannel = JRequest::getVar('apply_channel');
		$deleteChannel = JRequest::getVar('delete_channel');
		//get channel availability
		$searchChannel = $model->searchChannel($searchValue);
		$this->assignRef('searchannel', $searchChannel);

		if(isset ($searchChannel[0])) {
			$searchChannelId = $searchChannel[0]->id;
			$checkAvailability = $model->checkAvailability($searchChannelId);
			$this->assignRef('searchannelid', $checkAvailability);
		}
		
		if(isset($applyChannel)){
			$insertChannel = $model->insertOtherchannel();
		}
		
		if(isset($deleteChannel)) {
			$deleteChannel = $model->deleteChannel();
		}
		parent::display();
	}
}
?>