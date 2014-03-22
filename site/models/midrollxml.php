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
 * Mid roll xml model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharemidrollxml extends ContushdvideoshareModel
{
	/**
	 * Function to midroll ads
	 * 
	 * @return  getads
	 */
	public function getads()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('*')
				->from('#__hdflv_ads')
				->where($db->quoteName('published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('typeofadd') . ' = ' . $db->quote('mid'));
		$db->setQuery($query);
		$rs_modulesettings = $db->loadObjectList();

		$query->clear()
				->select('player_icons')
				->from('#__hdflv_player_settings');
		$db->setQuery($query, 1);
		$rs_random = $db->loadObject();

		$player_icons = unserialize($rs_random->player_icons);
		$player_values = unserialize($rs_random->player_values);

		$random = $player_icons['midrandom'];
		$adrotate = $player_icons['midadrotate'];

		$interval = $player_values['midinterval'];
		$begin = $player_values['midbegin'];

		if ($random == 1)
		{
			$random = 'true';
		}
		else
		{
			$random = 'false';
		}

		if ($adrotate == 1)
		{
			$adrotate = 'true';
		}
		else
		{
			$adrotate = 'false';
		}

		if ($rs_modulesettings)
		{
			$this->showadsxml($rs_modulesettings, $random, $begin, $interval, $adrotate);
		}
	}

	/**
	 * Function to show midroll ads
	 * 
	 * @param   array    $midroll_video  Midroll ads detail in array format
	 * @param   boolean  $random         random display enabled or not
	 * @param   int      $begin          Mid roll ads starting time
	 * @param   int      $interval       Mid roll ad interval period to display the next ad
	 * @param   boolean  $adrotate       Rotation of displaying mid roll ad enabled or not
	 * 
	 * @return  showadsxml
	 */
	public function showadsxml($midroll_video, $random, $begin, $interval, $adrotate)
	{
		ob_clean();
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<midrollad begin="' . $begin . '" adinterval="' . $interval . '"
			random="' . $random . '" adrotate="' . $adrotate . '">';

		if (count($midroll_video) > 0)
		{
			foreach ($midroll_video as $rows)
			{
				if ($rows->clickurl == '')
				{
					$clickpath = JURI::base()
							. '?option=com_contushdvideoshare&view=impressionclicks&click=click&id=' . $rows->id;
				}
				else
				{
					$clickpath = $rows->clickurl;
				}

				if ($rows->impressionurl == '')
				{
					$impressionpath = JURI::base()
						. '?option=com_contushdvideoshare&view=impressionclicks&click=impression&id=' . $rows->id;
				}
				else
				{
					$impressionpath = $rows->impressionurl;
				}

				if (!preg_match("~^(?:f|ht)tps?://~i", $rows->targeturl))
				{
					$targeturl = "http://" . $rows->targeturl;
				}

				echo '<midroll targeturl="' . $targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '" >';
				echo '<![CDATA[';
				echo '<span class="heading">' . $rows->adsname;
				echo '</span><br><span class="midroll">' . $rows->adsdesc;
				echo '</span><br><span class="webaddress">' . $rows->targeturl;
				echo '</span>]]>';
				echo '</midroll>';
			}
		}

		echo '</midrollad>';
		exit();
	}
}
