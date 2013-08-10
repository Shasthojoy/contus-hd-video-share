<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Featured Module
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
if(JRequest::getVar('option') != 'com_contushdvideoshare') {
$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base().'components/com_contushdvideoshare/css/mod_stylesheet.css' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/jquery.js' );
$document->addScript(JURI::base()."components/com_contushdvideoshare/js/htmltooltip.js");
}
?>

<div class="module_menu <?php echo $class;?> " id="module_videos">
    <!-- Code begin here for featured videos in home page display  -->
        <div class="video-grid-container" class="clearfix">
            <?php
            $totalrecords = count($result);
            $j = 0;
            for ($i = 0; $i < $totalrecords; $i++) {
                if ($i == 0) {
             ?>
            <ul class="ulvideo_thumb clearfix">
            <?php }
            if (($i % $result1[0]->sidefeaturedvideocol) == 0 && $i != 0) { ?>
            </ul>
            <ul class="ulvideo_thumb clearfix">
                <?php } ?>
                    <?php
                    if ($result[$i]->filepath == "File" || $result[$i]->filepath == "FFmpeg")
                        $src_path = JURI::base() . "components/com_contushdvideoshare/videos/" . $result[$i]->thumburl;
                    if ($result[$i]->filepath == "Url" || $result[$i]->filepath == "Youtube")
                        $src_path = $result[$i]->thumburl;

                        //For SEO settings
                        $seoOption = $result1[0]->seo_option;
                        if ($seoOption == 1)
                        {
                        	$featuredCategoryVal = "category=" . $result[$i]->seo_category;
                        	$featuredVideoVal = "video=" . $result[$i]->seotitle;
                        }
                        else
                        {
                        	$featuredCategoryVal = "catid=" . $result[$i]->catid;
                        	$featuredVideoVal = "id=" . $result[$i]->id;
                        }
                    ?>
                     <li class="video-item">
                    <?php
                        $orititle = $result[$i]->title;
                        $newtitle = explode(' ', $orititle);
                        $displaytitle = implode('-', $newtitle);
                    ?>
                           <div class="mod_video_item">
                            <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $featuredVideoVal . "&amp;" . $featuredCategoryVal); ?>" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0" title="" alt="thumb_image" /></a>
                           </div>
                         <div class="floatleft video-item-details">
                                <div class="show-title-container" id="title">
                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $result[$i]->id . "&catid=" . $result[$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($result[$i]->title) > 30) { echo JHTML::_('string.truncate', ($result[$i]->title), 30); } else { echo $result[$i]->title; } ?></a>
                                </div>
             <?php if ($result1[0]->ratingscontrol == 1) { ?>
                                            <?php
                                                if (isset($result[$i]->ratecount) && $result[$i]->ratecount != 0) {
                                                    $ratestar = round($result[$i]->rate / $result[$i]->ratecount);
                                                } else {
                                                    $ratestar = 0;
                                                }
                                            ?>
                                            <div id="<?php echo $ratearray[$ratestar]; ?>" class="floatleft"></div>

                                <?php } ?>
                                    <div class="clear"></div>
                                <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                        <span class="floatleft video-info"><?PHP echo JText::_('HDVS_VIEWS'); ?>: <?php echo $result[$i]->times_viewed; ?> </span>
                         </div>
                                       <?php } ?>
                                    </li>

                        <?php
                                $j++;
                                }
                            ?>
                    </ul>
        </div>
</div>
 <!--Tooltip Starts Here-->
                      <?php
                      for ($i = 0; $i < $totalrecords; $i++)
                                      { ?>
<!--                                          <div class="htmltooltip">
                                              <?php if($result[$i]->description) {?>
                                             <p class="tooltip_discrip"><?php //echo JHTML::_('string.truncate', ($result[$i]->description), 120); ?></p>
                                             <?php }?>
                                             <div class="tooltip_category_left">
                                                 <span class="title_category"><?php //echo  JText::_('HDVS_CATEGORY');?>: </span>
                                                 <span class="show_category"><?php //echo $result[$i]->category; ?></span>
                                             </div>
                                             <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                            <div class="tooltip_views_right">
                                                 <span class="view_txt"><?php //echo JText::_('HDVS_VIEWS'); ?>: </span>
                                                 <span class="view_count"><?php //echo $result[$i]->times_viewed; ?> </span>
                                             </div>
                                             <div id="htmltooltipwrapper<?php //echo $i; ?>">
                                                 <div class="chat-bubble-arrow-border"></div>
                                               <div class="chat-bubble-arrow"></div>
                                             </div>
                                           </div>-->
                                    <?php } }?>
             <!--Tooltip end Here-->
<?php $t = count($result);
if ($t > 1) { ?>
<div class="clear"></div>
<div align="right" class="morevideos">
    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=featuredvideos"); ?>"><?php echo JText::_('HDVS_MORE_VIDEOS'); ?></a></div><?php } ?>
<div class="clear"></div>
 <script type="text/javascript">
                              jQuery.noConflict();
                                jQuery(document).ready(function($){
                                    jQuery(".ulvideo_thumb").mouseover(function(){
                                        htmltooltipCallback();
                                    });
                                });

                        </script>

