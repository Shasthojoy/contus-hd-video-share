<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
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
 * hdvideoshare component edit channel view page
 *
 */
class contushdvideoshareVieweditchannel extends JView
{
	/**
	 * function to prepare view for channel settings view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$data = JRequest::get( 'post' );
		$model = $this->getModel();
		if($data['function'] && $data['function'] == 'save') {
                        //function to check channel existance
                        $channelCheck = $model->checkChannelexistance();
                        if(!$channelCheck) {
			//save my channel
			$saveChannel = $model->saveChannel();
                        echo "<p style=\"color:green;\">Updated Successfully</p>";
                        } else {
                            echo "<p style=\"color:red;\">Channel name already exists</p>";
                        }
			//update recent activity
			$updateRecentactivity = $model->updateRecentActivity();
		}

		//get channel details
		$channelDetails = $model->getChanneldetails();
		$this->assignRef('channeldetails', $channelDetails);

		//get total uploads
		$totalUploads = $model->getTotaluploads();
		$this->assignRef('totaluploads', $totalUploads);

		//get myvideos
		$myVideos = $model->getMyvideos();
		$this->assignRef('myvideos', $myVideos);
		parent::display();
	}
}
?>