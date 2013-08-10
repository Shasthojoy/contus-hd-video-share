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
 * @abstract      : Contushdvideoshare Category Module
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file

defined('_JEXEC') or die('Restricted access');
if(JRequest::getVar('option') != 'com_contushdvideoshare') {
$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base().'components/com_contushdvideoshare/css/mod_stylesheet.css' );
}
?>
<div class="module_menu <?php echo $class;?> ">
    <ul class="menu">
        <?php
        $db = JFactory::getDBO();
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

                //For SEO settings
                $seoOption =$result_settings[0]->seo_option;
                if ($seoOption == 1) {
                    $featureCategoryVal = "category=" . $row->seo_category;
                 } else {
                    $featureCategoryVal = "catid=" . $row->id;
                }

        ?>
                <li class="item27">
                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&" . $featureCategoryVal); ?>"> <span><?php echo $row->category; ?></span></a>
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
            <?php echo" <li class='hd-item-sub'>"; ?> <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $rows->id); ?>"> <span><?php echo $rows->category; ?></span></a><?php echo '</li>'; ?>
            <?php
                    }
                    echo "</ul>";
                }
            ?>
            </li>
        <?php
            }
        } else {
            echo "<li class='hd_norecords_found'>No Category</li>";
        }
        ?>

    </ul>
</div>
<div class="clear"></div>









