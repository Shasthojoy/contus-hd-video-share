<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2011 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   February 2014
 * */
// No direct acesss
defined('_JEXEC') or die('Restricted access');

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * HD Video Share Search model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharehdvideosharesearch extends ContushdvideoshareModel
{
	/**
	 * Function to display the search results
	 * 
	 * @param   string  $string  string
	 * @param   string  $type    replace type
	 * 
	 * @return  phpSlashes
	 */
	public function phpSlashes($string, $type = 'add')
	{
		if ($type == 'add')
		{
			if (get_magic_quotes_gpc())
			{
				return $string;
			}
			else
			{
				if (function_exists('addslashes'))
				{
					return addslashes($string);
				}
				else
				{
					return mysql_real_escape_string($string);
				}
			}
		}
		elseif ($type == 'strip')
		{
			return stripslashes($string);
		}
		else
		{
			die('error in PHP_slashes (mixed,add | strip)');
		}
	}

	/**
	 * Function to get search result
	 * 
	 * @return  getsearch
	 */
	public function getsearch()
	{
		$db = $this->getDBO();
		$query = $db->getQuery(true);
		$session = JFactory::getSession();
		$btn = JRequest::getVar('search_btn');

		if (isset($btn))
		{
			// Getting the search  text  box value
			$search = JRequest::getVar('searchtxtbox', '', 'post', 'string');
			$session->set('search', $search);
		}
		else
		{
			$search = $session->get('search');
		}

		$search = $this->phpSlashes($search);

		$query->select(
						array(
							'a.id AS vid', 'a.category', 'a.seo_category', 'b.*', 'c.*', 'd.id', 'd.username'
						)
				)
				->from('#__hdflv_category AS a')
				->leftJoin('#__hdflv_video_category AS b ON b.catid=a.id')
				->leftJoin('#__hdflv_upload AS c ON c.id=b.vid')
				->leftJoin('#__users AS d ON c.memberid=d.id')
				->where($db->quoteName('c.type') . ' = ' . $db->quote('0'))
				->where($db->quoteName('c.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
				->where(
						'(' . $db->quoteName('c.title') . ' LIKE '
						. $db->quote('%' . $search . '%', false)
						. ' || ' . $db->quoteName('c.description') . ' LIKE '
						. $db->quote('%' . $search . '%', false)
						. ' || ' . $db->quoteName('c.tags') . ' LIKE '
						. $db->quote('%' . $search . '%', false)
						. ')'
				)
				->group($db->escape('c.id'));

		// Breaking the string to array of words
		$kt = preg_split("/[\s,]+/", $search);

		// Now let us generate the sql
		while (list($key, $search) = each($kt))
		{
			if ($search <> " " and strlen($search) > 0)
			{
				$query->clear()
						->select(
								array(
									'a.id AS vid', 'a.category', 'a.seo_category', 'b.*', 'c.*', 'd.id', 'd.username'
								)
						)
						->from('#__hdflv_category AS a')
						->leftJoin('#__hdflv_video_category AS b ON b.catid=a.id')
						->leftJoin('#__hdflv_upload AS c ON c.id=b.vid')
						->leftJoin('#__users AS d ON c.memberid=d.id')
						->where($db->quoteName('c.type') . ' = ' . $db->quote('0'))
						->where($db->quoteName('c.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
						->where(
								'(' . $db->quoteName('c.title') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ' || ' . $db->quoteName('c.description') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ' || ' . $db->quoteName('c.tags') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ')'
						)
						->group($db->escape('c.id'));
			}
		}

		$db->setQuery($query);
		$resulttotal = $db->loadObjectList();
		$subtotal = count($resulttotal);
		$total = $subtotal;
		$pageno = 1;

		if (JRequest::getVar('page', '', 'post', 'int'))
		{
			$pageno = JRequest::getVar('page', '', 'post', 'int');
		}

		$limitrow = $this->getsearchrowcol();
		$thumbview = unserialize($limitrow[0]->thumbview);
		$length = $thumbview['searchrow'] * $thumbview['searchcol'];
		$pages = ceil($total / $length);

		if ($pageno == 1)
		{
			$start = 0;
		}
		else
		{
			$start = ($pageno - 1) * $length;
		}

		if (isset($btn))
		{
			// Getting the search  text  box value
			$search = JRequest::getVar('searchtxtbox', '', 'post', 'string');
			$session->set('search', $search);
		}
		else
		{
			$search = $session->get('search');
		}

		$search = $this->phpSlashes($search);

		// Breaking the string to array of words
		$kt = preg_split("/[\s,]+/", $search);

		// Now let us generate the sql
		$query->clear()
				->select(
						array(
							'a.id AS vid', 'a.category', 'a.seo_category', 'b.catid', 'b.vid',
							'c.id', 'c.amazons3', 'c.filepath', 'c.thumburl', 'c.title', 'c.description',
							'c.times_viewed', 'c.ratecount', 'c.rate',
							'c.seotitle', 'd.id', 'd.username'
						)
				)
				->from('#__hdflv_category AS a')
				->leftJoin('#__hdflv_video_category AS b ON b.catid=a.id')
				->leftJoin('#__hdflv_upload AS c ON c.id=b.vid')
				->leftJoin('#__users AS d ON c.memberid=d.id')
				->where($db->quoteName('c.type') . ' = ' . $db->quote('0'))
				->where($db->quoteName('c.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
				->group($db->escape('c.id'));

		// Query for displaying the search value results
		while (list($key, $search) = each($kt))
		{
			if ($search <> " " and strlen($search) > 0)
			{
				// Query for displaying the search value results
				$query->clear()
						->select(
								array(
									'a.id AS vid', 'a.category', 'a.seo_category', 'b.catid', 'b.vid',
									'c.id', 'c.amazons3', 'c.filepath', 'c.thumburl', 'c.title', 'c.description',
									'c.times_viewed', 'c.ratecount', 'c.rate',
									'c.seotitle', 'd.id', 'd.username'
								)
						)
						->from('#__hdflv_category AS a')
						->leftJoin('#__hdflv_video_category AS b ON b.catid=a.id')
						->leftJoin('#__hdflv_upload AS c ON c.id=b.vid')
						->leftJoin('#__users AS d ON c.memberid=d.id')
						->where($db->quoteName('c.type') . ' = ' . $db->quote('0'))
						->where($db->quoteName('c.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('a.published') . ' = ' . $db->quote('1'))
						->where($db->quoteName('d.block') . ' = ' . $db->quote('0'))
						->where(
								'(' . $db->quoteName('c.title') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ' || ' . $db->quoteName('c.description') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ' || ' . $db->quoteName('c.tags') . ' LIKE '
								. $db->quote('%' . $search . '%', false)
								. ')'
						)
						->group($db->escape('c.id'));
			}
		}

		$db->setQuery($query, $start, $length);
		$rows = $db->loadObjectList();

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
	 * @return  getsearchrowcol
	 */
	public function getsearchrowcol()
	{
		$db = $this->getDBO();
		$query = $db->getQuery(true);

		// Query is to select the search video page settings
		$query->select(array('thumbview', 'dispenable'))
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->LoadObjectList();

		return $rows;
	}
}
