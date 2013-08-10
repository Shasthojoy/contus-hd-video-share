<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Channel videos View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = & JFactory::getUser();
$session = & JFactory::getSession();
$editing = '';
if ($user->get('id') == '')
{
    $url = $baseurl . "index.php?option=com_user&view=register";
    header("Location: $url");
}
$type=$htmlCode='';
ob_clean();
?>

<?php $channelVideo = JRequest::getVar('channel_videos');
if(isset($channelVideo) && $channelVideo == "playlist") {?>
<div id="popular_videos" class="channelpage_shotvidos">
                 <div id="video-grid-container"> <ul class="ulvideo_thumb clearfix">
                <?php		if(isset($this->channelvideos)) {
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {

                                                        if (($i % $this->channelvideorowcol[0]->video_colomn) == 0)
                                                            {
?>
                                                            <div class="clear"></div>
                                                      <?php } ?>
                                                     <?php
                                                        if ($this->channelvideos[$i][0]->filepath == "File" || $this->channelvideos[$i][0]->filepath == "FFmpeg")
                                                            $src_path = JURI::base()."components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                                        if ($this->channelvideos[$i][0]->filepath == "Url" || $this->channelvideos[$i][0]->filepath == "Youtube"){
                                                            $src_path = $this->channelvideos[$i][0]->thumburl;
                                                            if($src_path=='components/com_contushdvideoshare/images/default_thumb.jpg')
                                                                $src_path=JURI::base().'components/com_contushdvideoshare/images/default_thumb.jpg';
                                                        }
                                                        ?>
<?php
                                                        $oriname = $this->channelvideos[$i][0]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);
                                                        $orititle = $this->channelvideos[$i][0]->title;
                                                        $newtitle = explode(' ', $orititle);
                                                        $displaytitle = implode('-', $newtitle);
                                                        $final = explode('-', $displaytitle);
                                                        $final1 = implode(' ', $final);
                                                        $final2 = explode('and', $final1);
                                                        $displaytitle11 = implode('&', $final2);
?>

                                                           <li class="video-item sort-videos">
                                                               <?php if (preg_match('/vimeo/', $this->channelvideos[$i][0]->videourl)) {
                                  $split=explode("/",$this->channelvideos[$i][0]->videourl);
                                  $vimeoid = $split[3];
                                                    }else {
                                                    $vimeoid = 0; }

    if ($this->channelvideos[$i][0]->filepath == "File" || $this->channelvideos[$i][0]->filepath == "FFmpeg"){

        $htmlCode = $this->channelvideos[$i][0]->vid ;
        $type= 'file';

        } elseif ($this->channelvideos[$i][0]->filepath == "Youtube")
            {
               if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $this->channelvideos[$i][0]->videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
                } else {
                	$videoid = 0;
                }
        $htmlCode = $videoid;
        $type = "youtube";
           }
                                                    ?>
                                                            <?php if(JRequest::getVar('channelid')) {
                                                            $channelId = JRequest::getVar('channelid')?>
                                                                                                                  <a class=" info_hover featured_vidimg" onclick="relatedvideos('<?php echo $this->channelvideos[$i][0]->vid;?>','<?php echo $vimeoid;?>','<?php echo $htmlCode;?>','<?php echo $type;?>','<?php echo $this->channelvideos[$i][0]->times_viewed; ?>','<?php echo date("m-d-Y", strtotime($this->channelvideos[$i][0]->created_date)); ?>','<?php echo $this->channelvideos[$i][0]->ratecount; ?>','<?php echo $this->channelvideos[$i][0]->title; ?>','<?php echo $this->channelvideos[$i][0]->rate; ?>');" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0" title="" alt="thumb_image" /></a>
      <?php }else {?>
                                                            <a class=" info_hover featured_vidimg" onclick="relatedvideos('<?php echo $this->channelvideos[$i][0]->vid;?>','<?php echo $vimeoid;?>','<?php echo $htmlCode;?>','<?php echo $type;?>','<?php echo $this->channelvideos[$i][0]->times_viewed; ?>','<?php echo date("m-d-Y", strtotime($this->channelvideos[$i][0]->created_date)); ?>','<?php echo $this->channelvideos[$i][0]->ratecount; ?>','<?php echo $this->channelvideos[$i][0]->title; ?>','<?php echo $this->channelvideos[$i][0]->rate; ?>');"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0" title="" alt="thumb_image" /></a>
                                                            <?php }?>
                                                        <div class="show-title-container" >
                                                                <a href = "" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->channelvideos[$i][0]->title) > 40)
                                                        {
                                                            echo (substr($this->channelvideos[$i][0]->title, 0,40)) . "...";
                                                        }
                                                        else
                                                        {
                                                            echo $this->channelvideos[$i][0]->title;
                                                        }
?></a>
                                                       </div>
<!--                                                <span class="video-info">
                                                      <?php echo $this->channelvideos[$i][0]->category; ?>
                                                </span>-->
                                                <div class="clsratingvalue">
                                                    <?php if ($this->sitesettings[0]->ratingscontrol == 1)
                                                           { ?>
                                                 <?php
                                                        if (isset($this->channelvideos[$i][0]->ratecount) && $this->channelvideos[$i][0]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->channelvideos[$i][0]->rate / $this->channelvideos[$i][0]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                            <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                                                   <?php } ?>
                                             </div>
                                                            <?php if ($this->sitesettings[0]->viewedconrtol == 1)
                                                           { ?>
                                             <span id="views_fea" class="floatright viewcolor"><?php echo $this->channelvideos[$i][0]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                                             <?php } ?>
                                              
                                                    </li>
                                             <?php $j++; ?>
                                               
<?php
                                                    }
?><div class="clear"></div>
 </ul></div></div>
<ul class="hd_pagination">
<?php
$channel_id = $this->channelId;
 $page_rows = $this->channelvideorowcol[0]->video_row * $this->channelvideorowcol[0]->video_colomn;
 //$page_rows = 2;
 $rows = $this->myplaylist;
 $last = ceil($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
    <li><a onclick="ajaxpagination('<?php echo $prev;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo 'prev';?></a></li>
 <?php } 
 if($last > 1) {
 for($i=1;$i<=$last;$i++) { ?>
    <li><a class="<?php if($i == $curr_page) {echo 'activepage';}?>" onclick="ajaxpagination('<?php echo $i;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo $i;?></a></li>
<?php  }
 }
if($curr_page < $last) {
 ?>
    <li><a onclick="ajaxpagination('<?php echo $next;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id?>');"><?php echo 'next';?></a></li>
 <?php }?>
 </ul>
<?php } else {?>
<div class="hd_norecords_found">No Videos</div>
<?php }?>
                                       
<?php }else {?>

      <div id="popular_videos" class="channelpage_shotvidos">
          <div id="video-grid-container"><ul class="ulvideo_thumb clearfix">
<?php		if(isset($this->channelvideos)) {
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {

                                                        if (($i % $this->channelvideorowcol[0]->video_colomn) == 0)
                                                            {
?>
                                                            <div class="clear"></div>
                                                      <?php } ?>
                                                            
                                        <?php
                                                        if ($this->channelvideos[$i]->filepath == "File" || $this->channelvideos[$i]->filepath == "FFmpeg")
                                                            $src_path = JURI::base()."components/com_contushdvideoshare/videos/" . $this->channelvideos[$i]->thumburl;
                                                         if ($this->channelvideos[$i]->filepath == "Url" || $this->channelvideos[$i]->filepath == "Youtube"){
                                                            $src_path = $this->channelvideos[$i]->thumburl;
                                                            if($src_path=='components/com_contushdvideoshare/images/default_thumb.jpg')
                                                                $src_path=JURI::base().'components/com_contushdvideoshare/images/default_thumb.jpg';
                                                        }
                                        ?>
<?php
                                                        $oriname = $this->channelvideos[$i]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);
                                                        $orititle = $this->channelvideos[$i]->title;
                                                        $newtitle = explode(' ', $orititle);
                                                        $displaytitle = implode('-', $newtitle);
                                                        $final = explode('-', $displaytitle);
                                                        $final1 = implode(' ', $final);
                                                        $final2 = explode('and', $final1);
                                                        $displaytitle11 = implode('&', $final2);
                                                        $type  ='';
?>

                                                        <li class="video-item sort-videos">
                                                         <?php if (preg_match('/vimeo/', $this->channelvideos[$i]->videourl)) {
										    	      $split=explode("/",$this->channelvideos[$i]->videourl);
										    	      $vimeoid = $split[3];
                                                    }else {
                                                    $vimeoid = 0; }

    if ($this->channelvideos[$i]->filepath == "File" || $this->channelvideos[$i]->filepath == "FFmpeg"){

        $htmlCode = $this->channelvideos[$i]->vid ;
        $type= 'file';

        } elseif ($this->channelvideos[$i]->filepath == "Youtube")
            {
               if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $this->channelvideos[$i]->videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
                } else {
                	$videoid = 0;
                }
        $htmlCode = $videoid;
        $type = "youtube";
           }
                                                    ?>
                                          <a class=" info_hover featured_vidimg" onclick="relatedvideos('<?php echo $this->channelvideos[$i]->vid;?>','<?php echo $vimeoid;?>','<?php echo $htmlCode;?>','<?php echo $type;?>','<?php echo $this->channelvideos[$i]->times_viewed; ?>','<?php echo date("m-d-Y", strtotime($this->channelvideos[$i]->created_date)); ?>','<?php echo $this->channelvideos[$i]->ratecount; ?>','<?php echo $this->channelvideos[$i]->title; ?>','<?php echo $this->channelvideos[$i]->rate; ?>');"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0" title="" alt="video" /></a>
                                              <div class="show-title-container" style="font-weight: bold;">
                                                <a href = "" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->channelvideos[$i]->title) > 40)
                                                        {
                                                            echo (substr($this->channelvideos[$i]->title, 0, 40)) . "...";
                                                        }
                                                        else
                                                        {
                                                            echo $this->channelvideos[$i]->title;
                                                        }
?></a>
                                                </div>
<!--                                                <span class="video-info">
                                                     <?php echo $this->channelvideos[$i]->category; ?>
                                                </span>-->
                                                <div class="clsratingvalue">
                                                    <?php if ($this->sitesettings[0]->ratingscontrol == 1)
                                                           { ?>
                                                

                                                <?php
                                                        if (isset($this->channelvideos[$i]->ratecount) && $this->channelvideos[$i]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->channelvideos[$i]->rate / $this->channelvideos[$i]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                    <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                                                    
                                                    <?php } ?>
                                             </div>
                                          <?php if ($this->sitesettings[0]->viewedconrtol == 1)
                                                           { ?>
                                             <span id="views_pop" class="floatright viewcolor"><?php echo $this->channelvideos[$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                                             <?php } ?>
                                                        </li>
<?php $j++; ?>
                                              
<?php
                                                    }
?><div class="clear"></div>
</ul></div></div>
<ul class="hd_pagination">
<?php
$channel_id = $this->channelId;
 $page_rows = $this->channelvideorowcol[0]->video_row * $this->channelvideorowcol[0]->video_colomn; 
 $rows = $this->myvideos;
 $last = ceil($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
    <li><a onclick="ajaxpagination('<?php echo $prev;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo 'prev';?></a></li>
 <?php }
 if($last > 1) {
  for($i=1;$i<=$last;$i++) { ?>
    <li><a class="<?php if($i == $curr_page) {echo 'activepage';}?>" onclick="ajaxpagination('<?php echo $i;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo $i;?></a></li>
<?php  }
 }
if($curr_page < $last) {
 ?>
    <li><a onclick="ajaxpagination('<?php echo $next;?>','<?php echo JRequest::getVar('channel_videos');?>','<?php echo $channel_id;?>');"><?php echo 'next';?></a></li>
 <?php }?>
 </ul>
<?php } else {?>
<div class="hd_norecords_found">No Videos</div>
<?php }?>
                                         
                                        <?php }exit();?>


