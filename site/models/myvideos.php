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
 * Myvidos model class
 *
 * @package     Joomla.Contus_HD_Video_Share
 * @subpackage  Com_Contushdvideoshare
 * @since       1.5
 */
class Modelcontushdvideosharemyvideos extends ContushdvideoshareModel
{
	/**
	 * Function to remove slashes from string
	 * 
	 * @param   string  $string  string to be remove slash
	 * @param   string  $type    type of action to be performed
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
	 * Function to delete a particular video and display videos of user who logged in
	 * 
	 * @return  getmembervideo
	 */
	public function getmembervideo()
	{
		$user = JFactory::getUser();
		$session = JFactory::getSession();
		$db = $this->getDBO();
		$query = $db->getQuery(true);
		$where = $order = $search = $hidden_page = '';
		$pageno = 1;

		if (JRequest::getVar('deletevideo', '', 'post', 'int'))
		{
			// Getting the video id which is going to be deleted
			$id = JRequest::getVar('deletevideo', '', 'post', 'int');

			//  Query for deleting a selected video
			$query->update($db->quoteName('#__hdflv_upload'))
					->set($db->quoteName('published') . ' = ' . $db->quote('-2'))
					->where($db->quoteName('id') . ' = ' . $db->quote($id));
			$db->setQuery($query);
			$db->query();
		}

		//  Following code for displaying videos of the particular member when he logged in
		if ($user->get('id'))
		{
			// Setting the loginid into session
			$memberid = $user->get('id');
		}

		$searchtextbox = JRequest::getVar('searchtxtboxmember', '', 'post', 'string');
		$hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');

		if ($searchtextbox)
		{
			$search = $searchtextbox;
		}
		else
		{
			$search = $hiddensearchbox;
		}

		if (JRequest::getVar('page', '', 'post', 'int'))
		{
			$pageno = JRequest::getVar('page', '', 'post', 'int');
		}

		$search = $this->phpSlashes($search);

		if ($search)
		{
			$where = '(' . $db->quoteName('a.title') . ' LIKE '
					. $db->quote('%' . $db->getEscaped($search, true) . '%', false)
					. $db->quoteName('a.description') . ' LIKE '
					. $db->quote('%' . $db->getEscaped($search, true) . '%', false)
					. $db->quoteName('a.tags') . ' LIKE '
					. $db->quote('%' . $db->getEscaped($search, true) . '%', false)
					. $db->quoteName('b.category') . ' LIKE '
					. $db->quote('%' . $db->getEscaped($search, true) . '%', false)
					. ')';
		}

		// Query to get the total videos for user
		$query->clear()
				->select('count(a.id)')
				->from('#__hdflv_upload AS a')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->leftJoin('#__hdflv_category AS b ON b.id=a.playlistid')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('0'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.memberid') . ' = ' . $db->quote($memberid))
				->where($where);
		$db->setQuery($query);
		$total = $db->loadResult();

		$limitrow = $this->getmyvideorowcol();

		$thumbview = unserialize($limitrow[0]->thumbview);
		$length = $thumbview['myvideorow'] * $thumbview['myvideocol'];

		// Query is to select the videos of the logged in users
		$query->clear()
				->select('allowupload')
				->from('#__hdflv_user')
				->where($db->quoteName('member_id') . ' = ' . $db->quote($memberid));
		$db->setQuery($query);
		$row = $db->LoadObjectList();

		if (count($row) != 0)
		{
			$allowupload = $row[0]->allowupload;
		}
		else
		{
			$dispenable = unserialize($limitrow[0]->dispenable);
			$allowupload = $dispenable['allowupload'];
		}

		$pages = ceil($total / $length);

		if ($pageno == 1)
		{
			$start = 0;
		}
		else
		{
			$start = ( $pageno - 1) * $length;
		}

		if (JRequest::getVar('sorting', '', 'post', 'int'))
		{
			$session = JFactory::getSession();
			$session->set('sorting', JRequest::getVar('sorting', '', 'post', 'int'));
		}

		if ($session->get('sorting', 'empty') == "1")
		{
			// Query is to display the myvideos results order by title
			$order = $db->escape('a.title' . ' ' . 'ASC');
		}
		elseif ($session->get('sorting', 'empty') == "2")
		{
			// Query is to display the myvideos results order by added date
			$order = $db->escape('a.addedon' . ' ' . 'DESC');
		}
		elseif ($session->get('sorting', 'empty') == "3")
		{
			// Query is to display the myvideos results order by time of views
			$order = $db->escape('a.times_viewed' . ' ' . 'DESC');
		}
		else
		{
			// Query is to display the myvideos results
			$order = $db->escape('a.id' . ' ' . 'DESC');
		}

		// Query is to display the myvideos results
		$query->clear()
				->select(array('a.*', 'b.category', 'b.seo_category', 'd.username', 'e.*', 'count(f.videoid) AS total'))
				->from('#__hdflv_upload AS a')
				->leftJoin('#__users AS d ON a.memberid=d.id')
				->leftJoin('#__hdflv_video_category AS e ON e.vid=a.id')
				->leftJoin('#__hdflv_category AS b ON b.id=e.catid')
				->leftJoin('#__hdflv_comments AS f ON f.videoid=a.id')
				->where($db->quoteName('a.published') . ' = ' . $db->quote('0'))
				->where($db->quoteName('b.published') . ' = ' . $db->quote('1'))
				->where($db->quoteName('a.memberid') . ' = ' . $db->quote($memberid))
				->where($where)
				->group($db->escape('a.id'))
				->order($order);
		$db->setQuery($query, $start, $length);
		$rows = $db->LoadObjectList();

		$row1['allowupload'] = $allowupload;

		if (count($rows) > 0)
		{
			$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;
		}

		return array('rows' => $rows, 'row1' => $row1);
	}

	/**
	 * Function to get thumb settings
	 * 
	 * @return  getmyvideorowcol
	 */
	public function getmyvideorowcol()
	{
		$user = JFactory::getUser();
		$memberid = "";

		if ($user->get('id'))
		{
			// Setting the login id into session
			$memberid = $user->get('id');
		}

		$db = $this->getDBO();
		$query = $db->getQuery(true);

		// Query is to select the myvideos settings
		$query->select(array('thumbview', 'dispenable'))
				->from('#__hdflv_site_settings');
		$db->setQuery($query);
		$rows = $db->LoadObjectList();

		return $rows;
	}

	/**
	 * Function to get video comment
	 * 
	 * @param   int  $vid  video id
	 * 
	 * @return  getmyvideocomment
	 */
	public function getmyvideocomment($vid)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('count(message)')
				->from('#__hdflv_comments')
				->where($db->quoteName('videoid') . ' = ' . $db->quote($vid));
		$db->setQuery($query);
		$comment_count_row = $db->loadResult();

		return $comment_count_row;
	}
}
