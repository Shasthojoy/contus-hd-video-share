<?php
/*
 * "ContusHDVideoShare Component" - Version 1.3
 * Author: Contus Support - http://www.contussupport.com
 * Copyright (c) 2010 Contus Support - support@hdvideoshare.net
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Project page and Demo at http://www.hdvideoshare.net
 * Creation Date: March 30 2011
 */
defined('_JEXEC') or die('Restricted access');
$app = & JFactory::getApplication();
$user = & JFactory::getUser();
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
//$user->get('username');
$username = $user->get('username');
//echo $username;

$details1 = $this->detail;
$playerpath = JURI::base() . "index.php?option=com_contushdvideoshare&view=playerbase";
?>
<!-- for tooltip window -->
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/autoHeight.js"></script>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<input type="hidden" value="" name="videoidforcmd" id="videoidforcmd">
<input type="hidden" name="category" value="<?php echo $this->videodetails->playlistid; ?>" id="category"/>
<input type="hidden" value="<?php echo $this->videodetails->id; ?>" name="videoid" id="videoid">
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
    function onVideoChanged(videodetails)

    {
        var id = videodetails['id'];
        var title = videodetails['title'];
        var views = videodetails['views'];
        var date = videodetails['date'];
        var category = videodetails['category'];
        var ratecount = videodetails['ratecount'];
        var rating = videodetails['rating'];
        var description = videodetails['description'];
        document.getElementById('id').value=id;
<?php if ($app->getTemplate() != 'hulutheme') { ?>
            document.getElementById('viewtitle').innerHTML = '<h3><b>'+title+'</h3></b>';
            document.getElementById('category').value=videodetails['category'];
            document.getElementById('videoid').value=videodetails['id'];
            //alert(document.getElementById('viewtitle').style.width);
            var titlewidth=document.getElementById('viewtitle').style.width;
            ////alert(titlewidth);
            var titlewidthvalue=titlewidth.substring(0, (titlewidth.length)-2);
            //alert(parseInt(titlewidthvalue)+140);
            titlewidthvalue=((parseInt(titlewidthvalue)+140)/13);   //140
            if(title.length>titlewidthvalue)
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title' >"+title.substring(0, titlewidthvalue)+"...</h3>";
            else
                document.getElementById('viewtitle').innerHTML="<h3 id='video_title'>"+title+"</h3>";

<?php } ?>
        if(document.getElementById('videotitle'))
        {
            document.getElementById('videotitle').innerHTML=title;
            document.getElementById('videoDescription').innerHTML = description;
        }
        document.getElementById('storeratemsg').value=ratecount;
        document.getElementById('id').value=id;
        resethomepagerate();

        function createObject() {
            var request_type;
            var browser = navigator.appName;
            if(browser == "Microsoft Internet Explorer")
            {
                request_type = new ActiveXObject("Microsoft.XMLHTTP");
            }else{
                request_type = new XMLHttpRequest();
            }
            return request_type;
        }
        var http = createObject();
        var nocache = 0;


        nocache = Math.random();
        http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&nocache = '+nocache,true);
        http.onreadystatechange = insertReply;
        http.send(null);


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
                    if( cmdoption==2 || cmdoption==3)
                    {

                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
                        document.getElementById('myframe1').src=url;
                        document.getElementById('myframe1').style.display="block";
                        //        alert(document.getElementById('myframe').contentWindow.document.body.scrollHeight);

                    }
                    if(cmdoption!=0 && cmdoption!=2 && cmdoption!=3)
                    {
                        url= 'index.php?option=com_contushdvideoshare&view=commentappend&id='+id+'&cmdid='+cmdoption;
                        commentappendfunction(url);
                    }
                }

            }
        }

        ratecal(rating,ratecount,views);


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

    function stateChanged()
    {
        if (xmlhttp.readyState==4)
        {
            document.getElementById("commentappended").innerHTML=xmlhttp.responseText;
            document.getElementById("commentappended").style.display="block";

        }
    }
    function resethomepagerate()
    {

        document.getElementById('ratemsg').innerHTML="<?php echo _HDVS_RATTING; ?> : "+document.getElementById('storeratemsg').value;
    }

</script>
<script>


    function ratecal(rating,ratecount,views)
    {
        //alert(views);
        if(document.getElementById('viewid'))
        {
            document.getElementById('viewid').innerHTML="<b><h3 style='text-align:right'><?php echo _HDVS_VIEWS; ?> : "+views+"</h3></b>";
        }
        rating=Math.round(rating/ratecount);

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
        document.getElementById('ratemsg').innerHTML="Ratings :"+ratecount;


    }


</script>
<?php
if ($app->getTemplate() != 'hulutheme')
    echo '<link rel="stylesheet" href="' . JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';
?>
<!-- Component Starts Version 1.3-->




<div class="fluid bg playerbg"  >


    <div id="HDVideoshare1" style="position:relative;width:<?php echo $details1[0]->width; ?>px; " >

        <?php if ($app->getTemplate() != 'hulutheme') {
        ?>
            <span id="viewtitle" class="floatleft" style="width:<?php echo $details1[0]->width - 140; ?>px;" ></span>
        <?php
        }
        if ($app->getTemplate() != 'hulutheme') {
            if (USER_LOGIN == '1') {
                if ($user->get('id') != '') {
        ?>
                    <span class="toprightmenu"><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare'); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>
        <?php } else {
        ?>

                    <span class="toprightmenu"><b><a href="index.php?option=com_user&view=register"><?PHP ECHO _HDVS_REGISTER; ?></a> | <a  onclick="javascript:popUpWindow('<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentlogin&rmode=true', '200', '200', '320', '240')"> <?PHP ECHO _HDVS_LOGIN; ?></a></b></span>
        <?php
                }
            }
        }
        ?>


        <div class="clear"></div>


        <!----- Flash player Start ----->
        <div id="flashplayer">
            <object  classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,40,0" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>">
                <param name="wmode" value="opaque"></param>
                <param name="movie" value="<?php echo $playerpath; ?>"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowscriptaccess" value="always"></param>
                <param name="flashvars" value='baserefJ=<?php echo $details1['baseurl']; ?><?php
        if ($this->videodetails->id) {
            echo '&id=' . $this->videodetails->id;
        } else {
            echo '&featured=true';
        } ?><?php
                if ($this->videodetails->playlistid) {
                    echo '&catid=' . $this->videodetails->playlistid;
                }
        ?>'></param>
                <embed wmode="opaque" src="<?php echo $playerpath; ?>" type="application/x-shockwave-flash"
                       allowscriptaccess="always" allowfullscreen="true" flashvars="baserefJ=<?php echo $details1['baseurl']; ?><?php
                       if ($this->videodetails->id) {
                           echo '&id=' . $this->videodetails->id;
                       } else {
                           echo '&featured=true';
                       }
        ?><?php
                       if ($this->videodetails->playlistid) {
                           echo '&catid=' . $this->videodetails->playlistid;
                       }
        ?>"  width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"></embed></object>
        </div>
        <!---------------- Flash player End ---------------->
        <!---------------- HTML5 PLAYER START ---------------->
        <script type="text/javascript">
            function failed(e) {
                if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7I')
                {
                    alert('Player doesnot support this video.');
                }
            }
        </script>
        <?php
        ?>
                       <div id="htmlplayer" style="display:none;">
            <?php
                       $htmlVideoDetails = $this->htmlVideoDetails;
                       if ($htmlVideoDetails->filepath == "File" || $htmlVideoDetails->filepath == "FFmpeg" || $htmlVideoDetails->filepath == "Url") {
                           $current_path = "components/com_contushdvideoshare/videos/";
                           if ($htmlVideoDetails->filepath == "Url") {
                               $video = $htmlVideoDetails->filepath;
                           } else {
                               $video = JURI::base() . $current_path . $htmlVideoDetails->videourl;
                           } ?>
                           <video id="video" src="<?php echo $video; ?>" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>" autobuffer controls onerror="failed(event)">
                               Html5 Not support This video Format.
                           </video><?php
                       } elseif ($htmlVideoDetails->filepath == "Youtube") {
                           if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $htmlVideoDetails->videourl, $vresult)) {
                               $urlArray = split("=", $vresult[0]);
                               $videoid = trim($urlArray[1]);
                           }
?>
                           <iframe  type="text/html" width="<?php echo $details1[0]->width; ?>" height="<?php echo $details1[0]->height; ?>"  src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0">
                           </iframe>
<?php
                       }
?>
                   </div>
                   <script>
                       txt =  navigator.platform ;
                       if(txt =='iPod'|| txt =='iPad'|| txt =='iPhone'|| txt =='Linux armv7I')
                       {
                           document.getElementById("htmlplayer").style.display = "block";
                           document.getElementById("flashplayer").style.display = "none";
                       }else{
                           document.getElementById("flashplayer").style.display = "block";
                           document.getElementById("htmlplayer").style.display = "none";
                       }
                   </script>
                   <!---------------- HTML5 PLAYER  END ---------------->
<?php if (isset($details1['publish']) == '1' && isset($details1['showaddc']) == '1') { ?>
                       <div style="clear:both;font-size:0px; height:0px;"></div>
                       <div id="lightm" style="position:absolute;bottom:25px;width:<?php echo $details1[0]->width; ?>px;background:none;"  >

                               <div align="center">  <div class="addcss" style="margin:0 auto;width:470px;"> <img id="closeimgm" src="components/com_contushdvideoshare/images/close.png" class="googlead_img" onclick="googleclose();"></div> <span id="divimgm" style="width:<?php echo $details1[0]->width; ?>px;">
                                   </span>

                                   <iframe height="60" scrolling="no"   align="middle" width="468" id="IFrameName" src=""     name="IFrameName" marginheight="0" marginwidth="0" frameborder="0"></iframe>

                               </div></div>
                           <script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/googlead.js"></script>
<?php } ?>
                   </div>
               </div>

<?php
                       if (isset($details1['closeadd'])) {
                           $closeadd = $details1['closeadd'];
                           $ropen = $details1['ropen'];
?>
                           <script language="javascript">

                               var closeadd =  <?php echo $closeadd * 1000; ?>;

                               var ropen = <?php echo $ropen * 1000; ?>;


                           </script>


<?php } ?>

                       <div id="rateid" class="ratingbg" >
<?php
                       $user = & JFactory::getUser();

                       $session = JFactory::getSession();
?>

                       <table <?php if ($app->getTemplate() == 'hulutheme') {
 ?>class="content_center" <?php } ?> style="width:<?php echo $details1[0]->width; ?>px; "   cellpadding="0" cellspacing="0" border="0">
                           <tr>
<?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>

                                   <td  class="left-rate">
                                       <div class="centermargin" >

                                           <div  contentEditable='false' unselectable='true'>
                                               <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();">
                                                   <div id="a" class="floatleft"></div>
<?php
                           if (isset($this->commentview[0]->ratecount) && $this->commentview[0]->ratecount != 0) {
                               $ratestar = round($this->commentview[0]->rate / $this->commentview[0]->ratecount);
                           } else {
                               $ratestar = 0;
                           }
//echo $ratestar;
//$ratearray=array("nopos","onepos","twopos","threepos","fourpos","fivepos")
?>


                            <ul class="ratethis " id="rate" >
                                <li class="one" >
                                    <a title="1 Star Rating"  onclick="getrate('1');"  onmousemove="displayrating('1');" onmouseout="resetvalue();">1</a>
                                </li>
                                <li class="two" >
                                    <a title="2 Star Ratings"  onclick="getrate('2');"  onmousemove="displayrating('2');" onmouseout="resetvalue();">2</a>
                                </li>
                                <li class="three" >
                                    <a title="3 Star Ratings"  onclick="getrate('3');"   onmousemove="displayrating('3');" onmouseout="resetvalue();">3</a>
                                </li>
                                <li class="four" >
                                    <a  title="4 Star Ratings"  onclick="getrate('4');"  onmousemove="displayrating('4');" onmouseout="resetvalue();"  >4</a>
                                </li>
                                <li class="five" >
                                    <a title="5 Star Ratings"  onclick="getrate('5');"  onmousemove="displayrating('5');" onmouseout="resetvalue();" >5</a>
                                </li>
                            </ul>

                            <input type="hidden" name="id" id="id" value="<?php echo $this->videodetails->id; ?>">
                        </div>

                        <div class="floatleft">
                            <div class="rateright-views" style="width:200px;"><b><span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();" > </span></b>
                                <b><span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();"  >  </span></b></div>
                            <input type="hidden" value="" id="storeratemsg" ></div>

                    </div>
                </div></td>
<?php } ?>


            <?php
                        if ($app->getTemplate() == 'hulutheme') {
            ?>
                            <td align="right" class="rightrate" >
                                <div class="bottomviews"  id="viewid"></div>
                            </td>
<?php } ?>

                    </tr></table>


                <script language="javascript">
<?php if (isset($ratestar) && isset($this->commentview[0]->ratecount) && isset($this->commentview[0]->times_viewed)) { ?>
                    ratecal('<?php echo $ratestar; ?>','<?php echo $this->commentview[0]->ratecount; ?>','<?php echo $this->commentview[0]->times_viewed; ?>');
<?php } ?>
                function createObject() {
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
                    //alert('index.php?option=com_contushdvideoshare&view=player&id='+id+'&rate='+t+'&nocache = '+nocache);
                    http.open('get', 'index.php?option=com_contushdvideoshare&view=player&id='+id+'&rate='+t+'&nocache = '+nocache,true);
                    http.onreadystatechange = insertReply;
                    http.send(null);
                    //return true;
                    document.getElementById('rate').style.visibility='disable';
                }
                function insertReply() {
                    if(http.readyState == 4){
                        //alert("ok");
                        document.getElementById('rate').className="";
                    }
                }

                function resetvalue()
                {
                    document.getElementById('ratemsg1').style.display="none";
                    document.getElementById('ratemsg').style.display="block";
<?php
                        if (isset($this->commentview[0]->ratecount)) {
?>
                        document.getElementById('ratemsg').innerHTML="Ratings : <?php echo $this->commentview[0]->ratecount; ?>";
<?php } else { ?>
                        document.getElementById('ratemsg').innerHTML="Ratings : "+document.getElementById('storeratemsg').value;
<?php } ?>
                }
                function displayrating(t)
                {
                    //alert("DFsdg");

                    if(t=='1')
                    {
                        document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_POOR; ?>";
                    }
                    if(t=='2')
                    {
                        document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_NOTHING_SPECIAL; ?>";
                    }
                    if(t=='3')
                    {
                        document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_WORTH_WATCHING; ?>";
                    }
                    if(t=='4')
                    {
                        document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_PRETTY_COOL; ?>";
                    }
                    if(t=='5')
                    {
                        document.getElementById('ratemsg').innerHTML="<?PHP ECHO _HDVS_AWESOME; ?>";
                    }
                    document.getElementById('ratemsg1').style.display="none";
                    document.getElementById('ratemsg').style.display="block";
                }
                //document.getElementById('ratemsg1').style.display="none";
                //document.getElementById('ratemsg').style.display="block";

                </script>
<?php //}        ?>
            </div>
            <div class="clscenter" style="width:<?php echo $details1[0]->width; ?>px;">
    <?php
                        if (isset($this->commenttitle)) {
                            foreach ($this->commenttitle as $row) {
    ?>
                                <div style="float:left;<?php
                                if ($app->getTemplate() != 'hulutheme') {
                                    echo "width:60%;";
                                }
    ?>">
                                    <br />
                                    <h2 class="nospace" id="videotitle" style="font-size:19px;margin-top:0px;padding-top:0px;"><?php echo $row->title; ?></h2>
                                    <h4 id="videoDescription" style="font-size:14px;margin-top:8px;"><?php echo $row->description; ?></h4>
                           </div>

<?php
                                if ($app->getTemplate() != 'hulutheme') {
?>
    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
    ?>
                                        <div style="float:right;"><br><h3 style="margin:0px;padding:0px;">Views : <?php echo $row->times_viewed; ?></h3></div>

    <?php
                                    }
                                }
    ?>
                                <div style="clear:both"></div>
                                <div style="float:left;margin:5px 0 0 0;padding:0px;" >
    <?php $mid = $row->memberid; ?>
<?php if ($row->username != '') { ?><div class="viewsubname"> <?php echo _HDVS_SUBMITED_BY; ?> : <strong><a  title="<?php echo $row->username; ?>" class="namelink cursor_pointer" onclick="membervalue(<?php echo $mid; ?>);"><?php echo $row->username; ?></a></strong></div><?php
                                } else {
                                    echo '<div class="viewsubname">Submitted by:Admin</div>';
                                }
?>
                                  </div>
                                <div style="clear:both"></div>
                                <br />
        <?php
                                break;
                            }
                        }
        ?>
                    </div>
                        <!-- Add Facebook Comment -->
                        <div class="fbcomments" style="display:none" id="theFacebookComment">
                        <h3>Add Your Comments</h3>
                        <br />
                        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                                          <fb:comments href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="700"></fb:comments>
                        </div>
    <?php
                        if ($this->videodetails->id) {
    ?>
                        <input type="hidden" value="<?php echo $this->homepagebottomsettings[0]->comment; ?>" id="commentoption" name="commentoption">

                        <div id="commentappended" class="clscenter" style="<?php if ($this->homepagebottomsettings[0]->comment == 1) {
                         ?>display:none;<?php } ?>width:<?php echo $details1[0]->width; ?>px;">

                        
                         <?php if ($this->homepagebottomsettings[0]->comment != 0) { ?>
                                    <!--
                                    <iframe src="index.php?option=com_contushdvideoshare&view=commentappend&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>" width="900" height="1200" frameborder="0" scrolling="no" id="commentappendediframe" name="commentappendediframe" style="display:none;" ></iframe>

                                    -->
                                    <br/><br/>
                                    <div id="container" style="margin-top:0px;">

                                        <iframe id="myframe1" height="100%" width="<?php echo $details1[0]->width; ?>" name="myframe1" class="autoHeight" frameborder="0" scrolling="no" src="index.php?option=com_contushdvideoshare&view=commentappend&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $this->homepagebottomsettings[0]->comment; ?>"  ></iframe>
                                </div>
                           <?php
                            }
                            if ($this->homepagebottomsettings[0]->comment == 1) {
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

                                    //
                                    function changepage(pageno)
                                    {
                                        document.getElementById("page").value=pageno;
                                        document.pagination.submit();
                                    }
                                    function validation(form)
                                    {
                                        var username=form.username.value;
                                        if(username.length==0)
                                        {
                                            alert("Enter Your Name");
                                            document.getElementById('username').focus();
                                            return false;
                                        }
                                        var comments=form.message.value;
                                        if(comments.length==0)
                                        {
                                            alert("Enter Your Message");
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
                                    function insert() {
                                        document.getElementById('txt').style.display="none";
                                        //  document.getElementById('initial').innerHTML=" ";
                                        // Optional: Show a waiting message in the layer with ID login_response
                                        //var msg=document.getElementById('insert_response').innerHTML = "Your comment has been posted successfully"
                                        // Required: verify that all fileds is not empty. Use encodeURI() to solve some issues about character encoding.
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
                                            alert ("Browser does not support HTTP Request");
                                            return;
                                        }
                                        document.getElementById('prcimg').style.display="block";
                                        var url="index.php?option=com_contushdvideoshare&view=commentappend&id="+id+"&catid="+category+"&name="+name+"&message=" +message+"&pid="+parentid+"&cmdid=1&&nocache = "+nocache;
                                        url=url+"&sid="+Math.random();
                                        //alert(url);
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
<?php } else { ?>
                        <table  class="content_center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <div class="section "  >
                                        <div class="standard tidy"  >
                                            <div class="layout b-c">
                                                <div class="gr b" style="margin:0px;"  >
                                                    <div class="layout a-b-c"   >
<?php
//print_r($this->homepagebottomsettings[0]->homerecentvideo);

                            /* home page bottom */

                            for ($coun_tmovie_post = 1; $coun_tmovie_post <= 3; $coun_tmovie_post++) {
                                if ($this->homepagebottomsettings[0]->homefeaturedvideo == 1 && $this->homepagebottomsettings[0]->homefeaturedvideoorder == $coun_tmovie_post) {
?>
                                    <div class="gr a floatleft"  id="populared">
                                        <div class="callout-header-home">
                                            <h2 class="home-link hoverable" ><a href="index.php?option=com_contushdvideoshare&view=featuredvideos" title="Featured Videos"> <?php echo _HDVS_FEATURED_VIDEOS; ?></a></h2>
                                        </div>
                                <?php
                                    $totalrecords = count($this->rs_playlist1[0]);
                                    $j = 0;
                                    $k = 0;
                                    for ($i = 0; $i < $totalrecords; $i++) {
                                ?>                                        <?php if (($i % $this->homepagebottomsettings[0]->homefeaturedvideocol) == 0) {
                                ?>
                                            <div class="clear"></div>
                                    <?php } ?>
                                        <div class="floatleft">
                                    <?php
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


                                        <?php
                                        $oriname = $this->rs_playlist1[0][$i]->category;     //category name changed here for seo url purpose
                                        $newrname = explode(' ', $oriname);
                                        $link = implode('-', $newrname);
                                        $link1 = explode('&', $link);
                                        $category = implode('and', $link1);



                                        $orititle = $this->rs_playlist1[0][$i]->title;
                                        $newtitle = explode(' ', $orititle);
                                        $displaytitle = implode('-', $newtitle);

                                        $final = explode('-', $displaytitle);
                                        $final1 = implode(' ', $final);
                                        $final2 = explode('and', $final1);
                                        $displaytitle11 = implode('&', $final2);
//                                           echo $src_path;
                                        ?>




                                        <div class="home-thumb">
                                            <div class="home-play-container" >
                                                <span class="play-button-hover" >

                                                    <div class="movie-entry yt-uix-hovercard">
                                                        <a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&<?php echo $featureCategoryVal; ?>&<?php echo $featureVideoVal; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                            <div class="clearfix"></div>
                                                            <div id="Tooltipwindow" style="clear:both">
                                                                <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[0][$i]->category; ?></p>
                                                                <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[0][$i]->description; ?></p>
<?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                    <hr>
                                                                    <span ><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
<?php } ?>
                                                            </div>
                                                        </a>
                                                    </div>

                                                </span>
                                            </div>



                                            <div class="show-title-container">
                                                <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $featureCategoryVal; ?>&<?php echo $featureVideoVal; ?>" class="show-title-gray info_hover"><?php
                                        if (strlen($this->rs_playlist1[0][$i]->title) > 18) {
                                            echo (substr($this->rs_playlist1[0][$i]->title, 0, 18)) . "...";
                                        } else {
                                            echo $this->rs_playlist1[0][$i]->title;
                                        }
?> </a>
                                            </div>

                                            <span class="video-info">
                                                    <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $featureCategoryVal; ?>"><?php echo $this->rs_playlist1[0][$i]->category; ?></a>
                                            </span>
                                                    <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) { ?>

                                                <span class="video-info">
                                                    <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
                                                <?php
                                                        if (isset($this->rs_playlist1[0][$i]->ratecount) && $this->rs_playlist1[0][$i]->ratecount != 0) {
                                                            $ratestar = round($this->rs_playlist1[0][$i]->rate / $this->rs_playlist1[0][$i]->ratecount);
                                                        } else {
                                                            $ratestar = 0;
                                                        }
                                                ?>
                                                            <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                    </span>
                                                <?php } ?>

                                                <div class="clear"></div>

                                                <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                    <span class="video-info">
                                                        <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>

                                                        <span class="floatleft"><?php echo $this->rs_playlist1[0][$i]->times_viewed; ?></span>
                                                        </span>
<?php } ?>
                                                    <div class="clear"></div>

                                                    <!--
                                                      <span class="video-info">
                                                        More: <a href="" class="info_hover">--><?php
                                                    
?>                                                       </div>
<?php $j++; ?></div>
<?php
                                                }
                                            }
?>
                                    <!-- Code end here for featured videos in home page display -->
                                            <?php if ($this->homepagebottomsettings[0]->homepopularvideo == 1 && $this->homepagebottomsettings[0]->homepopularvideoorder == $coun_tmovie_post) {
                                            ?>
                                        <!-- Code begin here for popular videos in home page display  -->
                                        <div class="gr b floatleft" >
                                            <div class="callout-header-home">
                                                <h2 class="home-link hoverable"><a href="index.php?option=com_contushdvideoshare&view=popularvideos" title="Popular Videos"><?php echo _HDVS_POPULAR_VIDEOS; ?></a></h2>
                                                    </div>
<?php
                                                $totalrecords = count($this->rs_playlist1[2]);
                                                $j = 0;
                                                $k = 0;
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



                                                    if (($i % $this->homepagebottomsettings[0]->homepopularvideocol) == 0) {
?>
                                                        <div class="clear"></div>
                                        <?php } ?>
                                                    <div class="floatleft">

                                        <?php
                                                    if ($this->rs_playlist1[2][$i]->filepath == "File" || $this->rs_playlist1[2][$i]->filepath == "FFmpeg")
                                                        $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[2][$i]->thumburl;
                                                    if ($this->rs_playlist1[2][$i]->filepath == "Url" || $this->rs_playlist1[2][$i]->filepath == "Youtube")
                                                        $src_path = $this->rs_playlist1[2][$i]->thumburl;
                                        ?>

<?php
                                                    $oriname = $this->rs_playlist1[2][$i]->category;     //category name changed here for seo url purpose
                                                    $newrname = explode(' ', $oriname);
                                                    $link = implode('-', $newrname);
                                                    $link1 = explode('&', $link);
                                                    $category = implode('and', $link1);

                                                    $orititle = $this->rs_playlist1[2][$i]->title;
                                                    $newtitle = explode(' ', $orititle);
                                                    $displaytitle = implode('-', $newtitle);

                                                    $final = explode('-', $displaytitle);
                                                    $final1 = implode(' ', $final);
                                                    $final2 = explode('and', $final1);
                                                    $displaytitle11 = implode('&', $final2);
?>

                                                    <div class="home-thumb">
                                                        <div class="home-play-container">
                                                            <span class="play-button-hover">
                                                                <div class="movie-entry yt-uix-hovercard">
                                                                    <a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&<?php echo $popularCategoryVal; ?>&<?php echo $popularVideoVal; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                        <div class="clearfix"></div>
                                                                        <div id="Tooltipwindow" style="clear:both">
                                                                            <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[2][$i]->category; ?></p>
                                                                            <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[2][$i]->description; ?></p>
<?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                <hr>
                                                                                <span ><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
<?php } ?>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div class="show-title-container" >
                                                            <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $popularCategoryVal; ?>&<?php echo $popularVideoVal; ?>" class="show-title-gray info_hover"><?php
                                                    if (strlen($this->rs_playlist1[2][$i]->title) > 18) {
                                                        echo (substr($this->rs_playlist1[2][$i]->title, 0, 18)) . "...";
                                                    } else {
                                                        echo $this->rs_playlist1[2][$i]->title;
                                                    }
?></a>
                                                </div>

                                                <span class="video-info">

                                                        <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $popularCategoryVal; ?>"><?php echo $this->rs_playlist1[2][$i]->category; ?></a>
                                                </span>

                                                        <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) {
                                                        ?>
                                                    <span class="video-info">
                                                        <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
<?php
                                                            if (isset($this->rs_playlist1[2][$i]->ratecount) && $this->rs_playlist1[2][$i]->ratecount != 0) {
                                                                $ratestar = round($this->rs_playlist1[2][$i]->rate / $this->rs_playlist1[2][$i]->ratecount);
                                                            } else {
                                                                $ratestar = 0;
                                                            }
?>
                                                                <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                            </span>
                                                    <?php } ?>
                                                    <div class="clear"></div>
                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
                                                    ?>
                                                        <span class="video-info">
                                                            <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>

                                                            <span class="floatleft"><?php echo $this->rs_playlist1[2][$i]->times_viewed; ?></span>
                                                        </span>
                                                <?php } ?>
                                                        <div class="clear"></div>
                                                        <!--
                                                          <span class="video-info">
                                                           More: <a href="" class="info_hover"><?php
                                                        if (strlen($this->rs_playlist1[2][$i]->title) > 18) {
                                                            echo (substr($this->rs_playlist1[2][$i]->title, 0, 18)) . "...";
                                                        } else {
                                                            echo $this->rs_playlist1[2][$i]->title;
                                                        }
                                                ?></a>
                                                                  </span>
                                                        -->




                                                    </div>
                                                <?php if ($j != 1) {
                                                ?>

<?php } $j++; ?>
                                                </div>
<?php
                                                    }

//        }// related videos
                                                    // }
?><div class="clear"></div>
<?php /* if($totalrecords>1) { ?>
                                                      <a href="index.php?option=com_contushdvideoshare&view=popularvideos" class="clear">
                                                      <span class="morebtn"></span>
                                                      </a>
                                                      <?php } */ ?>
                                                    <br/>
                                                </div>


                                        <?php } ?>
                                        <?php if ($this->homepagebottomsettings[0]->homerecentvideo == 1 && $this->homepagebottomsettings[0]->homerecentvideoorder == $coun_tmovie_post) {
                                        ?>
                                                <!-- Code end here for Popular videos in home page display -->

                                                <!-- Code begin here for Recent videos in home page display  -->



                                                <div class="gr c floatleft"  >
                                                    <div class="callout-header-home">
                                                        <h2 class="home-link hoverable"><a href="index.php?option=com_contushdvideoshare&view=recentvideos" title="Recent Videos"> <?php echo _HDVS_RECENT_VIDEOS; ?></a></h2>
                                                        </div>
<?php
                                                    $totalrecords = count($this->rs_playlist1[1]);
                                                    $j = 0;
                                                    $k = 0;
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

                                                        if (($i % $this->homepagebottomsettings[0]->homerecentvideocol) == 0) {
?>
                                                            <div class="clear"></div>
                                        <?php } ?>
                                                        <div class="floatleft">

                                        <?php
                                                        if ($this->rs_playlist1[1][$i]->filepath == "File" || $this->rs_playlist1[1][$i]->filepath == "FFmpeg")
                                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->rs_playlist1[1][$i]->thumburl;
                                                        if ($this->rs_playlist1[1][$i]->filepath == "Url" || $this->rs_playlist1[1][$i]->filepath == "Youtube")
                                                            $src_path = $this->rs_playlist1[1][$i]->thumburl;
                                        ?>

<?php
                                                        $oriname = $this->rs_playlist1[1][$i]->category;     //category name changed here for seo url purpose
                                                        $newrname = explode(' ', $oriname);
                                                        $link = implode('-', $newrname);
                                                        $link1 = explode('&', $link);
                                                        $category = implode('and', $link1);

                                                        $orititle = $this->rs_playlist1[1][$i]->title;
                                                        $newtitle = explode(' ', $orititle);
                                                        $displaytitle = implode('-', $newtitle);

                                                        $final = explode('-', $displaytitle);
                                                        $final1 = implode(' ', $final);
                                                        $final2 = explode('and', $final1);
                                                        $displaytitle11 = implode('&', $final2);
?>

                                                        <div class="home-thumb">
                                                            <div class="home-play-container">
                                                                <span class="play-button-hover">

                                                                    <div class="movie-entry yt-uix-hovercard">
                                                                        <a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&<?php echo $recentCategoryVal; ?>&<?php echo $recentVideoVal; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                                                            <div class="clearfix"></div>
                                                                            <div id="Tooltipwindow" style="clear:both">
                                                                                <p ><?php echo '<strong>' . _HDVS_CATEGORY . ' : ' . '</strong>' . $this->rs_playlist1[1][$i]->category; ?></p>
                                                                                <p ><?php echo '<strong>' . _HDVS_DESCRIPTION . ' : ' . '</strong>' . $this->rs_playlist1[1][$i]->description; ?></p>
<?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) { ?>
                                                                                    <hr>
                                                                                    <span ><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?> <?php echo '<strong>' . _HDVS_VIEWS . '</strong>'; ?></span>
<?php } ?>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                </span>
                                                            </div>

                                                            <div class="show-title-container">
                                                                <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $recentCategoryVal; ?>&<?php echo $recentVideoVal ?>" class="show-title-gray info_hover"><?php
                                                        if (strlen($this->rs_playlist1[1][$i]->title) > 18) {
                                                            echo (substr($this->rs_playlist1[1][$i]->title, 0, 18)) . "...";
                                                        } else {
                                                            echo $this->rs_playlist1[1][$i]->title;
                                                        }
?></a>
                                                </div>

                                                <span class="video-info">

                                                        <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $recentCategoryVal; ?>"><?php echo $this->rs_playlist1[1][$i]->category; ?></a>
                                                </span>
                                                        <?php if ($this->homepagebottomsettings[0]->ratingscontrol == 1) {
                                                        ?>
                                                    <span class="video-info">
                                                        <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
<?php
                                                            if (isset($this->rs_playlist1[1][$i]->ratecount) && $this->rs_playlist1[1][$i]->ratecount != 0) {
                                                                $ratestar = round($this->rs_playlist1[1][$i]->rate / $this->rs_playlist1[1][$i]->ratecount);
                                                            } else {
                                                                $ratestar = 0;
                                                            }
?>
                                                                <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                            </span>
<?php } ?>
                                                        <div class="clear"></div>
                                                    <?php if ($this->homepagebottomsettings[0]->viewedconrtol == 1) {
                                                    ?>
                                                        <span class="video-info">
                                                            <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>

                                                            <span class="floatleft"><?php echo $this->rs_playlist1[1][$i]->times_viewed; ?></span>
                                                        </span>

                                                <?php } ?>

                                                        <div class="clear"></div>
                                                    </div>
<?php $j++; ?>
                                                </div>
<?php
                                                    }
?><div class="clear"></div>
                                        </div> <div class="clear"></div>
                                                <?php }
                                            } ?>
                                    <!-- Code end here for Recent videos in home page display -->
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
        </td>
    </tr>
</table>
<?php } ?>
    <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php
                                        if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                                            echo JRequest::getVar('memberidvalue', '', 'post', 'int');
                                        };
?>" />
    </form>
    <script type="text/javascript" language="javascript">
        function membervalue(memid)
        {
            document.getElementById('memberidvalue').value=memid;
            document.forms['memberidform'].action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>";
        document.forms['memberidform'].submit();
    }

</script>