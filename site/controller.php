<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2014 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   March 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla controller library
jimport('joomla.application.component.controller');

// HD Video Share component main controller
if (version_compare(JVERSION, '1.6.0', 'ge'))
{
	$jlang = JFactory::getLanguage();
	$jlang->load('com_contushdvideoshare', JPATH_SITE, $jlang->get('tag'), true);
	$jlang->load('com_contushdvideoshare', JPATH_SITE, null, true);
}

/**
 * Featured Videos Module installer file
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class ContushdvideoshareController extends ContusvideoshareController
{
	/**
	 * Function to set layout and model for view page.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   boolean  $urlparams  An array of safe url parameters and their variable types
	 *
	 * @return  ContushdvideoshareController		This object to support chaining.
	 * 
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('dispenable')
				->from('#__hdflv_site_settings')
				->where($db->quoteName('published') . ' = ' . $db->quote('1'));
		$db->setQuery($query);
		$rows = $db->loadResult();
		$dispenable = unserialize($rows);
		define('USER_LOGIN', $dispenable['user_login']);
		$viewName = JRequest::getVar('view');

		if ($viewName != "languagexml" && $viewName != "configxml" && $viewName != "playxml" && $viewName != "googlead")
		{
			$document = JFactory::getDocument();
			$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/jquery.js');
			$document->addScript(JURI::base() . "components/com_contushdvideoshare/js/htmltooltip.js");
			$lang = JFactory::getLanguage();
			$langDirection = (bool) $lang->isRTL();

			if ($langDirection == 1)
			{
				$document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/stylesheet_rtl.css');
			}
			else
			{
				$document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css');
			}
		}

		if ($viewName == "" || $viewName == "index")
		{
			$viewName = 'player';
		}

		$this->getdisplay($viewName);
	}

	/**
	 * Function to increase view count of a video
	 * 
	 * @param   int  $vid  Video id
	 * 
	 * @return  videohitCount_function
	 */
	public static function videohitCount_function($vid)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->clear()
				->update($db->quoteName('#__hdflv_upload'))
				->set($db->quoteName('times_viewed') . ' = 1+times_viewed')
				->where($db->quoteName('id') . ' = ' . $db->quote($vid));
		$db->setQuery($query);
		$db->query();
	}

	/**
	 * Function to send report of a video
	 * 
	 * @return  sendreport
	 */
	public function sendreport()
	{
		$db = JFactory::getDBO();
		$repmsg = JRequest::getVar('reportmsg');
		$videoid = JRequest::getInt('videoid');
		$user = JFactory::getUser();
		$memberid = $user->get('id');

		// Alert admin regarding new video upload
		// Define joomla mailer
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();

		$query = $db->getQuery(true);

		//  Query is to display recent videos in home page
		$query->select(array('email','username'))
				->from('#__users')
				->where($db->quoteName('id') . ' = ' . $db->quote($memberid));
		$db->setQuery($query);
		$user_details = $db->loadObject();

		$sender = $config->get('mailfrom');
		$mailer->setSender($user_details->email);
		$featureVideoVal = "id=" . $videoid;
		$mailer->addRecipient($sender);
		$subject = 'User reported on a video';
		$baseurl = JURI::base();
		$video_url = $baseurl . 'index.php?option=com_contushdvideoshare&view=player&' . $featureVideoVal . '&adminview=true';
		$get_htmlmessage = file_get_contents($baseurl . '/components/com_contushdvideoshare/emailtemplate/reportvideo.html');
		$update_baseurl = str_replace("{baseurl}", $baseurl, $get_htmlmessage);
		$update_username = str_replace("{username}", $user_details->username, $update_baseurl);
		$update_rptmsg = str_replace("{reportmsg}", $repmsg, $update_username);
		$message = str_replace("{video_url}", $video_url, $update_rptmsg);
		$mailer->isHTML(true);
		$mailer->setSubject($subject);
		$mailer->Encoding = 'base64';
		$mailer->setBody($message);
		$send = $mailer->Send();

		if ($send !== true)
		{
			echo 'Error sending email: ' . $send->message;
		}
		else
		{
			echo 'Reported Successfully';
		}
	}

	/**
	 * Function to assign model for the view
	 * 
	 * @param   string  $viewName  view name
	 * 
	 * @return  getdisplay
	 */
	public function getdisplay($viewName = "index")
	{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$view = $this->getmodView($viewName, $viewType);
		$model = $this->getModel($viewName, 'Modelcontushdvideoshare');

		if (!JError::isError($model))
		{
			$view->setModel($model, true);
		}

		$view->display($cachable = false, $urlparams = false);
	}

	/**
	 * Function to assign view if view not exist
	 * 
	 * @param   string  $name    view name
	 * @param   string  $type    view type
	 * @param   string  $prefix  view prefix
	 * @param   array   $config  config array
	 * 
	 * @return  &getmodView
	 */
	public function &getmodView($name = '', $type = '', $prefix = '', $config = array())
	{
		static $views;

		if (empty($prefix))
		{
			$prefix = $this->getName() . 'View';
		}

		if (empty($views[$name]))
		{
			if (version_compare(JVERSION, '1.6.0', 'ge'))
			{
				if ($view = $this->createView($name, $prefix, $type, $config))
				{
					$views[$name] = & $view;
				}
				else
				{
					header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
				}
			}
			else
			{
				if ($view = $this->_createView($name, $prefix, $type, $config))
				{
					$views[$name] = & $view;
				}
				else
				{
					header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
				}
			}
		}

		return $views[$name];
	}

	/**
	 * Function for adxml view
	 * 
	 * @return  adsxml
	 */
	public function adsxml()
	{
		$view = $this->getView('adsxml');

		if ($model = $this->getModel('adsxml'))
		{
			// Push the model into the view (as default)
			// Second parameter indicates that it is the default model for the view
			$view->setModel($model, true);
		}

		$view->display();
	}

	/**
	 * Function for imaadxml view
	 * 
	 * @return  imaadxml
	 */
	public function imaadxml()
	{
		$view = $this->getView('imaadxml');

		if ($model = $this->getModel('imaadxml'))
		{
			// Push the model into the view (as default)
			// Second parameter indicates that it is the default model for the view
			$view->setModel($model, true);
		}

		$view->display();
	}

	/**
	 * Function for impressionclicks view
	 * 
	 * @return  impressionclicks
	 */
	public function impressionclicks()
	{
		$view = $this->getView('impressionclicks');

		if ($model = $this->getModel('impressionclicks'))
		{
			$view->setModel($model, true);
		}

		$view->display();
	}

	/**
	 * Function for videourl view
	 * 
	 * @return  videourl
	 */
	public function videourl()
	{
		$view = $this->getView('videourl');

		if ($model = $this->getModel('videourl'))
		{
			$view->setModel($model, true);
		}

		$view->getvideourl();
	}

	/**
	 * Function for assigning model for upload method
	 * 
	 * @return  uploadfile
	 */
	public function uploadfile()
	{
		$model = $this->getModel('uploadvideo');
		$model->fileupload();
	}

	/**
	 * Function for download option in player
	 * 
	 * @return  downloadfile
	 */
	public function downloadfile()
	{
		$url = JRequest::getVar('f');
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select(array('filepath', 'videourl'))
				->from('#__hdflv_upload')
				->where($db->quoteName('videourl') . ' = ' . $db->quote($url));
		$db->setQuery($query);
		$video_details = $db->loadObject();
		$filename = JPATH_COMPONENT . "/videos/" . $video_details->videourl;

		if (file_exists($filename))
		{
			header('Content-disposition: attachment; filename=' . basename($filename));
			readfile($filename);
		}
	}

	/**
	 * Function for email option in player
	 * 
	 * @return  emailuser
	 */
	public function emailuser()
	{
		$to = JRequest::getVar('to');
		$from = JRequest::getVar('from');
		$url = JRequest::getVar('url');
		$subject = JRequest::getVar('Note');
		$title = JRequest::getVar('title');

		$headers = "From: " . "<" . $from . ">\r\n";
		$headers .= "Reply-To: " . $from . "\r\n";
		$headers .= "Return-path: " . $from;
		$message = $subject . "\n\n";
		$message .= "Video URL: " . $url;

		if (mail($to, $title, $message, $headers))
		{
			$returnmessage = "success=sent";
		}
		else
		{
			$returnmessage = "success=error";
		}

		echo $returnmessage;
		exit;
	}
}
