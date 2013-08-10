<?php
/**
 * @name          : Joomla Hdvideoshare
 * @version	  : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Hdvideoshare Player View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
//No direct acesss
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$user = JFactory::getUser();
$username = $user->get('username');
$details1 = $this->detail;
$playerpath = JURI::base() . "components/com_contushdvideoshare/hdflvplayer/hdplayer.swf";
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$document = JFactory::getDocument();
$initalVideo = $this->homePageFirst;
$instance = JURI::getInstance();
$id = rand();
if ($initalVideo['filepath'] == 'File') {
    $urlPath = 'components/com_contushdvideoshare/videos/';
    $videoThumbUrl = JURI::base() . $urlPath . $initalVideo['thumburl'];
} else {
    $videoThumbUrl = $initalVideo['thumburl'];
}
$config = JFactory::getConfig();
$siteName = $config->getValue('config.sitename');
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/autoHeight.js');
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/popup.js');
if (!empty($this->videodetails) && $this->videodetails->id) {
    $document->setTitle($this->htmlVideoDetails->title);
    $document->setMetaData("keywords", $this->htmlVideoDetails->tags);
    $document->setDescription(strip_tags($this->htmlVideoDetails->description));
}
$document->addCustomTag('<meta property="og:title" content="' . $initalVideo['title'] . '"/>');
$document->addCustomTag('<meta property="og:type" content="article"/>');
$document->addCustomTag('<meta property="og:url" content="' . $instance->toString() . '?v=' . $id . '"/>');
$document->addCustomTag('<meta property="og:image" content="' . $videoThumbUrl . '"/>');
$document->addCustomTag('<meta property="og:site_name" content="' . $siteName . '"/>');
$document->addCustomTag('<meta property="og:description" content="' . strip_tags($initalVideo['description']) . '"/>');
$style = '#face-comments iframe{width:  ' . $details1[0]->width . 'px !important; }';
$document->addStyleDeclaration($style);
?>
<style type="text/css">
    #video-grid-container .ulvideo_thumb .popular_gutterwidth{margin-left:<?php echo $this->homepagebottomsettings[0]->homepopularvideowidth . 'px'; ?>}
    #video-grid-container .ulvideo_thumb .featured_gutterwidth{margin-left:<?php echo $this->homepagebottomsettings[0]->homefeaturedvideowidth . 'px'; ?>}
    #video-grid-container .ulvideo_thumb .recent_gutterwidth{margin-left:<?php echo $this->homepagebottomsettings[0]->homerecentvideowidth . 'px'; ?>}
</style>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript"></script>
<input type="hidden" name="category" value="<?php if (isset($this->videodetails->playlistid))
    echo $this->videodetails->playlistid; ?>" id="category"/>
<input type="hidden" value="<?php if (isset($this->videodetails->id))
           echo $this->videodetails->id; ?>" name="videoid" id="videoid"/>
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
<?php
        if ($details1[0]->googleana_visible == 1) {
?>
            <script type="text/javascript">
                var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
                document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
                var pageTracker = _gat._getTracker("<?php echo $details1[0]->googleanalyticsID; ?>");
                pageTracker._trackPageview();
                pageTracker._trackEvent();
            </script>
<?php } ?>
        <script type="text/javascript">
            function loadifr()
            {
                ev = document.getElementById('myframe1');
                if(ev!=null)
                {
                    setHeight(ev);
                    addEvent(ev,'load', doIframe);
                }
            }
            window.onload = function()
            {
<?php if ($this->videodetails->id) { ?>
                    setInterval("loadifr()", 500);
<?php } ?>
            }
        </script>
<?php
        if (USER_LOGIN == '1') {
            if ($user->get('id') != '') {
?>
                <div class="toprightmenu">
                    <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
    <?php
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
    ?>
                    <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
    <?php } else {
    ?>
                    <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
               <?php
                    }
                ?>
                </div>

<?php
            } else {
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $register_url = "index.php?option=com_users&view=registration";
                    $login_url = "index.php?option=com_users&view=login&return=".base64_encode('index.php?option=com_contushdvideoshare&view=player');
                } else {
                    $register_url = "index.php?option=com_user&view=register";
                    $login_url = "index.php?option=com_user&view=login&return=".base64_encode('index.php?option=com_contushdvideoshare&view=player');
                }
?>
                <div class="toprightmenu">
                    <a href="<?php echo $register_url; ?>"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
                    <a  href="<?php echo $login_url; ?>"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
                </div>
<?php
            }
        }
?>
        <!-- Component Starts Version 1.3-->
        <div class="fluid bg playerbg clearfix" id="player_page" >
            <div id="HDVideoshare1" style="position:relative;width:<?php echo $details1[0]->width; ?>px; " class="clearfix">
                <h1 id="viewtitle" class="floatleft" style="width:<?php echo $details1[0]->width; ?>px;" ><?php if(isset($this->htmlVideoDetails->title)) echo $this->htmlVideoDetails->title; ?></h1>
                <div class="clear"></div>
                <!-- Flash player Start -->
        <?php
        if (!empty($this->videodetails) && ($this->videodetails->id) && ($this->videodetails->playlistid)) {
            $baseref = '&amp;id=' . $this->videodetails->id . '&amp;catid=' . $this->videodetails->playlistid;
        } else if (!empty($this->videodetails) && $this->videodetails->id) {
            $baseref = '&amp;id=' . $this->videodetails->id;
        } else {
            $baseref = '&amp;featured=true';
        } ?>
        <?php if (!empty($this->videodetails) && (preg_match('/vimeo/', $this->videodetails->videourl)) && ($this->videodetails->videourl != '')) {
            $split = explode("/", $this->videodetails->videourl); ?>
            <script type="text/javascript">
                window.onload = function(){
                    document.getElementById('viewtitle').innerHTML='<?php echo $this->htmlVideoDetails->title; ?>';
                    document.getElementById('createdate').innerHTML='<?php echo date("m-d-Y", strtotime($this->htmlVideoDetails->created_date)); ?>';
                    document.getElementById('videoDescription').innerHTML='<?php echo $this->htmlVideoDetails->description; ?>';
                    document.getElementById('viewcount').innerHTML='<?php echo $this->htmlVideoDetails->times_viewed; ?>';
                    document.getElementById('ratemsg').innerHTML='<?php echo JText::_('HDVS_RATTING') . ' : ' . $this->htmlVideoDetails->ratecount; ?>';
                    var video_src = "<?php echo JURI::getInstance()->toString(); ?>";
                    var embedCode = '<iframe src="http://player.vimeo.com/video/<?php echo $split[3]; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=6fde9f" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                    document.getElementById('embedcode').value=embedCode;
                    var pagevalues = "<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&amp;view=player&id=<?php echo $this->videodetails->id; ?>&catid=<?php echo $this->videodetails->playlistid; ?>";
                    var bookmark = "http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $this->htmlVideoDetails->title; ?>&p[summary]=<?php echo $this->htmlVideoDetails->description; ?>&p[medium]="+escape('103')+"&p[video][src]="+escape(video_src)+"&p[url]="+escape(pagevalues)+"&p[images][0]=<?php echo $this->htmlVideoDetails->thumburl; ?>";
                    document.getElementById('fbshare').href=bookmark;
                    document.getElementById("downloadurl").href = "<?php echo $this->videodetails->videourl; ?>";
                }
            </script>
            <iframe src="<?php echo 'http://player.vimeo.com/video/' . $split[3] . '?title=0&amp;byline=0&amp;portrait=0'; ?>" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>" frameborder="0"></iframe>
        <?php } else {
 ?>
            <div id="flashplayer">
                <embed wmode="opaque" src="<?php echo $playerpath; ?>" type="application/x-shockwave-flash"
                       allowscriptaccess="always" allowfullscreen="true" flashvars="baserefJ=<?php echo $details1['baseurl']; ?><?php echo $baseref; ?>"  style="width:<?php echo $details1[0]->width; ?>px; height:<?php echo $details1[0]->height; ?>px"></embed>
            </div>
            <!-- Flash player End and HTML5 PLAYER START-->
            <div id="htmlplayer" style="display:none;">
            <?php
            $htmlVideoDetails = $this->htmlVideoDetails;
            if ($this->homepageaccess == 'true') {
                if ($htmlVideoDetails->filepath == "File" || $htmlVideoDetails->filepath == "FFmpeg" || $htmlVideoDetails->filepath == "Url") {
                    $current_path = "components/com_contushdvideoshare/videos/";
                    if ($htmlVideoDetails->filepath == "Url") {
                        $video = $htmlVideoDetails->videourl;
                    } else {
                        $video = JURI::base() . $current_path . $htmlVideoDetails->videourl;
                    }
            ?>
                    <video id="video" src="<?php echo $video; ?>" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>" autobuffer controls onerror="failed(event)">
                        Html5 Not support This video Format.
                    </video><?php
                } elseif ($htmlVideoDetails->filepath == "Youtube") {
                    if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $htmlVideoDetails->videourl, $vresult)) {
                        $urlArray = explode("=", $vresult[0]);
                        $videoid = trim($urlArray[1]);
                        $video = "http://www.youtube.com/embed/$videoid";
                    }
            ?>
                    <iframe  type="text/html" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"  src="<?php echo $video; ?>" frameborder="0"></iframe>
            <?php
                }
            } else {
            ?>
                <div id="video" style="width:<?php echo $details1[0]->width; ?>px; height:<?php echo $details1[0]->height; ?>px; background-color:#000000;" >
                    <h3 style="color:#e65c00;vertical-align: middle;height:<?php echo $details1[0]->height; ?>px;display: table-cell;width:<?php echo $details1[0]->width; ?>px; ">You are not authorized to view this video</h3>
                </div>
<?php } ?>
        </div>
        <script type="text/javascript">
            var txt =  navigator.platform ;
            if(txt =='iPod' || txt =='iPad' || txt =='iPhone' || txt =='Linux armv7l' || txt =='Linux armv6l')
            {
                document.getElementById("htmlplayer").style.display = "block";
                document.getElementById("flashplayer").style.display = "none";
             }
            else
            {
                document.getElementById("flashplayer").style.display = "block";
                document.getElementById("htmlplayer").style.display = "none";
            }
            function failed(e)
            {
                if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7l' || txt =='Linux armv6l')
                {
                    alert('Player doesnot support this video.');
                }
            }
        </script>
        <!-- HTML5 PLAYER  END -->
        <?php }
        if (isset($details1['publish']) == '1' && isset($details1['showaddc']) == '1') { ?>
            <div style="clear:both;font-size:0px; height:0px;"></div>
            <div id="lightm" style="position:absolute;bottom:25px;width:<?php echo $details1[0]->width; ?>px;background:none;"  >
                <div align="center">
                    <div class="addcss" style="margin:0 auto;width:470px;">
                        <img id="closeimgm" src="components/com_contushdvideoshare/images/close.png" class="googlead_img" onclick="googleclose();" alt="close" />
                        <iframe height="60" scrolling="no"   align="middle" width="468" id="IFrameName" src=""     name="IFrameName" marginheight="0" marginwidth="0" frameborder="0"></iframe>
                    </div>
                    <span id="divimgm" style="width:<?php echo $details1[0]->width; ?>px;">
                    </span>
                </div></div>
            <script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/googlead.js" type="text/javascript"></script>
<?php } ?>
    </div>
</div>
<?php
        if (isset($details1['closeadd'])) {
            $closeadd = $details1['closeadd'];
            $ropen = $details1['ropen'];
?>
            <script type="text/javascript">
                var closeadd =  <?php echo $closeadd * 1000; ?>;
                var ropen = <?php echo $ropen * 1000; ?>;
            </script>
<?php } ?>
        <div id="rateid" class="ratingbg" >
            <div class="content_center clearfix" style="width:<?php echo $details1[0]->width; ?>px;">
        <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>
            <div class="centermargin floatleft" >
                <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();" contentEditable='false' unselectable='true'>
                    <div id="a" class="floatleft"></div>
                <?php
                if (isset($this->commentview[0]->ratecount) && $this->commentview[0]->ratecount != 0) {
                    $ratestar = round($this->commentview[0]->rate / $this->commentview[0]->ratecount);
                } else {
                    $ratestar = 0;
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
                <input type="hidden" name="id" id="id" value="<?php if (isset($this->videodetails->id) && $this->videodetails->id != '')
                    echo $this->videodetails->id; else if (isset($this->getfeatured->id) && $this->getfeatured->id != '')
                    echo $this->getfeatured->id; ?>" />
            </div>
            <div class="rateright-views floatleft" >
                <span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();"> </span>
                <span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();">  </span>
            </div>
        </div>
<?php } ?>
            <div class="video_addedon">
                <b><?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>   <?php echo JText::_('HDVS_VIEWS'); ?> :</b> <span id="viewcount"><?php if(isset($this->htmlVideoDetails->times_viewed)) echo $this->htmlVideoDetails->times_viewed; ?></span> <?php } ?>
                <span class="addedon"><b><?php echo JText::_('HDVS_ADDED_ON'); ?> : </b></span><span id="createdate"><?php if(isset($this->htmlVideoDetails->created_date)) echo date("m-d-Y", strtotime($this->htmlVideoDetails->created_date)); ?></span>
            </div>
        </div>
        <!-- ratting for video -->
        <script type="text/javascript">
            function ratecal(rating,ratecount)
            {
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
                else
                    document.getElementById('rate').className="ratethis nopos";
                document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> "+ratecount;
            }

<?php if (isset($ratestar) && isset($this->commentview[0]->ratecount) && isset($this->commentview[0]->times_viewed)) { ?>
                ratecal('<?php echo $ratestar; ?>','<?php echo $this->commentview[0]->ratecount; ?>','<?php echo $this->commentview[0]->times_viewed; ?>');
<?php } ?>

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
                document.getElementById('ratemsg').innerHTML="Thanks for rating!";
                var id= document.getElementById('id').value;
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
                    document.getElementById('ratemsg').innerHTML="<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> <?php echo $this->commentview[0]->ratecount; ?>";
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
        </script>

    </div>
    <div class="clscenter" style="width:<?php echo $details1[0]->width; ?>px;">
    <?php
        if(isset($this->htmlVideoDetails) && $this->htmlVideoDetails!=''){
    if ($this->htmlVideoDetails->filepath == "File" || $this->htmlVideoDetails->filepath == "FFmpeg") {
                    $current_path = "components/com_contushdvideoshare/videos/";
                    $video_url = JURI::base() . $current_path . $this->htmlVideoDetails->videourl;
                    $video_thumb = JURI::base() . $current_path .$this->htmlVideoDetails->thumburl;
                    $video_preview = JURI::base() . $current_path .$this->htmlVideoDetails->previewurl;

                    } else {
                         $video_url = $this->htmlVideoDetails->videourl;
                         $video_thumb = $this->htmlVideoDetails->thumburl;
                         $video_preview = $this->htmlVideoDetails->previewurl;
                    }
        }
            if (isset($this->commenttitle)) {
                foreach ($this->commenttitle as $row) {
    ?>
    <?php
                    $mid = isset($row->memberid) ? $row->memberid : '';
                    $row->username = isset($row->username) ? $row->username : '';
                    if ($row->username != '') {
    ?>
                        <div class="viewsubname"><span class="uploadedby"><?php echo 'Uploaded by'; ?> :</span>  <a  href="#" title="<?php echo $row->username; ?>" class="namelink cursor_pointer" onclick="membervalue('<?php echo $mid; ?>')" ><?php echo $row->username; ?></a></div><?php
                    }
    ?><div class="clear"></div>
                    <!-- Social sharing starts here -->
                    <div class="sharing_vid clearfix">
<?php if ($this->homepagebottomsettings[0]->facebooklike == 1) {
                        $pageURL = str_replace('&', '%26', JURI::getInstance()->toString()); ?>
                        <div id="share_like">
                            <div id="fb-root" class="floatleft">
                                <div style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div>
                            </div>
  <?php
                            $url_fb = "http://www.facebook.com/sharer/sharer.php?s=100&p%5Btitle%5D=".$this->htmlVideoDetails->title."&p%5Bsummary%5D=".strip_tags($this->htmlVideoDetails->description)."&p%5Bmedium%5D=103&p%5Bvideo%5D%5Bwidth%5D=".$details1[0]->width."&p%5Bvideo%5D%5Bheight%5D=".$details1[0]->height."&p%5Bvideo%5D%5Bsrc%5D=". urlencode($playerpath) ."%3Ffile%3D".urlencode($video_url)."%26embedplayer%3Dtrue%26share%3Dfalse%26HD_default%3Dtrue%26autoplay%3Dtrue%26skin_autohide%3Dtrue%26showPlaylist%3Dfalse%26id%3D".$this->videodetails->id."%26baserefJ%3D".urlencode(JURI::base())."&p%5Burl%5D=".urlencode($pageURL)."&p%5Bimages%5D%5B0%5D=".urlencode($video_thumb);
                            ?>
                            <a href="<?php echo $url_fb; ?>" class="fbshare" id="fbshare" target="_blank" ></a>
                            <div class="floatleft">
                                <a href="http://twitter.com/home?status=<?php echo $this->htmlVideoDetails->title; ?>:+<?php echo $pageURL; ?>%26random%3D<?php echo rand(); ?>" data-count="horizontal" id="twshare" target="_blank"><img alt="" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/twitter-icon.png" width="16" height="16" />Tweet</a>
                            </div>
                            <!-- Google plus one Start -->
                            <div class="floatleft google-plus">
                                <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                                <div class="g-plusone" data-size="medium" data-count="true"></div>
                            </div>
                            <script src="http://connect.facebook.net/en_US/all.js"></script>
                            <!-- layout=button_count&amp; -->

                            <iframe class="facebook_hdlike" src="http://www.facebook.com/plugins/like.php?href=<?php echo $pageURL; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0"  allowTransparency="true"> </iframe>
                        </div>
            <?php } ?>
                <div class="vinfo_right_embed">
            <?php if ($this->htmlVideoDetails->download == 1 && $this->htmlVideoDetails->filepath!="Youtube") {
 ?>
                        <a href="<?php echo $video; ?>" target="_blank" id="downloadurl"><?php echo JText::_('HDVS_DOWNLOAD'); ?></a>
<?php } ?>
                    <a href="javascript:void(0)" onclick="enableEmbed()" class="embed" id="allowEmbed"><?php echo JText::_('HDVS_EMBED'); ?> </a>
                        <div class="clear"></div>
                    </div>
<?php
                    $split = explode("/", $this->videodetails->videourl);
                    $embed_code = '<embed id="player" src="' . $playerpath . '" flashvars="id=' . $this->videodetails->id . '&baserefJ=' . urlencode(JURI::base()) . '&autoplay=false&Preview=' . urlencode($video_preview) . '&showPlaylist=false&embedplayer=true&share=false" style="width:' . $details1[0]->width . 'px;height:' . $details1[0]->height . 'px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>';
?>
                    <textarea id="embedcode" name="embedcode" style="display:none;width:<?php if ($details1[0]->width > 10) {
                        echo ($details1[0]->width) - (17);
                    } else {
                        echo $details1[0]->width;
                    } ?>px;}" rows="7" ><?php echo $embed_code; ?></textarea>
                    <input type="hidden" name="flagembed" id="flagembed" />
                </div>
                <script type="text/javascript">
                    function enableEmbed(){
                        embedFlag = document.getElementById('flagembed').value
                        if(embedFlag != 1){
                            document.getElementById('embedcode').style.display="block";
                            document.getElementById('flagembed').value = '1';
                        }
                        else{
                            document.getElementById('embedcode').style.display="none";
                            document.getElementById('flagembed').value = '0';
                        }
                    }
                </script>
                <!-- Social sharing ends and Description display place starts here -->

                <p id="videoDescription"><?php echo $this->htmlVideoDetails->description; ?></p>
                    <div class="clear"></div>
<?php
                    break;
                }
            }
?>
            </div>
            <div class="clear"></div>
            <!-- Add Facebook Comment -->
    <?php if (!empty($this->videodetails) && $this->videodetails->id) {
                if ($this->homepagebottomsettings[0]->comment == 1) {
 ?>

                <div class="fbcomments" id="theFacebookComment">
                    <h3><?php echo JText::_('HDVS_ADD_YOUR_COMMENTS'); ?></h3>
<?php
                    $this->homepagebottomsettings[0]->facebookapi = isset($this->homepagebottomsettings[0]->facebookapi) ? $this->homepagebottomsettings[0]->facebookapi : '';
                    if ($this->homepagebottomsettings[0]->facebookapi)
                        $facebookapi = $this->homepagebottomsettings[0]->facebookapi;
?>
                    <br />
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
                        <fb:comments xid="<?php echo JRequest::getVar('id'); ?>" css="facebook_style.css" simple="1" href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="<?php echo $details1[0]->width; ?>"></fb:comments>
                    </div>
                </div>
    <?php } ?>
            <input type="hidden" value="<?php echo $this->homepagebottomsettings[0]->comment; ?>" id="commentoption" name="commentoption" />
            <div id="commentappended" class="clscenter" style="<?php if ($this->homepagebottomsettings[0]->comment == 1) {
 ?>display:none;<?php } ?>width:<?php echo $details1[0]->width; ?>px;">
<?php
if (USER_LOGIN == '1') {
            if ($user->get('id') != '') {
if ($this->homepagebottomsettings[0]->comment != 0) { ?>
                    <div id="container" style="margin-top:0px;">
                        <iframe id="myframe1" height="100%" width="<?php echo $details1[0]->width; ?>" name="myframe1" class="autoHeight" frameborder="0" scrolling="no" src="index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>"  ></iframe>
                    </div>
<?php
                }
            }
            else {
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $login_url = "index.php?option=com_users&view=login&return=".base64_encode(JFactory::getURI()->toString());
                } else {
                    $login_url = "index.php?option=com_user&view=login&return=".base64_encode(JFactory::getURI()->toString());
                }
?>
 <div class="commentpost floatright"><a  href="<?php echo $login_url; ?>"  class="utility-link"><?php echo "Login to post comment"; ?></a></div>
<?php
            }
}
                if ($this->homepagebottomsettings[0]->comment == 2) {
                    $tot = count($this->commenttitle);
?>
                    <script type="text/javascript">
                        {
                            function parentvalue(parentid)
                            {
                                document.getElementById('parentvalue').value=parentid;
                                document.getElementById('name').focus();
                            }
                        }
                    </script>
                    <script type="text/javascript">
                        function changepage(pageno)
                        {
                            document.getElementById("page").value=pageno;
                            pagination(pageno);
                        }
                        function validation(form)
                        {
                            var username=form.username.value;
                            if(username.length==0)
                            {
                                alert("<?php echo JText::_('HDVS_ENTER_NAME'); ?>");
                                document.getElementById('username').focus();
                                return false;
                            }
                            var comments=form.message.value;
                            if(comments.length==0)
                            {
                                alert("<?php echo JText::_('HDVS_ENTER_MESSAGE'); ?>");
                                form.message.focus();
                                return false;
                            }
                            return true;
                        }
                        function GetXmlHttpObject()
                        {
                            if (window.XMLHttpRequest)
                            {
                                // code for IE7+, Firefox, Chrome, Opera, Safari
                                return new XMLHttpRequest();
                            }
                            if (window.ActiveXObject)
                            {
                                // code for IE6, IE5
                                return new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            return null;
                        }
                        var xmlhttp;
                        var nocache = 0;
                        function insert()
                        {
                            document.getElementById('txt').style.display="none";
                            var name= document.getElementById('username').value;
                            var message = document.getElementById('message').value;
                            var id= document.getElementById('videoid').value;
                            var category= document.getElementById('category').value;
                            var parentid= document.getElementById('parentvalue').value;
                            // Set te random number to add to URL request
                            nocache = Math.random();
                            xmlhttp=GetXmlHttpObject();
                            if (xmlhttp==null)
                            {
                                alert ("<?php echo JText::_('HDVS_BROWSER_NOT_SUPPORT_HTTP_REQUEST'); ?>");
                                return;
                            }
                            document.getElementById('prcimg').style.display="block";
                            var url="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id="+id+"&catid="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&cmdid=2&nocache = "+nocache;
                            url=url+"&sid="+Math.random();

                            xmlhttp.onreadystatechange=stateChanged;
                            xmlhttp.open("GET",url,true);
                            xmlhttp.send(null);

                        }
                        function stateChanged()
                        {
                            if (xmlhttp.readyState==4)
                            {
                                document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
                                document.getElementById("commentappended").style.display="block";
                            }
                        }
                        function pagination(pageno)
                        {
                            var cmdoption=document.getElementById('commentoption').value;
                            var id= encodeURI(document.getElementById('id').value);
                            // Set te random number to add to URL request
                            nocache = Math.random();
                            xmlhttp=GetXmlHttpObject();
                            if (xmlhttp==null)
                            {
                                alert ("<?php echo JText::_('HDVS_BROWSER_NOT_SUPPORT_HTTP_REQUEST'); ?>");
                                return;
                            }
                            document.getElementById('prcimg').style.display="block";
                            var url="<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id="+id+"&page="+pageno+"&cmdid="+cmdoption;
                            xmlhttp.onreadystatechange=pageChanged;
                            xmlhttp.open("GET",url,true);
                            xmlhttp.send(null);
                        }
                        function pageChanged()
                        {
                            if (xmlhttp.readyState==4)
                            {
                                document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
                                document.getElementById("commentappended").style.display="block";
                            }
                        }
                        function comments()
                        {
                            var d=document.getElementById('txt').innerHTML;
                            document.getElementById('initial').innerHTML=d;
                        }
                        function CountLeft(field, count, max)
                        {
                            // if the length of the string in the input field is greater than the max value, trim it
                            if (field.value.length > max)
                                field.value = field.value.substring(0, max);
                            else
                                count.value = max - field.value.length;
                        }
                        function textdisplay(rid)
                        {
                            if(document.getElementById('divnum').value>0 )
                            {
                                document.getElementById(document.getElementById('divnum').value).innerHTML="";

                            }
                            document.getElementById('initial').innerHTML=" ";
                            var r=rid;
                            var d=document.getElementById('txt').innerHTML;
                            document.getElementById(r).innerHTML=d;
                            document.getElementById('txt').style.display="none";
                            document.getElementById('divnum').value=r;
                        }
                        function hidebox()
                        {
                            document.getElementById('txt').style.display="none";
                            document.getElementById('initial').innerHTML=" ";
                        }
                    </script>
<?php } ?>
                </div>
<?php } $memberidvalue = '' ?>
<?php
            if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
            }
?>
            <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
            </form>
            <script type="text/javascript" language="javascript">
                function membervalue(memid)
                {
                    document.getElementById('memberidvalue').value=memid;
                    document.getElementById('memberidform').submit();
                }
            </script>
            <input type="hidden" value="" id="storeratemsg" />
            <script type="text/javascript">
	                        txt =  navigator.platform ;
	                        if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7l' || txt =='Linux armv6l')
	                        {
                                        document.getElementById('downloadurl').style.display = 'none';
                                        document.getElementById('allowEmbed').style.display = 'none';
                                        document.getElementById('share_like').style.display = 'none';
                                    var cmdoption = document.getElementById('commentoption').value;
	                             if(cmdoption == 1){
	                                 document.getElementById('theFacebookComment').style.display = 'block';
	                               }
 	                        }
                        </script>
<?php
$lang = JFactory::getLanguage();
            $langDirection = (bool) $lang->isRTL();
            if ($langDirection == 1) {
                $rtlLang = 1;
            } else {
                $rtlLang = 0;
            }
?>
            <script type="text/javascript">
                jQuery.noConflict();
                jQuery(document).ready(function($){
                    jQuery(".ulvideo_thumb").mouseover(function(){
                        htmltooltipCallback("htmltooltip","",<?php echo $rtlLang; ?>);
                        htmltooltipCallback("htmltooltip1","1",<?php echo $rtlLang; ?>);
                        htmltooltipCallback("htmltooltip2","2",<?php echo $rtlLang; ?>);
                    });
                });
                jQuery(document).ready(function($){
                    htmltooltipCallback("htmltooltip","",<?php echo $rtlLang; ?>);
                    htmltooltipCallback("htmltooltip1","1",<?php echo $rtlLang; ?>);
                    htmltooltipCallback("htmltooltip2","2",<?php echo $rtlLang; ?>);
                })
                jQuery(document).click(function(){
                    htmltooltipCallback("htmltooltip","",<?php echo $rtlLang; ?>);
                    htmltooltipCallback("htmltooltip1","1",<?php echo $rtlLang; ?>);
                    htmltooltipCallback("htmltooltip2","2",<?php echo $rtlLang; ?>);
    })
</script>