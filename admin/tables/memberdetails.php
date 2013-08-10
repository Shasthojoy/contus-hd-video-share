<?php
/*
 * "ContusHDVideoShare Component" - Version 3.0
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: June 2012
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for memberdetails
class Tablememberdetails extends JTable {
	var $id = null;
	var $name = null;
    var $username = null;
    var $email = null;
    var $password = null;
    var $created_date = null;
    var $published = null;

	function Tablememberdetails(&$db){
		parent::__construct('#__hdflv_member_details', 'id', $db);
	}
}
?>
