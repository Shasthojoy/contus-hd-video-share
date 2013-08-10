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
 * @abstract      : Contushdvideoshare Component Mychannel View Page
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
 * hdvideoshare component mychannel view page
 *
 */
class contushdvideoshareViewmychannel extends JView
{
	/**
	 * function to prepare view for my channel view
	 */
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		
		//get channel details
		$channelDetails = $model->getChanneldetails();
		$this->assignRef('channeldetails', $channelDetails);

                		//get channel Name if user doesn't have channel
		$Channelname = $model->getChannelname();
		$this->assignRef('channelname', $Channelname);

		//get total uploads
		$totalUploads = $model->getTotaluploads();
		$this->assignRef('totaluploads', $totalUploads);

		//update channel views
		$channelViews = $model->updateViews();

		//get channel settings
		$channelSettings = $model->channelSettings();
		$this->assignRef('channelvideorowcol', $channelSettings);

		//get front video details
		$frontVideodetails = $model->getfrontvideodetails();
		$this->assignRef('frontvideodetails', $frontVideodetails);

		//get other channels
		$otherChannels = $model->getOtherchannels();
		$this->assignRef('otherchannels', $otherChannels);
		
		//get channel id
		$channelId = $model->getChannel();
		$this->assignRef('channelId', $channelId);

		//get video id
		if(JRequest::getVar('title')) {
			$videoId = $model->getVideoid();
			$this->assignRef('videoid', $videoId);
		}

		//get home page settings
		$siteSettings = $model->gethomepagebottomsettings();
		$this->assignRef('sitesettings', $siteSettings);
		parent::display();
	}
}
?>