<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

//include($baseurl."components/com_contushdvideoshare/language/danish.php");

$session =& JFactory::getSession();
$user =& JFactory::getUser();

//$user->get('username');
if($user->get('id')=='')
{
$url = $baseurl."index.php?option=com_user&view=register";
header("Location: $url");
}
?>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<?php
$app =& JFactory::getApplication();

if( $app->getTemplate()!= 'hulutheme')
{
echo '<link rel="stylesheet" href="'.JURI::base().'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';

if($user->get('id')!='')
{?>

<span style='float:right'><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?> </a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare'); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>

<?php }else{
?>
<span style='float:right'><b><a href="index.php?option=com_user&view=register"><?PHP ECHO _HDVS_REGISTER; ?></a> | <a  onclick="javascript:popUpWindow('<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentlogin&rmode=true', '200', '200', '320', '240')"><?PHP ECHO _HDVS_LOGIN; ?></a></b></span>
<?php
} }
?>


<div class="player clearfix">
<div id="clsdetail">
<div class="lodinpad">



<div class="toptitle"><h1> <?php echo _HDVS_MY_VIDEOS; ?></h1></div>
<div align="right">

    <form name="hsearch" id="hsearch" method="post" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=myvideos'); ?>" >
                        <input type="text" value="" name="searchtxtboxmember" id="searchtxtboxmember" class="clstextfield clscolor"  onkeypress="validateenterkey(event,'hsearch');" stye="color:#000000; "/>
                        <input type="submit" name="search_btn" id="search_btn" class="button myvideos_search" value="<?PHP ECHO _HDVS_SEARCH; ?>" />
                        <input type="hidden" name="searchval" id="searchval" value="<?php if(isset($_POST['searchtxtbox'])) { echo $_POST['searchtxtbox']; } else { echo $_POST['searchval']; } ;?>" />
                         <?php  if($this->deletevideos['allowupload']==1){ ?>
                    <input type="button" class="button" value="<?PHP ECHO _HDVS_ADD_VIDEO; ?>" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload'); ?>','_self');">
                    <?php } ?>
</form>

</div>

<div class="clear"></div>
<div class="underline"></div>
<div>
<ul id="myclstopul"  >
<li ><?php echo _HDVS_SORT_BY; ?> :</li>
<li><a  title="Sort by title"  class="namelink cursor_pointer" onclick="sortvalue('1');"><?php echo _HDVS_TITLE; ?></a></li>
<li >|</li>
<li ><a  title="Sort by Date"  class="namelink cursor_pointer" onclick="sortvalue('2');"><?php echo _HDVS_DATE_ADDED; ?></a></li>
<li >|</li>
<li ><a  title="Sort by Views"  class="namelink cursor_pointer" onclick="sortvalue('3');"><?php echo _HDVS_VIEWS; ?></a></li>
</ul>
</div>
<div class="clear"></div>
<table width="auto">
<?
//print_r($this->myvideorowcol);

$totalrecords=$this->myvideorowcol[0]->myvideorow * $this->myvideorowcol[0]->myvideocol;
if(count($this->deletevideos)-4<$totalrecords)
{
    $totalrecords = count($this->deletevideos)-4;
}
//$totalrecords = count($this->deletevideos)-4;
                     for($i=0; $i<$totalrecords ; $i++) {
if(isset($this->deletevideos[$i]->filepath))
{



                                            if($i==0){?><tr><?php }
                    if(($i%$this->myvideorowcol[0]->myvideocol)==0){?>
                        </tr><tr>
                     <?php }?>
                            <td class="rightrate">

                          <?

                            if($this->deletevideos[$i]->filepath=="File" || $this->deletevideos[$i]->filepath=="FFmpeg")
							{
							if($this->deletevideos[$i]->thumburl!="")
                            $src_path="components/com_contushdvideoshare/videos/".$this->deletevideos[$i]->thumburl;
							else
							$src_path="";
							}
                            if($this->deletevideos[$i]->filepath=="Url" || $this->deletevideos[$i]->filepath=="Youtube")
                            $src_path =  $this->deletevideos[$i]->thumburl;
                            ?>
                               <?php    if($this->deletevideos[$i]->vid!='')
                                       { ?>

                            <div id="imiddlecontent1" >
                             <div class="featurecontent clearfix">
                                <div class="middleleftcontent">
                              <div class="videopic" >
                                        <?php
                                        $orititle=$this->deletevideos[$i]->title;       //Title name changed here for seo url purpose
                                        $newtitle=explode(' ',$orititle);
                                        $displaytitle1=implode('-',$newtitle);
                                        $displaytitle=str_replace('.','',$displaytitle1);

//                                        $oriname=$this->deletevideos[$i]->category;     //category name changed here for seo url purpose
//                                        $newrname=explode(' ',$oriname);
//                                        $link=implode('-',$newrname);
//                                        $link1=explode('&',$link);
//                                        $category=implode('and',$link1);

                                         $final=explode('-',$displaytitle);
                                         $final1=implode(' ',$final);
                                         $final2=explode('and',$final1);
                                         $displaytitle11=implode('&',$final2);
                                          $img_path="components/com_contushdvideoshare/images/default_thumb.jpg";
                                        ?>
                                 <div class="bottomalign"  >
                                 
                                
                                 <div class="movie-entry yt-uix-hovercard">
 <a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&id=<?php echo $this->deletevideos[$i]->id; ?>&catid=<?php echo $this->deletevideos[$i]->catid; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                   <div class="clearfix"></div>
                                            <div id="Tooltipwindow" style="clear:both">
                                            <p ><?php echo '<strong>'._HDVS_CATEGORY . ' : ' . '</strong>'.$this->deletevideos[$i]->category; ?></p>
                                            <p ><?php echo '<strong>'._HDVS_DESCRIPTION . ' : ' . '</strong>'.$this->deletevideos[$i]->description; ?></p>
                                            
                                            <?php if ($this->myvideorowcol[0]->viewedconrtol  ==1){?>
                                            <hr>
                                            <span ><?php echo $this->deletevideos[$i]->times_viewed; ?> <?php echo '<strong>'._HDVS_VIEWS .'</strong>'; ?></span>
                                            <?php } ?>
                                        </div>
                                    </a>
</div>

                                 </div>
                                <div class="myfeatureright"   >

                         <?php if ($this->myvideorowcol[0]->viewedconrtol  ==1){?>
                        <div class="myview"> <?php echo _HDVS_VIEWS." : ". ' ' .$this->deletevideos[$i]->times_viewed; ?></div>
                        <?php }?>
                        <span class="myview"> <?php echo _HDVS_COMMENTS; ?> :<a href="index.php?option=com_contushdvideoshare&view=player&id=<?php echo $this->deletevideos[$i]->vid;?>&catid=<?php echo $this->deletevideos[$i]->catid;?>"><?php if(isset($this->deletevideos[$i]->total)) { echo $this->deletevideos[$i]->total; } ?></a></span>
                        <?php //} ?>
                       </div>
                        </div></div>
                        <div class="featureright">
                        <p class="myview"><a href="index.php?option=com_contushdvideoshare&view=player&id=<?php echo $this->deletevideos[$i]->vid;?>&catid=<?php echo $this->deletevideos[$i]->catid;?>" title="<?php echo $this->deletevideos[$i]->title;?>"><?php if(strlen($this->deletevideos[$i]->title)>15) { echo (substr($this->deletevideos[$i]->title,0,15))."..."; } else { echo $this->deletevideos[$i]->title; }?></a></p>
                          <?php
                           $addeddate=$this->deletevideos[$i]->addedon;
                           $addedon=date('F j, Y', strtotime($addeddate)); ?>
                          <p class="myview"> <?php echo _HDVS_ADDED_ON." : ". ' ' .$addedon; ?></p>
                          <?php if($this->deletevideos[$i]->type==0)
                          { $vtype=_HDVS_PUBLIC;  }
                          else
                          { $vtype=_HDVS_PRIVATE; }
                          ?>
                          <p class="myview"> <?php echo _HDVS_VIDEO_TYPE." : ". ' ' .$vtype; ?></p>
                           <?php if($this->deletevideos[$i]->published==1)
                          { $status=_HDVS_ACTIVE;  }
                          else
                          { $status=_HDVS_BLOCKED; }
                          ?>
                          <p class="myview"> <?php echo _HDVS_VIDEO_STATUS." : ". ' ' .$status; ?></p>
                          <div class="myvideosbtns">


                          <input type="button" name="playvideo" id="playvideo" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&id='.$this->deletevideos[$i]->vid.'&catid='.$this->deletevideos[$i]->catid); ?>','_self')" value="<?php echo _HDVS_PLAY; ?>" class="button"  />


                          <input type="button" name="videoedit" id="videoedit" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload&id='.$this->deletevideos[$i]->vid.'&type=edit'); ?>','_self')" value="<?php echo _HDVS_EDIT; ?>" class="button" />

                          <input type="button" name="videodelete" id="videodelete" value="<?php echo _HDVS_DELETE; ?>" class="button" onclick="var flg=my_message(<?php echo $this->deletevideos[$i]->vid;?>); return flg;" />
                          </div>
                       </div>

                    </div>


                            </div>
                 </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                           <?php } ?>
                        <!----------First row---------->
                        <?php
                    }
}
                    ?>
</table>
                        <!--  PAGINATION STARTS HERE-->



                        <table cellpadding="0" cellspacing="0" border="0" id="pagination" align="right">
                            <tr align="right">
                                <td align="right"  class="page_rightspace">
                                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                        <tr>

                                        <?php
                                        $pages=$this->deletevideos['pages'];
                                        //echo $pages."hai";
                                        $q=$this->deletevideos['pageno'];
                                     $q1=$this->deletevideos['pageno']-1;
                                     if($this->deletevideos['pageno']>1)
                         echo("<td align='right'><a onclick='changepage($q1);'>"._HDVS_PREVIOUS."</a></td>");
                        if(JRequest::getVar('page','','post','int'))
                        {
                        if(JRequest::getVar('page','','post','int') > 3)
                        {
                            $page=JRequest::getVar('page','','post','int')-2;
                            if(JRequest::getVar('page','','post','int') > 2)
                            {
                                echo("<td align='right'><a onclick='changepage(1)'>1</a></td>");
                                echo ("<td align='right'>...</td>");
                            }
                        }
                        else
                        $page=1;
                        }
                        else
                        $page=1;
                        for($i=$page,$j=1;$i<=$pages;$i++,$j++)
                        {
                        if($q!=$i)
                        echo("<td align='right'><a onclick='changepage(".$i.")'>".$i."</a></td>");
                        else
                        echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                        if($j>3)
                        break;
                        }
                        if($i<$pages)
                        {
                        if($i+1!=$pages)
                        echo ("<td align='right'>...</td>");
                        echo("<td align='right'><a onclick='changepage(".$pages.")'>".$pages."</a></td>");
                        }
                        $p=$q+1;
                        if($q <$pages)
                        echo ("<td align='right'><a onclick='changepage($p);'>"._HDVS_NEXT."</a></td>");

                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                     <br/>
                    </div>
                       </div>
                       </div>
<?php $page=$_SERVER['REQUEST_URI']; ?>
<form name="deletemyvideo"  action="<?php echo $page;?>" method="post">

<input type="hidden" name="deletevideo" id="deletevideo" value="<?php if(JRequest::getVar('deletevideo','','post','int')) { JRequest::getVar('deletevideo','','post','int'); } ;?>">
</form>
<form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
<input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php if(JRequest::getVar('memberidvalue','','post','int')) { echo JRequest::getVar('memberidvalue','','post','int'); } ;?>" />
</form>
<form name="pagination" id="pagination" action="<?php echo $page;?>" method="post">
    <input type="hidden" id="page" name="page" value="<?php if(JRequest::getVar('page','','post','int')) { echo JRequest::getVar('page','','post','int'); } ;?>" />
    <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php if(JRequest::getVar('searchtxtbox','','post','string')) { echo JRequest::getVar('searchtxtbox','','post','string'); } else { echo JRequest::getVar('hidsearchtxtbox','','post','string'); } ;?>" />
</form>
<form name="sortform"  action="<?php echo $page;?>" method="post">
<input type="hidden" name="sorting" id="sorting" value="<?php if(JRequest::getVar('sorting','','post','string')) { echo JRequest::getVar('sorting','','post','string'); } ;?>">
</form>

<script type="text/javascript">

   function changepage(pageno)
    {
        document.getElementById("page").value=pageno;
        document.pagination.submit();
    }

function my_message(vid)
{
var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
if (flg)
    {
      var r=document.getElementById('deletevideo').value=vid;
      document.deletemyvideo.submit();
      return true;
    }
else
    {
      return false;
    }
}
 function videoplay(vid,cat)
    {
        window.open('index.php?option=com_contushdvideoshare&view=player&id='+vid+'&catid='+cat,'_self');
    }
function editvideo(evid)
    {

        window.open(evid,'_self');
    }
function sortvalue(sortvalue)
{
document.getElementById("sorting").value=sortvalue;
document.sortform.submit();
}
 function membervalue(memid)
    {
      document.getElementById('memberidvalue').value=memid;
      document.memberidform.submit();
    }

</script>
