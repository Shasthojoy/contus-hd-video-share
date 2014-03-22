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
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * Adsxml model class.
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideoshareadsxml extends ContushdvideoshareModel
{
	/**
	 * Function to get ads
	 * 
	 * @return  getads
	 */
	public function getads()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select(
						array(
							'id', 'published', 'adsname', 'filepath', 'postvideopath', 'targeturl',
							'clickurl', 'impressionurl', 'adsdesc', 'typeofadd'
						)
				)
				->from('#__hdflv_ads')
				->where($db->quoteName('published') . ' = ' . $db->quote('1') . ' AND ' . $db->quoteName('typeofadd') . ' = ' . $db->quote('prepost'));
		$db->setQuery($query);
		$rs_ads = $db->loadObjectList();
		$this->showadsxml($rs_ads);
	}

	/**
	 * Function to show ads
	 * 
	 * @param   array  $rs_ads  ad detail in array format
	 * 
	 * @return  showadsxml
	 */
	public function showadsxml($rs_ads)
	{
		ob_clean();
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<ads random="false">';
		$current_path = "components/com_contushdvideoshare/videos/";
		$clickpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=click';
		$impressionpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=impression';

		if (count($rs_ads) > 0)
		{
			foreach ($rs_ads as $rows)
			{
				if ($rows->filepath == "File")
				{
					$postvideo = JURI::base() . $current_path . $rows->postvideopath;
				}
				elseif ($rows->filepath == "Url")
				{
					$postvideo = $rows->postvideopath;
				}

				if (!preg_match("~^(?:f|ht)tps?://~i", $rows->targeturl))
				{
					$targeturl = "http://" . $rows->targeturl;
				}

				echo '<ad id="' . $rows->id . '" url="' . $postvideo
						. '" targeturl="' . $targeturl
						. '" clickurl="' . $clickpath . '" impressionurl="'
						. $impressionpath . '">';
				echo '<![CDATA[' . $rows->adsdesc . ']]>';
				echo '</ad>';
			}
		}

		echo '</ads>';
		exit();
	}
}
