<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Search Videos Module
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base().'components/com_contushdvideoshare/css/stylesheet.css' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/upload_script.js' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/membervalidator.js' );
?>

<span class="module_menu <?php echo $class;?> ">
    <div align="center">
         <form name="hsearch" id="hsearch" method="post" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=hdvideosharesearch'); ?>"  enctype="multipart/form-data"  >
            <input type="text" value="" name="searchtxtbox" id="searchtxtbox" class="clstextfield"  onkeypress="validateenterkey(event,'hsearch');" style="color:#000000; "/>
            <input type="submit" name="search_btn" id="search_btn" class="button" value="<?php echo JText::_('HDVS_SEARCH'); ?>" />
            <input type="hidden" name="searchval" id="searchval" value="<?php if (isset($_POST['searchtxtbox'])) { echo $_POST['searchtxtbox']; } else { echo isset($_POST['searchval'])?$_POST['searchval']:'';  } ?>" />
        </form>
        <br/>
    </div>
</span>