<?php
/*
* "Category Module for ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined ('_JEXEC') or die('Restricted access');
class modcategorylist
{
    function getcategorylist()
    {
        $db =& JFactory::getDBO();
        $query = "select * from #__hdflv_category where parent_id=-1 and published=1 order by ordering asc";       
        $db->setQuery( $query );
        $rs= $db->loadObjectList();
        return $rs;
    }
    
    }

?>
