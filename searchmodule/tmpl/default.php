<?php
/*
 * "Search Videos Module for ContusHDVideoShare Component" - Version 1.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
?>
<span class="module_menu <?php echo $class; ?>">
    <div align="center">
        <link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />
        <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/upload_script.js"></script>
        <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
        <form name="hsearch" id="hsearch" method="post" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=hdvideosharesearch'); ?>"  enctype="multipart/form-data"  >
            <input type="text" value="" name="searchtxtbox" id="searchtxtbox" class="clstextfield"  onkeypress="validateenterkey(event,'hsearch');" stye="color:#000000; "/>
            <!--
            <input style="cursor:pointer;" type="submit" name="search_btn" id="search_btn" class="button" value="Search" style="margin-left:10px;" />
            -->
            <input type="submit" name="search_btn" id="search_btn" class="button" value="<?php echo _HDVS_SEARCH; ?>" />
            <input type="hidden" name="searchval" id="searchval" value="<?php if (isset($_POST['searchtxtbox'])) {
    echo $_POST['searchtxtbox'];
} else {
    echo $_POST['searchval'];
}; ?>" />
        </form>
        <br/>
    </div>
</span>

