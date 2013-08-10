<?php
/*
 * "Category Module for ContusHDVideoShare Component" - Version 1.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
?>

<span class="module_menu <?php echo $class; ?>">

    <ul class="menu">
        <?php
        $db = & JFactory::getDBO();
        if (count($result) > 0) {
            foreach ($result as $row) {
                $oriname = $row->category;      //category name changed here for seo url purpose
                $newrname = explode(' ', $oriname);
                $link = implode('-', $newrname);
                $link1 = explode('&', $link);
                $category = implode('and', $link1);
                $query1 = "select * from #__hdflv_category where parent_id in ('" . $row->id . "') and published=1";
                $db->setQuery($query1);
                $result1 = $db->loadObjectList();
        ?>
                <li class="item27"><a href="index.php?option=com_contushdvideoshare&view=category&category=<?php echo $row->seo_category; ?>"> <span><?php echo $row->category; ?></span></a>
            <?php
                if (count($result1) > 0) {
                    echo "<ul> ";
                    foreach ($result1 as $rows) {
                        $oriname = $rows->category;      //category name changed here for seo url purpose
                        $newrname = explode(' ', $oriname);
                        $link = implode('-', $newrname);
                        $link1 = explode('&', $link);
                        $category = implode('and', $link1);
            ?>
                    <li class=""><a href="index.php?option=com_contushdvideoshare&view=category&category=<?php echo $rows->seo_category; ?>"> <span><?php echo $rows->category; ?></span></a></li>
        <?php
                    }
                    echo "</ul>";
                }
        ?>

        <?php
            }
        } else {
            echo "No Category";
        }
        ?>

    </ul>
</span>









