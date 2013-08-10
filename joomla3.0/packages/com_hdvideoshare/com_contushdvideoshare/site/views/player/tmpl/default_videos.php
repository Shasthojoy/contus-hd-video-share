<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Player View
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
if (empty($this->videodetails)) {
?>
    <div class="section clearfix ">
    <?php
    /* home page bottom */
    for ($coun_tmovie_post = 1; $coun_tmovie_post <= 3; $coun_tmovie_post++) {
        if ($this->homepagebottomsettings[0]->homefeaturedvideo == 1 && $this->homepagebottomsettings[0]->homefeaturedvideoorder == $coun_tmovie_post) {
    ?>
            <div  id="video-grid-container" class="clearfix">
                <h2 class="home-link hoverable" ><a href="index.php?option=com_contushdvideoshare&view=featuredvideos" title="<?php echo JText::_('HDVS_FEATURED_VIDEOS'); ?>"> <?php echo JText::_('HDVS_FEATURED_VIDEOS'); ?></a></h2>
                <ul class="ulvideo_thumb clearfix">
            <?php
            $totalrecords = count($this->rs_playlist1[0]);
            for ($i = 0; $i < $totalrecords; $i++) {
                //For SEO settings
                $seoOption = $this->homepagebottomsettings[0]->seo_option;
                if ($seoOption == 1) {
                    $featureCategoryVal = "category=" . $this->rs_playlist1[0][$i]->seo_category;
                    $featureVideoVal = "video=" . $this->rs_playlist1[0][$i]->seotitle;
                } else {
                    $featureCategoryVal = "catid=" . $this->rs_playlist1[0][$i]->catid;
                    $featureVideoVal = "id=" . $this->rs_playlist1[0][$i]->id;
                }

                if ($this->rs_playlist1[0][$i]->filepath == "File" || $this->rs_playlist1[0][$i]->filepath == "FFmpeg")
                    $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[0][$i]->thumburl;
                if ($this->rs_playlist1[0][$i]->filepath == "Url" || $this->rs_playlist1[0][$i]->filepath == "Youtube")
                    $src_path = $this->rs_playlist1[0][$i]->thumburl;
            ?>
                <li class="video-item featured_gutterwidth">
                    <a class=" info_hover featured_vidimg" rel="htmltooltip" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $featureCategoryVal . '&' . $featureVideoVal, true); ?>" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  width="145" height="80" title="" alt="thumb_image" /></a>
                    <div class="show-title-container">
                        <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $featureCategoryVal . '&' . $featureVideoVal, true); ?>" class="show-title-gray info_hover"><?php
                if (strlen($this->rs_playlist1[0][$i]->title) > 50) {
                    echo JHTML::_('string.truncate', ($this->rs_playlist1[0][$i]->title), 50);
                } else {
                    echo $this->rs_playlist1[0][$i]->title;
                }
            ?> </a>
                </div>
                <?php
                if ($this->homepagebottomsettings[0]->ratingscontrol == 1) {
                    if (isset($this->rs_playlist1[0][$i]->ratecount) && $this->rs_playlist1[0][$i]->ratecount != 0) {
                        $ratestar = round($this->rs_playlist1[0][$i]->rate / $this->rs_playlist1[0][$i]->ratecount);
                    } else {
                        $ratestar = 0;
                    }
                ?>
                    <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                <?php } if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                    <span class="floatright viewcolor"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                <?php } ?>
            </li>
            <?php
                if ((($i + 1) % $this->homepagebottomsettings[0]->homefeaturedvideocol) == 0 && ($i+1)!=$totalrecords) {
            ?>
                </ul><ul class="ulvideo_thumb clearfix">
            <?php } ?>
            <?php
            }
            ?>       </ul><a class="playerpage_morevideos" href="index.php?option=com_contushdvideoshare&view=featuredvideos" title="<?php echo JText::_('HDVS_MORE_VIDEOS'); ?>"><?php echo JText::_('HDVS_MORE_VIDEOS') . ' >'; ?></a>
    </div>
    <!--Tooltip Starts Here-->
    <?php
            for ($i = 0; $i < $totalrecords; $i++) {
    ?>
                <div class="htmltooltip">
        <?php if ($this->rs_playlist1[0][$i]->description) {
        ?>
                    <p class="tooltip_discrip"><?php echo JHTML::_('string.truncate', (strip_tags($this->rs_playlist1[0][$i]->description)), 120); ?></p>
        <?php } ?>
                <div class="tooltip_category_left">
                    <span class="title_category"><?php echo JText::_('HDVS_CATEGORY'); ?>: </span>
                    <span class="show_category"><?php echo $this->rs_playlist1[0][$i]->category; ?></span>
                </div>
        <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
        ?>
                    <div class="tooltip_views_right">
                        <span class="view_txt"><?php echo JText::_('HDVS_VIEWS'); ?>: </span>
                        <span class="view_count"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?> </span>
                    </div>
                    <div id="htmltooltipwrapper<?php echo $i; ?>">
                        <div class="chat-bubble-arrow-border"></div>
                        <div class="chat-bubble-arrow"></div>
                    </div>
                    <?php } ?>
                </div>
    <?php
            } ?>
            <!--Tooltip end Here-->
    <?php } ?>
        <!-- Code end here for featured videos and begin for popular videos in home page display -->
    <?php
        if ($this->homepagebottomsettings[0]->homepopularvideo == 1 && $this->homepagebottomsettings[0]->homepopularvideoorder == $coun_tmovie_post) {
    ?>
            <div id="video-grid-container_pop" class="clearfix">
                <h2 class="home-link hoverable"><a href="index.php?option=com_contushdvideoshare&view=popularvideos" title="<?php echo JText::_('HDVS_POPULAR_VIDEOS'); ?>"><?php echo JText::_('HDVS_POPULAR_VIDEOS'); ?></a></h2>
                <ul class="ulvideo_thumb clearfix">
            <?php
            $totalrecords = count($this->rs_playlist1[2]);
            for ($i = 0; $i < $totalrecords; $i++) {
                //For SEO settings
                $seoOption = $this->homepagebottomsettings[0]->seo_option;
                if ($seoOption == 1) {
                    $popularCategoryVal = "category=" . $this->rs_playlist1[2][$i]->seo_category;
                    $popularVideoVal = "video=" . $this->rs_playlist1[2][$i]->seotitle;
                } else {
                    $popularCategoryVal = "catid=" . $this->rs_playlist1[2][$i]->catid;
                    $popularVideoVal = "id=" . $this->rs_playlist1[2][$i]->id;
                }
                if ($this->rs_playlist1[2][$i]->filepath == "File" || $this->rs_playlist1[2][$i]->filepath == "FFmpeg")
                    $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[2][$i]->thumburl;
                if ($this->rs_playlist1[2][$i]->filepath == "Url" || $this->rs_playlist1[2][$i]->filepath == "Youtube")
                    $src_path = $this->rs_playlist1[2][$i]->thumburl;
            ?>
                <li class="video-item popular_gutterwidth">
                    <a class=" info_hover featured_vidimg"  rel="htmltooltip1" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $popularCategoryVal . '&' . $popularVideoVal, true); ?>" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  width="145" height="80" title="" alt="thumb_image"/></a>
                    <div class="show-title-container" >
                        <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $popularCategoryVal . '&' . $popularVideoVal, true); ?>" class="show-title-gray info_hover"><?php
                if (strlen($this->rs_playlist1[2][$i]->title) > 50) {
                    echo JHTML::_('string.truncate', ($this->rs_playlist1[2][$i]->title), 50);
                } else {
                    echo $this->rs_playlist1[2][$i]->title;
                }
            ?></a>
                </div>
                <div class="clsratingvalue">
                    <?php
                    if ($this->homepagebottomsettings[0]->ratingscontrol == 1) {
                        if (isset($this->rs_playlist1[2][$i]->ratecount) && $this->rs_playlist1[2][$i]->ratecount != 0) {
                            $ratestar = round($this->rs_playlist1[2][$i]->rate / $this->rs_playlist1[2][$i]->ratecount);
                        } else {
                            $ratestar = 0;
                        }
                    ?>
                        <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                    <?php } ?>
                </div>
                <?php
                    if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
                ?>
                        <span class="floatright viewcolor"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                <?php } ?>
                </li>
            <?php
                    if ((($i + 1) % $this->homepagebottomsettings[0]->homepopularvideocol) == 0 && ($i+1)!=$totalrecords) {
            ?>
                    </ul><ul class="ulvideo_thumb clearfix">
            <?php
                    }
                }
            ?>                                     </ul>
            <a class="playerpage_morevideos" href="index.php?option=com_contushdvideoshare&view=popularvideos" title="<?php echo JText::_('HDVS_MORE_VIDEOS'); ?>"><?php echo JText::_('HDVS_MORE_VIDEOS') . ' >'; ?></a>
        </div>
        <!--Tooltip Starts Here-->
    <?php
                for ($i = 0; $i < $totalrecords; $i++) {
    ?>
                    <div class="htmltooltip1">
<?php if ($this->rs_playlist1[2][$i]->description) { ?>
                        <p class="tooltip_discrip"><?php echo JHTML::_('string.truncate', (strip_tags($this->rs_playlist1[2][$i]->description)), 120); ?></p>
<?php } ?>
                    <div class="tooltip_category_left">
                        <span class="title_category"><?php echo JText::_('HDVS_CATEGORY'); ?>: </span>
                        <span class="show_category"><?php echo $this->rs_playlist1[2][$i]->category; ?></span>
                    </div>
        <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                        <div class="tooltip_views_right">
                            <span class="view_txt"><?php echo JText::_('HDVS_VIEWS'); ?>: </span>
                            <span class="view_count"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?> </span>
                        </div>
                        <div id="htmltooltipwrapper1<?php echo $i; ?>">
                            <div class="chat-bubble-arrow-border"></div>
                            <div class="chat-bubble-arrow"></div>
                        </div>
                        <?php } ?>
                    </div>
    <?php
                } ?>
                <!--Tooltip end Here-->
    <?php } ?>
    <?php
            if ($this->homepagebottomsettings[0]->homerecentvideo == 1 && $this->homepagebottomsettings[0]->homerecentvideoorder == $coun_tmovie_post) {
    ?>
                <!-- Code end here for Popular videos and begin for Recent videos in home page display -->
                <div id="video-grid-container_rec" class="clearfix">
                    <h2 class="home-link hoverable"><a href = "<?php echo jRoute::_('index.php?option=com_contushdvideoshare&view=recentvideos'); ?>" title="<?php echo JText::_('HDVS_RECENT_VIDEOS'); ?>"> <?php echo JText::_('HDVS_RECENT_VIDEOS'); ?></a></h2>
                    <ul class="ulvideo_thumb clearfix">
            <?php
                $totalrecords = count($this->rs_playlist1[1]);
                for ($i = 0; $i < $totalrecords; $i++) {
                    //For SEO settings
                    $seoOption = $this->homepagebottomsettings[0]->seo_option;
                    if ($seoOption == 1) {
                        $recentCategoryVal = "category=" . $this->rs_playlist1[1][$i]->seo_category;
                        $recentVideoVal = "video=" . $this->rs_playlist1[1][$i]->seotitle;
                    } else {
                        $recentCategoryVal = "catid=" . $this->rs_playlist1[1][$i]->catid;
                        $recentVideoVal = "id=" . $this->rs_playlist1[1][$i]->id;
                    }
                    if ($this->rs_playlist1[1][$i]->filepath == "File" || $this->rs_playlist1[1][$i]->filepath == "FFmpeg")
                        $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[1][$i]->thumburl;
                    if ($this->rs_playlist1[1][$i]->filepath == "Url" || $this->rs_playlist1[1][$i]->filepath == "Youtube")
                        $src_path = $this->rs_playlist1[1][$i]->thumburl;
            ?>
                    <li class="video-item recent_gutterwidth">
                        <a class=" info_hover featured_vidimg" rel="htmltooltip2" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $recentCategoryVal . '&' . $recentVideoVal, true); ?>" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  width="145" height="80" title="" alt="thumb_image" /></a>
                        <div class="show-title-container">
                            <a href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $recentCategoryVal . '&' . $recentVideoVal, true); ?>" class="show-title-gray info_hover"><?php
                    if (strlen($this->rs_playlist1[1][$i]->title) > 50) {
                        echo JHTML::_('string.truncate', ($this->rs_playlist1[1][$i]->title), 50);
                        //echo (substr($this->rs_playlist1[1][$i]->title, 0, 23)) . "...";
                    } else {
                        echo $this->rs_playlist1[1][$i]->title;
                    }
            ?></a>                                                </div>
                <?php
                    if ($this->homepagebottomsettings[0]->ratingscontrol == 1) {
                        if (isset($this->rs_playlist1[1][$i]->ratecount) && $this->rs_playlist1[1][$i]->ratecount != 0) {
                            $ratestar = round($this->rs_playlist1[1][$i]->rate / $this->rs_playlist1[1][$i]->ratecount);
                        } else {
                            $ratestar = 0;
                        }
                ?>
                        <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                <?php } if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
                ?>
                        <span class="floatright viewcolor"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                <?php } ?>
                </li>
            <?php
                    if ((($i + 1) % $this->homepagebottomsettings[0]->homerecentvideocol) == 0 && ($i+1)!=$totalrecords) {
            ?>
                    </ul><ul class="ulvideo_thumb clearfix">
            <?php }
                } ?> </ul><a class="playerpage_morevideos" href = "<?php echo jRoute::_('index.php?option=com_contushdvideoshare&view=recentvideos'); ?>" title="<?php echo JText::_('HDVS_MORE_VIDEOS'); ?>"><?php echo JText::_('HDVS_MORE_VIDEOS') . ' >'; ?></a>
        </div>
        <!--Tooltip Starts Here-->
    <?php
                for ($i = 0; $i < $totalrecords; $i++) {
    ?>
                    <div class="htmltooltip2">
        <?php if ($this->rs_playlist1[1][$i]->description) {
        ?>
                        <p class="tooltip_discrip"><?php echo JHTML::_('string.truncate', (strip_tags($this->rs_playlist1[1][$i]->description)), 120); ?></p>
        <?php } ?>
                    <div class="tooltip_category_left">
                        <span class="title_category"><?php echo JText::_('HDVS_CATEGORY'); ?>: </span>
                        <span class="show_category"><?php echo $this->rs_playlist1[1][$i]->category; ?></span>
                    </div>
        <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
        ?>
                        <div class="tooltip_views_right">
                            <span class="view_txt"><?php echo JText::_('HDVS_VIEWS'); ?>: </span>
                            <span class="view_count"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?> </span>
                        </div>
                        <div id="htmltooltipwrapper2<?php echo $i; ?>">
                            <div class="chat-bubble-arrow-border"></div>
                            <div class="chat-bubble-arrow"></div>
                        </div>
                        <?php } ?>
                    </div>
    <?php
                } ?>
                <!--Tooltip end Here-->
    <?php
            }
        }
    ?>
        <!-- Code end here for Recent videos in home page display -->
    </div>
<?php
    }
?>