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
 * @abstract      : Contushdvideoshare Component Mychannel View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
//check login or not
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$playerpath = JURI::base() . "components/com_contushdvideoshare/hdflvplayer/hdplayer.swf";
$user = JFactory::getUser();
$session = JFactory::getSession();
$editing = '';
$editor = JFactory::getEditor();
$mobile = detect_mobile();
$baseurl = JURI::base();
if ($user->get('id') == '')
{
    if(version_compare(JVERSION,'1.6.0','ge'))
      {
	$url = $baseurl . "index.php?option=com_users&view=login";
	header("Location: $url");
      }else {
        $url = $baseurl . "index.php?option=com_user&view=login";
	header("Location: $url");
      }
}

// add js file
$document = JFactory::getDocument();
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/autoHeight.js' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/mychannel.js' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/membervalidator.js' );
?>
<?php
if (JRequest::getVar('url', '', 'post', 'string'))
{
	$video = new videourl();
	$vurl = JRequest::getVar('url', '', 'post', 'string');
	$video->getVideoType($vurl);
	$description = $video->catchData($vurl);
	$imgurl = $video->imgURL($vurl);
}

?>
<?php if(isset($this->channeldetails[0])) {
		$channelDetails = $this->channeldetails[0];
	}?>
<?php

	if ($user->get('id') != '')
	{
		     if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <div class="toprightmenu">
                    <a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo JText::_('HDVS_MY_CHANNEL'); ?></a> |
                    <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo JText::_('HDVS_MY_PLAYLIST'); ?></a> |
                    <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo JText::_('HDVS_CHANNEL_SETTINGS'); ?></a> |
                    <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
                    <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
                    </div>
            <?php }else { ?>
                <div class="toprightmenu">
                <a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo JText::_('HDVS_MY_CHANNEL'); ?></a> |
                <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo JText::_('HDVS_MY_PLAYLIST'); ?></a> |
                <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo JText::_('HDVS_CHANNEL_SETTINGS'); ?></a> |
                <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
                <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
                </div>
           <?php  }?>



		<?php } else
		{if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><div class="toprightmenu">
            <a href="index.php?option=com_users&view=registration"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
            <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
        </div>
           <?php }  else {      ?>
                    <div class="toprightmenu">
                        <a href="index.php?option=com_user&view=register"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
                        <a  href="index.php?option=com_user&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
                    </div>
        <?php
                }
			?>

			<?php
		}



?>
<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

<form name="myform" action="" method="post" id="login-form">
	<div class="logout-button">
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $logoutval_2; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript"></script>
<div class="player clearfix">
 <div class="channelpage_title clearfix">
    <?php
if(isset($this->channelvideorowcol[0]->logo) && $this->channelvideorowcol[0]->logo) {?>
    <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/<?php echo $this->channelvideorowcol[0]->logo;?>" alt="logo" />
    <?php } else {?>
	<img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/mychannel_logo.jpg" alt="logo" />
   <?php }
   if(isset($channelDetails->channel_name) && $channelDetails->channel_name) {?>
<h2 class="imgtit"><?php echo $channelDetails->channel_name;?></h2>
<?php } else {?>
<h2 class="imgtit"><?php if(isset($this->channelname)) echo $this->channelname;?></h2>
<?php }?>
</div>
<?php
if(isset($this->frontvideodetails[0])) {
if(isset($this->channelvideorowcol[0]) && $this->frontvideodetails[0]->published==1) {?>
	<div id="videoplayer">

		<?php if(isset($this->frontvideodetails[0])) {
			$frontVideo = $this->frontvideodetails[0]->id;
			if(JRequest::getVar('title')) {
				$frontVideo = $this->videoid;
			}

                         $width = $this->channelvideorowcol[0]->player_width;
			$height = $this->channelvideorowcol[0]->player_height;
if($mobile === true){
   if ($this->frontvideodetails[0]->filepath == "File" || $this->frontvideodetails[0]->filepath == "FFmpeg"){?>
    <video id="video" src="<?php echo $frontVideo; ?>"  autobuffer controls onerror="failed(event)" width="701" height="303">
             Html5 Not support This video Format.
     </video>
   <?php } elseif ($this->frontvideodetails[0]->filepath == "Youtube")
            {
               if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $this->frontvideodetails[0]->videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
                }
?>
               <iframe  type="text/html" width="<?php echo $width;?>" height="<?php echo $height;?>" src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0">
               </iframe>
<?php
           }
}else{

                        if($this->channelvideorowcol[0]->start_videotype == 1) {
			if (preg_match('/vimeo/', $this->frontvideodetails[0]->videourl)) {
				$split=explode("/",$this->frontvideodetails[0]->videourl);?>
		<iframe
			src="http://player.vimeo.com/video/<?php echo $split[3];?>?title=0&amp;byline=0&amp;portrait=0"
			width="<?php echo $width;?>" height="<?php echo $height;?>"
			frameborder="0" webkitAllowFullScreen mozallowfullscreen
			allowFullScreen></iframe>
			<?php } else {?>
			<embed src="<?php echo $playerpath;?>" flashvars="catid=-1&id=<?php echo $frontVideo;?>&baserefJ=<?php echo JURI::base(); ?>&autoplay=true&showPlaylist=true" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>
		<?php } } else {?>
			<embed src="<?php echo $playerpath;?>" flashvars="id=<?php echo $frontVideo;?>&catid=<?php echo $this->channelvideorowcol[0]->start_playlist;?>&baserefJ=<?php echo JURI::base(); ?>&autoplay=true" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>
            <?php } }?>
	</div>
	<script type="text/javascript">
    function relatedvideos(vid,vimeoid,htmlcode,vtype,views,created_date,ratecount,title,rate){
        <?php if($mobile === true){?>
                if(vtype =='file')
                    {
var playerCode ='<video id="video" src="'+htmlcode+'"  autobuffer controls onerror="failed(event)" width="600" height="400">Html5 Not support This video Format.</video>';
                    }
            else if(vtype =='youtube')
                    {
var playerCode ="<iframe type='text/html' width='600' height='400' src='http://www.youtube.com/embed/"+htmlcode+"' frameborder='0'></iframe>";
                    }

<?php }else{?>
var rate_count=Math.round(rate/ratecount);

if(document.getElementById("views"))
        document.getElementById("views").innerHTML=views;
                document.getElementById("viewtitle").innerHTML=title;
        document.getElementById("video_id").value=vid;
        document.getElementById("createdate").innerHTML=created_date;
        document.getElementById("storeratemsg").value=ratecount;
        ratecal(rate_count,views);
         if(document.getElementById("a"))
        document.getElementById('a').style.display="none";
     if(document.getElementById("rate"))
        document.getElementById('rate').style.display="block";
     if(document.getElementById("ratemsg"))
        document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> "+ratecount;
    	var baseurl = '<?php echo JURI::base()?>';
        var playerpath = '<?php echo $playerpath;?>';
    	var width = '<?php echo $width;?>';
    	var height = '<?php echo $height;?>';
    	if(vimeoid == 0) {
                //var playerCode = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\" width="+ width+" height="+ height+"><param name=\"movie\" value="+ playerpath+" /><param name=\"flashvars\" value=\"id="+ vid+"&baserefJ="+ baseurl+"&autoplay=false\" /><param name=\"allowFullScreen\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /><param name=\"allowscriptaccess\" value=\"always\" /><embed src=\""+ playerpath+"\" flashvars=\"id="+ vid+"&baserefJ="+ baseurl+"&autoplay=false\" style=\"width:"+ width+"px;height:"+ height+"px\" allowFullScreen=\"true\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\" wmode=\"transparent\"></embed></object>";
               var playerCode = "<embed src=\""+ playerpath+"\" flashvars=\"id="+ vid+"&baserefJ="+ baseurl+"&autoplay=true\" style=\"width:"+ width+"px;height:"+ height+"px\" allowFullScreen=\"true\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\" wmode=\"transparent\"></embed>";
    	}else {
    		var playerCode = "<iframe src=\"http://player.vimeo.com/video/"+vimeoid+"?title=0&amp;byline=0&amp;portrait=0\" width="+ width+" height="+ height+" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
		}
                <?php }?>
    	document.getElementById('videoplayer').innerHTML = playerCode;
    	}
    </script>
    <input type="hidden" id="video_id" value="">
    <div style="width:<?php if(isset ($width)) { echo $width;} ?>px;" class="playerpage_botom_details">
		        <?php if($this->sitesettings[0]->ratingscontrol == 1) {?>
			         <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();"contentEditable='false' unselectable='true'>
				         <div id="a" class="floatleft"></div>
							<?php
							if (isset($this->frontvideodetails[0]->ratecount) && $this->frontvideodetails[0]->ratecount != 0)
							{
								$ratestar = round($this->frontvideodetails[0]->rate / $this->frontvideodetails[0]->ratecount);
								$ratecount = $this->frontvideodetails[0]->ratecount;
							}
							else
							{
								$ratestar = 0;
								$ratecount = 0;
							}
							?>
		                         <ul class="ratethis " id="rate" >
                    <li class="one" >
                        <a title="<?php echo JText::_('HDVS_ONE_STAR_RATING'); ?>"  onclick="getrate('1');"  onmousemove="displayrating('1');" onmouseout="resetvalue();">1</a>
                    </li>
                    <li class="two" >
                        <a title="<?php echo JText::_('HDVS_TWO_STAR_RATING'); ?>"  onclick="getrate('2');"  onmousemove="displayrating('2');" onmouseout="resetvalue();">2</a>
                    </li>
                    <li class="three" >
                        <a title="<?php echo JText::_('HDVS_THREE_STAR_RATING'); ?>"  onclick="getrate('3');"   onmousemove="displayrating('3');" onmouseout="resetvalue();">3</a>
                    </li>
                    <li class="four" >
                        <a  title="<?php echo JText::_('HDVS_FOUR_STAR_RATING'); ?>"  onclick="getrate('4');"  onmousemove="displayrating('4');" onmouseout="resetvalue();"  >4</a>
                    </li>
                    <li class="five" >
                        <a title="<?php echo JText::_('HDVS_FIVE_STAR_RATING'); ?>"  onclick="getrate('5');"  onmousemove="displayrating('5');" onmouseout="resetvalue();" >5</a>
                    </li>
                </ul>
                                         <input type="hidden" name="id" id="id" value="<?php if (isset($this->frontvideodetails[0]->id) && $this->frontvideodetails[0]->id != '')
                    echo $this->frontvideodetails[0]->id; else
                    echo $this->getfeatured->id; ?>" />
                        </div>

   <div class="rateright-views floatleft" >
                <span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();"> </span>
                <span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();">  </span>
            </div>
 									 <?php }?>

                               <div class="video_addedon">
                                <?php if($this->sitesettings[0]->viewedconrtol == 1) {?>
                              <span><b><?php echo JText::_('HDVS_VIEWS');?> : </b></span><span id="views"><?php echo $this->frontvideodetails[0]->times_viewed; ?></span>
                                <?php } ?>
				<span class="addedon"><b><?php echo JText::_('HDVS_ADDED_ON');?> : </b></span><span id="createdate"><?php echo date("m-d-Y", strtotime($this->frontvideodetails[0]->created_date)); ?></span>
				</div>


	</div>
<?php } else {?>
<div class="novideo"><?php echo JText::_('HDVS_FRONTEND_MSG');?></div>
<?php }
if ($this->frontvideodetails[0]->filepath == "File" || $this->frontvideodetails[0]->filepath == "FFmpeg") {
                    $current_path = "components/com_contushdvideoshare/videos/";
                    $video_url = JURI::base() . $current_path . $this->frontvideodetails[0]->videourl;
                    $video_thumb = JURI::base() . $current_path .$this->frontvideodetails[0]->thumburl;
                    $video_preview = JURI::base() . $current_path .$this->frontvideodetails[0]->previewurl;

                    } else {
                         $video_url = $this->frontvideodetails[0]->videourl;
                         $video_thumb = $this->frontvideodetails[0]->thumburl;
                         $video_preview = $this->frontvideodetails[0]->previewurl;
                    }
$pageURL = str_replace('&', '%26', JURI::getInstance()->toString());
?>
<h2 id="viewtitle" class="user_channel_title"><?php echo $this->frontvideodetails[0]->title; ?></h2>
        <div class="sharing_vid clearfix">
        <div id="share_like">
            <?php
                            $url_fb = "http://www.facebook.com/sharer/sharer.php?s=100&p%5Btitle%5D=".$this->frontvideodetails[0]->title."&p%5Bsummary%5D=".$this->frontvideodetails[0]->description."&p%5Bmedium%5D=103&p%5Bvideo%5D%5Bwidth%5D=".$width."&p%5Bvideo%5D%5Bheight%5D=".$height."&p%5Bvideo%5D%5Bsrc%5D=". urlencode($playerpath) ."%3Ffile%3D".urlencode($video_url)."%26embedplayer%3Dtrue%26share%3Dfalse%26HD_default%3Dtrue%26autoplay%3Dtrue%26skin_autohide%3Dtrue%26showPlaylist%3Dfalse%26id%3D".$this->frontvideodetails[0]->id."%26baserefJ%3D".urlencode(JURI::base())."&p%5Burl%5D=".urlencode($pageURL)."&p%5Bimages%5D%5B0%5D=".urlencode($video_thumb);
                            ?>
                            <div id="fb-root" class="floatleft">
                                <div style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div>
                            </div>
                            <a href="<?php echo $url_fb; ?>" class="fbshare" id="fbshare" target="_blank" ></a>
                            <div class="floatleft">
                                <a href="" data-count="horizontal" id="twshare" target="_blank"><img alt="" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/twitter-icon.png" width="16" height="16" />Tweet</a>
                            </div>

                            <!-- Google plus one Start -->
                            <div class="floatleft google-plus">
                                <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                                <div class="g-plusone" data-size="medium" data-count="true"></div>
                            </div>

                            <script src="http://connect.facebook.net/en_US/all.js"></script>
                            <!-- layout=button_count&amp; -->
                            <?php $pageURL = str_replace('&', '%26', JURI::getInstance()->toString()); ?>
                            <iframe class="facebook_hdlike" src="http://www.facebook.com/plugins/like.php?href=<?php echo $pageURL; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0"  allowTransparency="true"> </iframe>
                       </div></div>
    <div class="clear"></div>
	<?php if(isset($this->channelvideorowcol[0]->fb_comment) && $this->channelvideorowcol[0]->fb_comment == 1 && isset($this->frontvideodetails[0])) {?>

    <div class="fbcomments" id="theFacebookComment">
                        <h1><?php echo JText::_('HDVS_ADD_YOUR_COMMENTS'); ?></h1>
                        <?php $facebookapi = '';
                        if(isset($this->sitesettings[0]->facebookapi)) {
                        	$facebookapi = $this->sitesettings[0]->facebookapi; }
                                $style = '#face-comments iframe{width:  '.$width.'px !important; }';
                                $document->addStyleDeclaration( $style );
                        ?>
                        <div id ="face-comments">
                            <script type="text/javascript">
                            window.fbAsyncInit = function() {
                                FB.init({
                                    appId  : "<?php echo $facebookapi; ?>",
                                    status : true, // check login status
                                    cookie : true, // enable cookies to allow the server to access the session
                                    xfbml  : true  // parse XFBML
                                });
                            };
                            (function() {
                                var e = document.createElement('script');
                                e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                                e.async = true;
                                document.getElementById('face-comments').appendChild(e);
                            }());
                        </script>
                            <fb:comments xid="<?php if(isset ($this->frontvideodetails[0])) { echo $this->frontvideodetails[0]->id;} ?>" css="facebook_style.css" simple="1" href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="<?php if(isset ($width)) { echo $width;} ?>" ></fb:comments>
                        </div>
    </div>

	<?php }} } else {?>
	<div class="novideo"><?php echo JText::_('HDVS_CHANNEL_ALERT');?></div></div>
	<?php }?>

	<?php $channelId = '';
	if(JRequest::getVar('channelname')) {
		$channelId = $this->channelId;
	}else {
		$channelId = '';
	}
	?>
        <div id="clstabmenu">
            <script type="text/javascript">
                var startno = 1001;
<?php if (isset($this->channelvideorowcol[0]->popular_videos) && $this->channelvideorowcol[0]->popular_videos == 1) { ?>
                    startno = 1001;
<?php } elseif (isset($this->channelvideorowcol[0]->recent_videos) && $this->channelvideorowcol[0]->recent_videos == 1) { ?>
                   startno = 1002;
<?php } elseif (isset($this->channelvideorowcol[0]->top_videos) && $this->channelvideorowcol[0]->top_videos == 1) { ?>
                    startno = 1003;
<?php } else {?>
    startno = 1004;
    <?php }?>

            </script>
            <?php
            if(isset($this->channelvideorowcol[0]->popular_videos) || isset($this->channelvideorowcol[0]->recent_videos) || isset($this->channelvideorowcol[0]->top_videos) || isset($this->channelvideorowcol[0]->playlist)) {
            if($this->channelvideorowcol[0]->popular_videos == 1 || $this->channelvideorowcol[0]->recent_videos == 1 || $this->channelvideorowcol[0]->top_videos == 1 || $this->channelvideorowcol[0]->playlist) {?>

            <h1><?php echo JText::_('HDVS_SORT_VIDEOS');?></h1>
            <?php if(isset($this->channelvideorowcol[0]->popular_videos) && $this->channelvideorowcol[0]->popular_videos == 1) {?>
            <button class="button" id="1001" type="button" style="cursor: pointer"
			onclick="channelvideos('popular','<?php echo $channelId?>','1001',startno)"><?php echo JText::_('HDVS_POPULAR_VIDEOS');?></button>
			<?php } if(isset($this->channelvideorowcol[0]->recent_videos) && $this->channelvideorowcol[0]->recent_videos == 1) {?>
		<button class="button" id="1002" type="button" style="cursor: pointer"
			onclick="channelvideos('recent','<?php echo $channelId?>','1002',startno)"><?php echo JText::_('HDVS_RECENT_VIDEOS');?></button>
			<?php } if(isset($this->channelvideorowcol[0]->top_videos) && $this->channelvideorowcol[0]->top_videos == 1) {?>
		<button class="button" id="1003" type="button" style="cursor: pointer"
			onclick="channelvideos('toprated','<?php echo $channelId?>','1003',startno)"><?php echo JText::_('HDVS_TOPRATED_VIDEOS');?></button>
			<?php } if(isset($this->channelvideorowcol[0]->playlist) && $this->channelvideorowcol[0]->playlist == 1) {?>
		<button class="button" id="1004" type="button" style="cursor: pointer"
			onclick="channelvideos('playlist','<?php echo $channelId?>','1004',startno)"><?php echo JText::_('HDVS_MY_PLAYLISTS');?></button>
			<?php }?>

	</div>

        <div id="channel_videos">
	<script type="text/javascript">
            <?php if($this->channelvideorowcol[0]->popular_videos == 1) {?>
	channelvideos('popular','<?php echo $channelId;?>','1001',startno);
        <?php } elseif($this->channelvideorowcol[0]->recent_videos == 1) {?>
            channelvideos('recent','<?php echo $channelId?>','1002',startno);
            <?php } elseif($this->channelvideorowcol[0]->top_videos == 1) {?>
                channelvideos('toprated','<?php echo $channelId?>','1003',startno);
                <?php } elseif($this->channelvideorowcol[0]->playlist == 1) {?>
                    channelvideos('playlist','<?php echo $channelId?>','1004',startno);
                    <?php }?>
	</script>
	</div>
<?php
}
}?>
        <?php if(isset($channelDetails)) {?>
			<div class="description_display">

				<h1><?php echo JText::_('HDVS_DESCRIPTION');?></h1>
				<?php if(isset($channelDetails->description)) { echo $channelDetails->description; }?>
			</div>
			<?php } ?>
	<div class="clear"></div>
	<div class="channeldetails">
        <div class="channelhead">
        <h2> <?php echo JText::_('HDVS_CHANNEL_DETAILS');?></h2>
        <?php if(!JRequest::getVar('channelname')) {?>
	<button class="button" type="button" id="editbtn" onclick="editchannel()"><?php echo JText::_('HDVS_EDIT');?></button>
        <?php }?>
	</div>
		<div class="clearfix"></div>
            <div id="msg_channel_details" style="display: none"></div>
            <ul id="channel_details">
            <?php if(isset($channelDetails)) {?>

                                        <li class="bot_dot1">
                                                <span class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_NAME');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->channel_name)) { echo $channelDetails->channel_name; }?></span>
					</li>
                                        <li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_VIEWS');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->channel_views)) { echo $channelDetails->channel_views; }?></span>
					</li>
                                        <li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_TOTAL_UPLOADS');?> :</span>
						<span class="rightdiv"><?php if(isset($this->totaluploads)) { echo $this->totaluploads; }?></span>
					</li>
                                         <li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_RECENT_ACTIVITY');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->updated_date)) {echo date('M d,y H:i',strtotime($channelDetails->updated_date)); }?></span>
					</li>
                                        <li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_ABOUT_ME');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->about_me)) { echo $channelDetails->about_me; }?></span>
					</li>
                                         <li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_TAGS');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->tags)) { echo $channelDetails->tags; }?></span>
						</li>
					<li class="bot_dot1">
						<span class="leftdiv"><?php echo JText::_('HDVS_WEBSITE');?> :</span>
						<span class="rightdiv"><?php if(isset($channelDetails->website)) { echo $channelDetails->website; }?></span>
				       </li>

			<?php } else{?>

                    <li class="bot_dot1">
                        <span class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_VIEWS');?> :</span>
			<span class="rightdiv">0</span>
                     </li>
                    <li class="bot_dot1">
                        <span class="leftdiv"><?php echo JText::_('HDVS_TOTAL_UPLOADS');?> :</span>
                        <span class="rightdiv">0</span>
                    </li>
                     <li class="bot_dot1">
                         <span class="leftdiv"><?php echo JText::_('HDVS_RECENT_ACTIVITY');?> :</span>
			 <span class="rightdiv">0</span>
                     </li>

			<?php }?>
<script type="text/javascript">
function editchannel() {
	document.getElementById('msg_channel_details').style.display = "none";
	if(document.getElementById('edit_channel').style.display == "none") {
	document.getElementById('edit_channel').style.display = "block";
	document.getElementById('channel_details').style.display = "none";
        document.getElementById('editbtn').style.display = "none";
	}
}
function searchchannel() {
	if(document.getElementById('search_channel').style.display == "none") {
	document.getElementById('search_channel').style.display = "block";
         document.getElementById('cancel_search').style.display = "none";
	}
}
function cancelChannel() {
	document.getElementById('search_channel').style.display = "none";
        document.getElementById('cancel_search').style.display = "block";
        document.getElementById('output').style.display = "none";

}
function cancelChanneldetail() {
	document.getElementById('msg_channel_details').style.display = "none";
    document.getElementById('edit_channel').style.display = "none";
    document.getElementById('channel_details').style.display = "block";
    document.getElementById('editbtn').style.display = "block";
}
</script>
                     <script type="text/javascript">
function fachannel(id,chname){
    document.getElementById('channel_id').value=id;
    document.getElementById('channelname').value=chname;
}
</script>
                    </ul>
                <ul id="edit_channel" style="display: none;">
                  <li class="bot_dot1">
                   <span class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_NAME');?></span>
                    <span class="rightdiv"><input type="text" id="channel_name" name="channel_name" value="<?php if(isset($channelDetails->channel_name)) { echo $channelDetails->channel_name; }?>" /></span>
		  </li>
		  <li class="bot_dot1">
		   <span class="leftdiv"><?php echo JText::_('HDVS_DESCRIPTION');?></span>
			<div class="rightdiv">
                              <div id="clsinsertbtns">
                                                <?php
					if(isset($channelDetails->description))	{
						$channelDescription = $channelDetails->description;
					}	else {
						$channelDescription = '';
					}
				 echo $editor->display( 'description',  $channelDescription , '100%', '300', '75', '20',false ) ;?>
                                            </div></div>
		   </li>
                    <li class="bot_dot1">
                        <span class="leftdiv"><?php echo JText::_('HDVS_ABOUT_ME');?></span>
                        <span class="rightdiv"><textarea name="about_me" id="about_me" ><?php if(isset($channelDetails->about_me)) { echo $channelDetails->about_me; }?></textarea></span>
		    </li>
                    <li class="bot_dot1">
                        <span class="leftdiv"><?php echo JText::_('HDVS_TAGS');?></span>
			<span class="rightdiv"><textarea name="tags" id="tags" rows="2" cols="20"><?php if(isset($channelDetails->tags)) { echo $channelDetails->tags; }?></textarea><!--Separated by space--></span>
		    </li>
                    <li class="bot_dot1">
                      <span class="leftdiv"><?php echo JText::_('HDVS_WEBSITE');?></span>
                      <span class="rightdiv"><input type="text" id="website" name="website" 	value="<?php if(isset($channelDetails->website)) { echo $channelDetails->website; }?>" /></span>
		   </li>
		   <li class="bot_dot1">
                    <button class="button floatright" type="button" onclick="cancelChanneldetail();"><?php echo JText::_('HDVS_CANCEL');?></button>
                    <button style="margin-right:10px;"  class="button floatright" type="button" onclick="return editChanneldetail();"><?php echo JText::_('HDVS_SAVE');?></button>
		   </li>
                  </ul>
        </div>

		<div id="edit_channeldetails"></div>
		<input type="hidden" name="controller" value="contushdvideoshare" /> <input
			type="hidden" name="option" value="com_contushdvideoshare" /> <input
			type="hidden" name="channelid" id="channelid"
			value="<?php if(isset($channelDetails->id)) {echo $channelDetails->id; }?>" />


		<div id="other_channels">
                    <div class="channelhead"><h2><?php echo JText::_('HDVS_FAVORITE_CHANNEL');?></h2>
			<?php if(!JRequest::getVar('channelname')) {?>
				<button class="button" type="button" id="cancel_search" onclick="searchchannel()"><?php echo JText::_('HDVS_ADD');?></button>
			<?php }?>
                        </div>
			<div id="output"></div>
			<?php if(isset($this->otherchannels)) {for($i=0;$i<count($this->otherchannels);$i++) {?>
                        <div class="bot_dot2" id="<?php echo $this->otherchannels[$i]->other_channel?>"><div class="leftdiv">
                                <?php if($this->otherchannels[$i]->logo) {?>
                                <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/<?php echo $this->otherchannels[$i]->logo;?>" alt="logo" width="36" height="41" class="floatleft"/>
                                <?php } else {?>
                                <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/default_thumb.jpg" alt="logo" width="36" height="41" class="floatleft"/>
                                <?php }?>
                                <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=mychannel&channelname='.$this->otherchannels[$i]->channel_name,true); ?>" target="_blank"><?php echo $this->otherchannels[$i]->channel_name?></a>
                            </div>
                                <?php if(!JRequest::getVar('channelname')) {?>

                            <div class="rightdiv clsdeletebtn"><button class="button" type="submit" onclick="deleteChannel('<?php echo $this->otherchannels[$i]->other_channel;?>');" style=" margin-top: 10px;"><?php echo JText::_('HDVS_DELETE');?></button></div>



                                <?php }?>
                                </div>
				<?php }
			}
			?>

			<div id="search_channel" style="display: none;">
                            <div class="bot_dot3">
                               <input type="text" id="other_channel" name="other_channel" value="" />
			<button class="button searchbtn" type="submit" onclick="return otherChannel()"><?php echo JText::_('HDVS_SEARCH');?></button>
			</div>
                            <div id="channel_list"></div>
                            <div class="bot_dot3">
                                <div class="leftdiv">
                                    <button class="button applybtn" type="submit" onclick="applyChannel()"><?php echo JText::_('HDVS_APPLY');?></button>
                                    <button class="button" type="submit" onclick="cancelChannel()"><?php echo JText::_('HDVS_CANCEL');  ?></button>
						</div>
					</div>


			</div>
		</div>
                <div class="clearfix"></div>
</div>

<input type="hidden" name="id" id="id" value="">
<input type="hidden" value="" id="storeratemsg" >
	<script type="text/javascript">

function createObject()
{
var request_type;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
    request_type = new ActiveXObject("Microsoft.XMLHTTP");
}else{
    request_type = new XMLHttpRequest();
}
return request_type;
}
var http = createObject();
var nocache = 0;
 function getrate(t)
            {
                if(t=='1')
                {
                    document.getElementById('rate').className="ratethis onepos";
                    document.getElementById('a').className="ratethis onepos";
                }
                if(t=='2')
                {
                    document.getElementById('rate').className="ratethis twopos";
                    document.getElementById('a').className="ratethis twopos";
                }
                if(t=='3')
                {
                    document.getElementById('rate').className="ratethis threepos";
                    document.getElementById('a').className="ratethis threepos";
                }
                if(t=='4')
                {
                    document.getElementById('rate').className="ratethis fourpos";
                    document.getElementById('a').className="ratethis fourpos";
                }
                if(t=='5')
                {
                    document.getElementById('rate').className="ratethis fivepos";
                    document.getElementById('a').className="ratethis fivepos";
                }
                document.getElementById('rate').style.display="none";
                                document.getElementById('a').style.display="block";
                document.getElementById('ratemsg').innerHTML="Thanks for rating!";
                var id= document.getElementById('video_id').value;
                if(id==''){
                id= document.getElementById('id').value;
                }
                nocache = Math.random();
                http.open('get', '<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&amp;view=player&amp;ajaxview=&amp;id='+id+'&amp;rate='+t+'&amp;nocache = '+nocache,true);
                http.onreadystatechange = insertReply;
                http.send(null);
                document.getElementById('rate').style.visibility='disable';
            }

            function insertReply()
            {
                if(http.readyState == 4)
                {
                    document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> : </span>"+http.responseText;
                    document.getElementById('rate').className="";
                    document.getElementById('storeratemsg').value=http.responseText;
                }
            }



function resetvalue()
{

document.getElementById('ratemsg1').style.display="none";
document.getElementById('ratemsg').style.display="block";
if(document.getElementById('storeratemsg').value == '') {
                    document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> <?php echo $this->frontvideodetails[0]->ratecount; ?>";
                }else {
                    document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> : </span> "+document.getElementById('storeratemsg').value;
                }
                }
function displayrating(t)
{
if(t=='1')
{
    document.getElementById('ratemsg').innerHTML="<?php echo JText::_('HDVS_POOR'); ?>";
}
if(t=='2')
{
    document.getElementById('ratemsg').innerHTML="<?php echo JText::_('HDVS_NOTHING_SPECIAL'); ?>";
}
if(t=='3')
{
    document.getElementById('ratemsg').innerHTML="<?php echo JText::_('HDVS_WORTH_WATCHING'); ?>";
}
if(t=='4')
{
    document.getElementById('ratemsg').innerHTML="<?php echo JText::_('HDVS_PRETTY_COOL'); ?>";
}
if(t=='5')
{
    document.getElementById('ratemsg').innerHTML="<?php echo JText::_('HDVS_AWESOME'); ?>";
}
document.getElementById('ratemsg1').style.display="none";
document.getElementById('ratemsg').style.display="block";
}

        function insertReply() {
            if(http.readyState == 4){
                var url="";
                if(document.getElementById('commentoption'))
                {
                    var cmdoption=document.getElementById('commentoption').value;
                    if(cmdoption == 1)
                        {
                            document.getElementById('theFacebookComment').style.display = 'block';
                        }
                    if( cmdoption==2 || cmdoption==3 || cmdoption==4)
                    {
                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id='+id+'&cmdid='+cmdoption;
                        document.getElementById('myframe1').src=url;
                        document.getElementById('myframe1').style.display="block";
                    }
                    if(cmdoption != 0 && cmdoption != 1 && cmdoption != 3  && cmdoption != 4)
                    {
                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id='+id+'&cmdid='+cmdoption;
                        commentappendfunction(url);
                    }
                }

            }
        }

 function commentappendfunction(url)
    {

        function createObject() {
            var xmlhttp;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }else{
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }
        xmlhttp = createObject();
        var nocache = 0;
        nocache = Math.random();
        url= url+'&nocache = '+nocache;
        xmlhttp.onreadystatechange=stateChanged;
        xmlhttp.open("GET",url,true);
        xmlhttp.send(null);

    }
function ratecal(rating,ratecount)
            {
                if(document.getElementById('rate')){
                if(rating==1)
                    document.getElementById('rate').className="ratethis onepos";
                else if(rating==2)
                    document.getElementById('rate').className="ratethis twopos";
                else if(rating==3)
                    document.getElementById('rate').className="ratethis threepos";
                else if(rating==4)
                    document.getElementById('rate').className="ratethis fourpos";
                else if(rating==5)
                    document.getElementById('rate').className="ratethis fivepos";
               else{
                    document.getElementById('rate').className="ratethis nopos";
                }
                }
            if(document.getElementById('ratemsg'))
                document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> "+ratecount;
            }
<?php if (isset($ratestar) && isset($this->frontvideodetails[0]->ratecount) && isset($this->frontvideodetails[0]->times_viewed)) { ?>
                ratecal('<?php echo $ratestar; ?>','<?php echo $this->frontvideodetails[0]->ratecount; ?>','<?php echo $this->frontvideodetails[0]->times_viewed; ?>');
<?php } ?>
</script>
<input type="hidden" id="loadingimg" value="<?php echo JURI::base();?>components/com_contushdvideoshare/images/ajax-loader.gif">
<?php
function detect_mobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';

    $mobile_browser = '0';

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', $agent))
        $mobile_browser++;

    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;

    $mobile_ua = substr($agent,0,4);
    $mobile_agents = array(
                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                        'wapr','webc','winw','xda','xda-'
                        );

    if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;

    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;

    // Pre-final check to reset everything if the user is on Windows
    if(strpos($agent, 'windows') !== false)
        $mobile_browser=0;

    // But WP7 is also Windows, with a slightly different characteristic
    if(strpos($agent, 'windows phone') !== false)
        $mobile_browser++;

    if($mobile_browser>0)
        return true;
    else
        return false;
}
?>