<?php
/**
 * @version     2.3, Creation Date : March-24-2011
 * @name        default.php
 * @location    /components/modules/mod_HDVideoShareFeatured/tmpl/default.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */
/*
 * Description : Modules HDVideoShare Featured 
 */

// No direct Access
defined('_JEXEC') or die('Restricted access');
$ratearray =array();
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
// JHTML::_('stylesheet', JURI::base().'components/com_contushdvideoshare/css/stylesheet.css', array(), true);
// JHTML::_('stylesheet', JURI::base().'components/com_contushdvideoshare/css/tool_tip.css', array(), true);
?>
<span class="module_menu <?php echo $class;?> ">
    <br/>
    <div  align="center" id="module_videos" >
        <table style="margin-top:-20px;">
            <?php
            $totalrecords = count($result);
            $j = 0;
            for ($i = 0; $i < $totalrecords; $i++) {

                if ($i == 0) {
            ?>
                    <tr>
                <?php }
                if (($i % $result1[0]->sidefeaturedvideocol) == 0 && $i != 0) {
                ?>
                </tr><tr>
                <?php } ?>
                <td >

                    <?php
                    $src_path = '';
                    if ($result[$i]->filepath == "File" || $result[$i]->filepath == "FFmpeg")
                        $src_path = JURI::base() . "components/com_contushdvideoshare/videos/" . $result[$i]->thumburl;
                    if ($result[$i]->filepath == "Url" || $result[$i]->filepath == "Youtube")
                        $src_path = $result[$i]->thumburl;
                    ?>
                    <div class=" clearfix">
                        <div class="">
                            <?php
                            $orititle = $result[$i]->title;
                            $newtitle = explode(' ', $orititle);
                            $displaytitle = implode('-', $newtitle);
                            ?>
                            <div class="home-thumb">
                                <div class="home-play-container">
                                    <span class="play-button-hover">
                                        <div class="movie-entry yt-uix-hovercard">

                                             <div class="tooltip">
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $result[$i]->id . "&catid=" . $result[$i]->catid); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="125" height="69" title=""  /></p></a>
                                                  <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . _HDVS_CATEGORY . ' : ' . '</span>' .'<span class="clstoolright">'. $result[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . _HDVS_DESCRIPTION . ' : ' . '</span>' .'<p>'. $result[$i]->description.'</p>'; ?>
                                                          <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo _HDVS_VIEWS; ?>: </span><span class="clstoolright"><?php echo $result[$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>

                                           


                                        </div>
                                    </span>
                                </div>
                                <div class="show-title-container" id="title">
                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&id=" . $result[$i]->id . "&catid=" . $result[$i]->catid); ?>" class="show-title-gray info_hover"><?php if (strlen($result[$i]->title) > 18) { echo JHTML::_('string.truncate', ($result[$i]->title), 18); } else { echo $result[$i]->title; } ?></a>
                                </div>
                                <div class="video-info" id="catagory-view">
                                    <span><?php echo _HDVS_CATEGORY; ?>: </span>
                                    <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&catid=" . $result[$i]->catid); ?>"><?php echo $result[$i]->category; ?></a>
                                </div>
                                        <?php if ($result1[0]->ratingscontrol == 1) { ?>
                                                <span class="video-info">
                                                    <span class="floatleft"> <?php echo _HDVS_RATTING; ?>:</span>
                                                <?php
                                                    if (isset($result[$i]->ratecount) && $result[$i]->ratecount != 0) {
                                                        $ratestar = round($result[$i]->rate / $result[$i]->ratecount);
                                                    } else {
                                                        $ratestar = 0;
                                                    }
                                                ?>
                                                        <span class="floatleft innerrating"><div id="<?php echo $ratearray[$ratestar]; ?>"></div></span>
                                                </span>
                                        <?php } ?>
                                                <div class="clear"></div>
                                        <?php if ($result1[0]->viewedconrtol == 1) { ?>
                                                    <span class="video-info">
                                                        <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>
                                                        <span class="floatleft"><?php echo $result[$i]->times_viewed; ?></span>
                                                    </span>
                                        <?php } ?>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $j++;
                                            }
                                   ?>
                    </tr>
                </table>
            </div>
        </span>
<?php $t = count($result); if ($t > 1) { ?><div class="clear"></div> <div align="right" class="morevideos"><a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=featuredvideos"); ?>"><?php echo _HDVS_MORE_VIDEOS; ?></a></div><?php } ?>
<div class="clear"></div>

