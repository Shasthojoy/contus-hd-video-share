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
 * Member videos model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharemembercollection extends ContushdvideoshareModel
{
	/**
	 * Function to display the videos of a particular registered member
	 * 
	 * @return  getmembercollection
	 */
	public function getmembercollection()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$session = JFactory::getSession();

		if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
		{
			$session->set('memberid', JRequest::getVar('memberidvalue', '', 'post', 'int'));
		}

		// Query for fetching membercollection total for pagination
		$query->select('count(a.id)')
				->from('#__hdflv_upload AS a')
				->leftJoin('#__hdflv_category AS b ON a.playlistid=b.id')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.type') . ' = ' . $db->quote('0'))
				->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
				->where($db->quoteName('a.memberid') . ' = ' . $db->quote($session->get('memberid', 'empty')));

		$db->setQuery($query);
		$resulttotal = $db->loadResult();
		$total = $resulttotal;
		$pageno = 1;

		if (JRequest::getVar('page', '', 'post', 'int'))
		{
			$pageno = JRequest::getVar('page', '', 'post', 'int');
		}

		// Function call for fetching member collection settings
		$limitrow = $this->getmemberpagerowcol();
		$thumbview = unserialize($limitrow[0]->thumbview);
		$length = $thumbview['memberpagerow'] * $thumbview['memberpagecol'];
		$pages = ceil($total / $length);

		if ($pageno == 1)
		{
			$start = 0;
		}
		else
		{
			$start = ($pageno - 1) * $length;
		}

		// Query for displaying the member collection videos when click on his name
		$query->clear()
				->select(
						array(
							'a.id', 'a.filepath', 'a.thumburl', 'a.title', 'a.description', 'a.times_viewed',
							'a.ratecount', 'a.rate',
							'a.amazons3', 'a.seotitle',
							'b.category', 'b.seo_category', 'd.username', 'e.catid', 'e.vid'
						)
				)
				->from('#__hdflv_upload AS a')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
				->leftJoin('#__hdflv_category AS b ON e.catid=b.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
				->where($db->quoteName('a.type') . ' = ' . $db->quote('0'))
				->where($db->quoteName('a.memberid') . ' = ' . $db->quote($session->get('memberid', 'empty')))
				->group($db->escape('e.vid'))
				->order($db->escape('a.id' . ' ' . 'DESC'));
		$db->setQuery($query, $start, $length);
		$rows = $db->LoadObjectList();

		// Below code is to merge the pagination values like pageno,pages,start value,length value
		if (count($rows) > 0)
		{
			$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;
		}

		return $rows;
	}

	/**
	 * Function to get thumb settings
	 * 
	 * @return  getmemberpagerowcol
	 */
	public function getmemberpagerowcol()
	{
		$db = $this->getDBO();
		$query = $db->getQuery(true);

		// Query is to fetch membercollection settings
		$query->select(array('thumbview', 'dispenable'))
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->LoadObjectList();

		return $rows;
	}
}
