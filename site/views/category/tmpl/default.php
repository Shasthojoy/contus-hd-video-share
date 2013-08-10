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
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<?php
$app =& JFactory::getApplication();

if( $app->getTemplate()!= 'hulutheme')
{
echo '<link rel="stylesheet" href="'.JURI::base().'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';
if(  USER_LOGIN=='1')
{
if($user->get('id')!='')
{?>

<span style='float:right'><b><a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo _HDVS_MY_VIDEOS; ?> </a> | <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare'); ?>"><?php echo _HDVS_LOGOUT; ?></a></b></span>

<?php }else{
?>
<span style='float:right'><b><a href="index.php?option=com_user&view=register"><?PHP ECHO _HDVS_REGISTER; ?></a> | <a  onclick="javascript:popUpWindow('<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentlogin&rmode=true', '200', '200', '320', '240')"><?PHP ECHO _HDVS_LOGIN; ?></a></b></span>
<?php
} }}
?>


   <div class="player clearfix">
<div id="clsdetail">
                    <div class="lodinpad">



<?php

//$totalrecords=count($this->categoryview)-4;


$totalrecords=$this->categoryrowcol[0]->categorycol * $this->categoryrowcol[0]->categoryrow;
if(count($this->categoryview)-5<$totalrecords)
{
    $totalrecords=count($this->categoryview)-5;
}
if($totalrecords<=0) // If the count is 0 then this part will be executed
{?>
    <div class="callout-header-home">
              <h2 class="home-link hoverable"><?php echo $this->categoryview[0]->category; ?></h2>
              </div>
   <?php echo '<div  class="no-record"> '._HDVS_NO_RECORDS_FOUND.' </div>';
}
else
{
 ?>
 <div class="videoheadline"></div>
  <div class="section" >
    <div class="standard tidy">
      <div class="layout b-c">
        <div class="gr b" >
          <div class="layout a-b-c">

            <div class="gr a">
              <div class="callout-header-home">
              <h2 class="home-link hoverable"><?php echo $this->categoryview['categoryname'][0]->category; ?></h2>
              </div>
                         <table>
<?php
                      //  echo '<table>'; // Table structure for 4 column display of video results in the page
                        $no_of_columns = $this->categoryrowcol[0]->categorycol; // specifying the no of columns
                        $current_column = 1;
                        for($i=0; $i<$totalrecords ; $i++) {
                            $colcount = $current_column%$no_of_columns;
                            if ($colcount == 1) {
                                echo '<tr>';
                            }
                             //For SEO settings
                            $seoOption = $this->categoryrowcol[0]->seo_option;

                                            if ($seoOption == 1) {
                                                $categoryCategoryVal = "category=" . $this->categoryview[$i]->seo_category;
                                                $categoryVideoVal = "video=" . $this->categoryview[$i]->seotitle;
                                            } else {
                                                $categoryCategoryVal = "catid=" . $this->categoryview[$i]->catid;
                                                $categoryVideoVal = "id=" . $this->categoryview[$i]->id;
                                            }
                           
                            if($this->categoryview[$i]->filepath=="File" || $this->categoryview[$i]->filepath=="FFmpeg")
                            $src_path="components/com_contushdvideoshare/videos/".$this->categoryview[$i]->thumburl;
                            if($this->categoryview[$i]->filepath=="Url" || $this->categoryview[$i]->filepath=="Youtube")
                            $src_path =  $this->categoryview[$i]->thumburl;
                            ?>
                             <?php    if($this->categoryview[$i]->id!='')
                                       { ?>
                        <td class="rightrate">

                         
                                        <?php
                                        $orititle=$this->categoryview[$i]->title;       //Title name changed here for seo url purpose
                                        $newtitle=explode(' ',$orititle);
                                        $displaytitle1=implode('-',$newtitle);
                                        $displaytitle=str_replace('.','',$displaytitle1);


//                                        $oriname=$this->categoryview[$i]->category;     //category name changed here for seo url purpose
//                                        $newrname=explode(' ',$oriname);
//                                        $link=implode('-',$newrname);
//                                        $link1=explode('&',$link);
//                                        $category=implode('and',$link1);


                                        $final=explode('-',$displaytitle);
                                         $final1=implode(' ',$final);
                                         $final2=explode('and',$final1);
                                         $displaytitle11=implode('&',$final2);

                                        ?>
                                        

                         <div class="home-thumb">
  <div class="home-play-container" >
    <span class="play-button-hover">
    


<div class="movie-entry yt-uix-hovercard">
<a class="tooltip" href="index.php?option=com_contushdvideoshare&view=player&<?php echo  $categoryCategoryVal; ?>&<?php echo $categoryVideoVal; ?>" class="info_hover"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title=""  />
                                   <div class="clearfix"></div>
                                            <div id="Tooltipwindow" style="clear:both">
                                            <p ><?php echo '<strong>'. _HDVS_CATEGORY . ' : ' . '</strong>'. $this->categoryview[$i]->category; ?></p>
                                            <p ><?php echo  '<strong>'._HDVS_DESCRIPTION . ' : ' .  '</strong>'. $this->categoryview[$i]->description; ?></p>
                                            <?php if ($this->categoryrowcol[0]->viewedconrtol  ==1){?>
                                            <hr>
                                            <span ><?php echo  $this->categoryview[$i]->times_viewed; ?> <?php echo  '<strong>'._HDVS_VIEWS . '</strong>'; ?></span>
                                            <?php } ?>
                                        </div>
                                    </a>
</div>

    </span>
  </div>




  <div class="show-title-container">
    <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $categoryCategoryVal;?>&<?php echo $categoryVideoVal;?>" class="show-title-gray info_hover"><?php if(strlen($this->categoryview[$i]->title)>18) { echo (substr($this->categoryview[$i]->title,0,18))."..."; } else { echo $this->categoryview[$i]->title; }?></a>
  </div>
  <span class="video-info">

    <?php echo _HDVS_CATEGORY; ?> : <a href="index.php?option=com_contushdvideoshare&view=category&<?php $categoryCategoryVal;?>"><?php echo $this->categoryview[$i]->category;?></a>
  </span>
<?php if ($this->categoryrowcol[0]->ratingscontrol  ==1){?>
  <span class="video-info">
   <span class="floatleft"> <?php echo _HDVS_RATTING; ?> :</span>
    <?php

    if(isset($this->categoryview[$i]->ratecount) && $this->categoryview[$i]->ratecount!=0)
{
 $ratestar=round($this->categoryview[$i]->rate/$this->categoryview[$i]->ratecount);
}
else
{
   $ratestar=0;
} ?>
 <span class="floatleft"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
  </span>
                             <?php } ?>
<div class="clear"></div>
<?php if ($this->categoryrowcol[0]->viewedconrtol  ==1){?>
<span class="video-info">
   <span class="floatleft"> <?php echo _HDVS_VIEWS; ?>:</span>

 <span class="floatleft"><?php echo $this->categoryview[$i]->times_viewed; ?></span>
  </span>


<?php } ?>
<div class="clear"></div>

</div>

                        </td>
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
                    } ?>

                    </table>
    </div>
    </div>
        </div>

        </div>

      </div>
    </div>
     <!--  PAGINATION STARTS HERE-->
    <table cellpadding="0" cellspacing="0" border="0"  class="floatright" id="pagination" >
                            <tr align="right">
                                <td align="right"  class="page_rightspace">
                                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                        <tr>

                                        <?php
                                        if(isset($this->categoryview['pageno']))
                                        {
                                     $q=$this->categoryview['pageno']-1;
                                     if($this->categoryview['pageno']>1)
                         echo("<td align='right'><a onclick='changepage($q);'>"._HDVS_PREVIOUS."</a></td>");
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
                        for($i=$page,$j=1;$i<=$this->categoryview['pages'];$i++,$j++)
                        {
                        if($this->categoryview['pageno']!=$i)
                        echo("<td align='right'><a onclick='changepage(".$i.")'>".$i."</a></td>");
                        else
                        echo("<td align='right'><a onclick='changepage($i);' class='active'>$i</a></td>");
                        if($j>3)
                        break;
                        }
                        if($i<$this->categoryview['pages'])
                        {
                        if($i+1!=$this->categoryview['pages'])
                        echo ("<td align='right'>...</td>");
                        echo("<td align='right'><a onclick='changepage(".$this->categoryview['pages'].")'>".$this->categoryview['pages']."</a></td>");
                        }
                        $p=$this->categoryview['pageno']+1;
                        if($this->categoryview['pageno']<$this->categoryview['pages'])
                        echo ("<td align='right'><a onclick='changepage($p);'>"._HDVS_NEXT."</a></td>");

                                        }

                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>   <!--  PAGINATION END HERE-->

               
<?php }
                    ?>
                       
                       


                     
                        <br/><br/>
                    </div>
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