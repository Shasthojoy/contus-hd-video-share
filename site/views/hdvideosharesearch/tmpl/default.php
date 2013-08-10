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

$ratearray=array("nopos1","onepos1","twopos1","threepos1","fourpos1","fivepos1");

$user =& JFactory::getUser();

//$user->get('username');

?>
<?php
$app =& JFactory::getApplication();
if( $app->getTemplate()!= 'hulutheme')
echo '<link rel="stylesheet" href="'.JURI::base().'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';
?>

<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<div class="player clearfix">
<div id="clsdetail">
<div class="lodinpad">

<?php
if( $app->getTemplate()!= 'hulutheme')
{
if(USER_LOGIN=='1')
{
    if($user->get('id')!='')
{?>

<span style='float:right'><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?></a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare'); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>

<?php }else{
?>
<span style='float:right'><b><a href="index.php?option=com_user&view=register"><?PHP ECHO _HDVS_REGISTER; ?></a> | <a  onclick="javascript:popUpWindow('<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentlogin&rmode=true', '200', '200', '320', '240')"><?PHP ECHO _HDVS_LOGIN; ?></a></b></span>
<?php
}
} }
?>

<?


 $totalrecords=$this->searchrowcol[0]->searchcol * $this->searchrowcol[0]->searchrow;
if(count($this->search)-4<$totalrecords)
{
     $totalrecords = count($this->search)-4;
}


 if($totalrecords==-4)
 {?>
      <div class="callout-header-home">
              <h2 class="home-link hoverable"><?PHP ECHO _HDVS_SEARCH_RESULT; ?></h2>
              </div>
     <?php

     echo '<div align="center" style="padding-top:10px;color:#274576;font-weight:bold;"> '._HDVS_NO_RECORDS_FOUND.' </div>';
 }
 else
 { ?>
<div class="videoheadline"></div>
  <div class="section" >
    <div class="standard tidy">
      <div class="layout b-c">
        <div class="gr b" >
          <div class="layout a-b-c">

            <div class="gr a">
              <div class="callout-header-home">
              <h2 class="home-link hoverable"><?PHP ECHO _HDVS_SEARCH_RESULT; ?></h2>
              </div>
                         <table>
<?php //echo '<table>';
                        $no_of_columns = $this->searchrowcol[0]->searchcol;
                        $current_column = 1;
                        for($i=0; $i<$totalrecords ; $i++) {
                            $colcount = $current_column%$no_of_columns;
                            if ($colcount == 1) {
                                echo '<tr>';
                            }
                            //For SEO settings
                            $seoOption = $this->searchrowcol[0]->seo_option;

                                            if ($seoOption == 1) {

                                                $searchCategoryVal = "category=" . $this->search[$i]->seo_category;
                                                $searchVideoVal = "video=" . $this->search[$i]->seotitle;
                                            } else {
                                                $searchCategoryVal = "catid=" . $this->search[$i]->catid;
                                                $searchVideoVal = "id=" . $this->search[$i]->id;
                                            }
                      
                            if($this->search[$i]->filepath=="File" || $this->search[$i]->filepath=="FFmpeg")
                            $src_path="components/com_contushdvideoshare/videos/".$this->search[$i]->thumburl;
                            if($this->search[$i]->filepath=="Url" || $this->search[$i]->filepath=="Youtube")
                            $src_path =  $this->search[$i]->thumburl;
                            ?>
                            <?php    if($this->search[$i]->vid!='')
                                       { ?>
                        <td style="vertical-align:top;">
                            <?php

//                              $oriname=$this->search[$i]->category;     //category name changed here for seo url purpose
//                                        $newrname=explode(' ',$oriname);
//                                        $link=implode('-',$newrname);
//                                        $link1=explode('&',$link);
//                                        $category=implode('and',$link1);
//
                            ?>

                       <div class="home-thumb">
  <div class="home-play-container" >
    <span class="play-button-hover">


<div class="movie-entry yt-uix-hovercard">
<a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&<?php echo $searchCategoryVal; ?>&<?php echo $searchVideoVal; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                   <div class="clearfix"></div>
                                            <div id="Tooltipwindow" style="clear:both">
                                            <p ><?php echo '<strong>'._HDVS_CATEGORY . ' : ' . '</strong>'.$this->search[$i]->category; ?></p>
                                            <p ><?php echo '<strong>'._HDVS_DESCRIPTION . ' : ' . '</strong>'.$this->search[$i]->description; ?></p>
                                            <?php if ($this->searchrowcol[0]->viewedconrtol  ==1){?>
                                            <hr>
                                            <span ><?php echo $this->search[$i]->times_viewed; ?> <?php echo '<strong>'._HDVS_VIEWS .'</strong>'; ?></span>
                                            <?php }?>
                                        </div>
                                    </a>
</div>


    </span>
  </div>

  






<div class="show-title-container">
    <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $searchCategoryVal;?>&<?php echo $searchVideoVal;?>" class="show-title-gray info_hover"><?php if(strlen($this->search[$i]->title)>18) { echo (substr($this->search[$i]->title,0,18))."..."; } else { echo $this->search[$i]->title; }?></a>
  </div>
  <span class="video-info">

   <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $searchCategoryVal;?>"><?php echo $this->search[$i]->category;?></a>
  </span>
                           <?php if ($this->searchrowcol[0]->ratingscontrol  ==1){?>
  <span class="video-info">
   <span style="float:left"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
    <?php

    if(isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount!=0)
{
 $ratestar=round($this->search[$i]->rate/$this->search[$i]->ratecount);
}
else
{
   $ratestar=0;
} ?>
 <span class="floatleft"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
  </span>
                           <?php }?>
<div class="clear"></div>
<?php if ($this->searchrowcol[0]->viewedconrtol  ==1){?>
<span class="video-info">
   <span class="floatleft">  <?PHP ECHO _HDVS_VIEWS; ?>:</span>

 <span class="floatleft"><?php echo $this->search[$i]->times_viewed; ?></span>
  </span>
<?php }?>


<div class="clear"></div>



</div>


                            <?php } ?>
                        <!----------First row---------->
                        <?php 
                        if ($colcount == 0) {
                            echo '</tr><div class="clear"></div>';
                            $current_column = 0;
                        }
                        $current_column++;
                    }
                    if ($current_column != 0) {
                        $rem_columns = $no_of_columns - $current_column + 1;
                        echo "<td colspan=$rem_columns></td></tr>";
                    }
                  //  echo '</table>';
 }
                    ?>

                    </table>
    </div>
    </div>
        </div>

        </div>

      </div>
    </div>
  </div>
                       <!--  PAGINATION STARTS HERE-->
                                            <br/><br/>
  <table cellpadding="0" cellspacing="0" border="0"   class="page_align"  id="pagination" >
                            <tr align="right">
                                <td align="right"  class="page_rightspace">
                                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                        <tr>
                                        <?php
                                        if(isset($this->search['pages']))
                                        $pages=$this->search['pages'];
                                        if(isset($this->search['pageno']))
                                        {
                                       $q=$this->search['pageno'];
                                     $q1=$this->search['pageno']-1;
                                       
                                     if($this->search['pageno']>1)
                         echo("<td align='right'><a onclick='changepage($q1);'>"._HDVS_PREVIOUS."</a></td>");
                          }
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
                        if(isset($pages))
                        {
                        for($i=$page,$j=1;$i<=$pages;$i++,$j++)
                        {
                        if($q!=$i)
                        echo("<td align='right'><a onclick='changepage(".$i.")'>".$i."</a></td>");
                        else
                        echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                        if($j>2)
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
                        }
                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table><br/><br/>
                    </div>
                   </div>
<form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
<input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php if(JRequest::getVar('memberidvalue','','post','int')) { echo JRequest::getVar('memberidvalue','','post','int'); } ;?>" />
</form>
<?php $page=$_SERVER['REQUEST_URI']; ?>
<form name="pagination" id="pagination" action="<?php echo $page;?>" method="post">
    <input type="hidden" id="page" name="page" value="<?php if(JRequest::getVar('page','','post','int')) { echo JRequest::getVar('page','','post','int'); } ;?>" />
    <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php if(JRequest::getVar('searchtxtbox','','post','string')) { echo JRequest::getVar('searchtxtbox','','post','string'); } else { echo JRequest::getVar('hidsearchtxtbox','','post','string'); } ;?>" />
</form>
<script type="text/javascript">
    function membervalue(memid)
    {
      document.getElementById('memberidvalue').value=memid;
      document.memberidform.submit();
    }
      function changepage(pageno)
    {
        document.getElementById("page").value=pageno;
        document.pagination.submit();
    }
</script>
