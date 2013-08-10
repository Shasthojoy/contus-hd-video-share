<?php
/*
* "ContusHDVideoShare Component" - Version 1.2
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: June 15 2010
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$ratearray=array("nopos1","onepos1","twopos1","threepos1","fourpos1","fivepos1");

$user =& JFactory::getUser();

?>
<script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/popup.js"></script>
<?php
$app =& JFactory::getApplication();

if( $app->getTemplate()!= 'hulutheme')
{
echo '<link rel="stylesheet" href="'.JURI::base().'components/com_contushdvideoshare/css/stylesheet.css" type="text/css" />';
if(USER_LOGIN=='1')
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


<div class="section videoscenter" >
    <div class="standard tidy">
      <div class="layout b-c">
        <div class="gr b" >
          <div class="layout a-b-c">

            <div class="gr a">
              <div class="callout-header-home titlespace">
              <h2 class="home-link hoverable"><?PHP ECHO _HDVS_FEATURED_VIDEOS; ?></h2>
              </div>
                         <table>
<?

//print_r($this->featurevideosrowcol[0]);


$totalrecords=$this->featurevideosrowcol[0]->featurcol * $this->featurevideosrowcol[0]->featurrow;
if(count($this->featuredvideos)-4<$totalrecords)
{
    $totalrecords = count($this->featuredvideos)-4;
}


 //print_r($this->featuredvideos);

//echo '<table>';
                        $no_of_columns = $this->featurevideosrowcol[0]->featurcol;
                        $current_column = 1;
                        for($i=0; $i<$totalrecords; $i++) {
                            $colcount = $current_column%$no_of_columns;
                            if ($colcount == 1) {
                                echo '<tr>';
                            }
                            //For SEO settings
                            $seoOption = $this->featurevideosrowcol[0]->seo_option;

                                            if ($seoOption == 1) {
                                                $featuredCategoryVal = "category=" . $this->featuredvideos[$i]->seo_category;
                                                $featuredVideoVal = "video=" . $this->featuredvideos[$i]->seotitle;
                                            } else {
                                                $featuredCategoryVal = "catid=" . $this->featuredvideos[$i]->catid;
                                                $featuredVideoVal = "id=" . $this->featuredvideos[$i]->id;
                                            }
                            if($this->featuredvideos[$i]->filepath=="File" || $this->featuredvideos[$i]->filepath=="FFmpeg")
                            $src_path="components/com_contushdvideoshare/videos/".$this->featuredvideos[$i]->thumburl;
                            if($this->featuredvideos[$i]->filepath=="Url" || $this->featuredvideos[$i]->filepath=="Youtube")
                            $src_path =  $this->featuredvideos[$i]->thumburl;
                            ?>
                            <?php    if($this->featuredvideos[$i]->id!='')
                                       { ?>
                        <td class="rightrate">

                                        <?php
                                        $orititle=$this->featuredvideos[$i]->title;       //Title name changed here for seo url purpose
                                        $newtitle=explode(' ',$orititle);
                                        $displaytitle1=implode('-',$newtitle);
                                        $displaytitle=str_replace('.','',$displaytitle1);

                                        ?>



                                <div class="home-thumb">
  <div class="home-play-container" >
    <span class="play-button-hover">

<div class="movie-entry yt-uix-hovercard">

 <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $featuredCategoryVal;?>&<?php echo $featuredVideoVal;?>" class="info_hover" ><img src="<?php echo $src_path ;?>" class="yt-uix-hovercard-target" border="0" alt="" width="145" height="80" title="" /></a>
<div class="yt-uix-hovercard-content" style="display: none;">
<strong class="hovercard-title" style="color:#000;"><?php echo $this->featuredvideos[$i]->title;  ?></strong><br>
<p class="hovercard-genre"><?php echo $this->featuredvideos[$i]->category;  ?></p>

<p class="hovercard-description" >
    <?php echo $this->featuredvideos[$i]->description;  ?>
</p>

<hr>
<div>
    <span class="hovercard-views">
    <?php echo $this->featuredvideos[$i]->times_viewed;  ?> views
    </span>
</div>
</div>
</div>

    </span>
  </div>


 <div class="show-title-container">
    <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $featuredCategoryVal;?>&<?php echo $featuredVideoVal;?>" class="show-title-gray info_hover"><?php if(strlen($this->featuredvideos[$i]->title)>18) { echo (substr($this->featuredvideos[$i]->title,0,18))."..."; } else { echo $this->featuredvideos[$i]->title; }?></a>
  </div>
  <span class="video-info">

    <?PHP ECHO _HDVS_CATEGORY; ?>: <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $featuredCategoryVal;?>"><?php echo $this->featuredvideos[$i]->category;?></a>
  </span>

  <span class="video-info">
   <span class="floatleft"> <?PHP ECHO _HDVS_RATTING; ?>:</span>
    <?php

    if(isset($this->featuredvideos[$i]->ratecount) && $this->featuredvideos[$i]->ratecount!=0)
{
 $ratestar=round($this->featuredvideos[$i]->rate/$this->featuredvideos[$i]->ratecount);
}
else
{
   $ratestar=0;
} ?>
 <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
  </span>
<div class="clear"></div>
<span class="video-info">
   <span class="floatleft"> <?PHP ECHO _HDVS_VIEWS; ?>:</span>

 <span class="floatleft"><?php echo $this->featuredvideos[$i]->times_viewed; ?></span>
  </span>



<div class="clear"></div>


</div>


                        </td>
                        <?php } ?>
                        <!----------First row---------->
                        <?php //$j++;
//                        if($j%2==0)
//                        { $dummy=1; }
//                        else
//                        {$dummy=2;}
//                        $dum=0;
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
                   // echo '</table>';



               ?>
</table>
    </div>
    </div>
        </div>

        </div>

      </div>    <table cellpadding="0" cellspacing="0" border="0"   class="page_align"   id="pagination" >
                            <tr align="right">
                                <td align="right"  class="page_rightspace">
                                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                        <tr>

                                        <?php
                                        $pages=$this->featuredvideos['pages'];
                                        //echo $pages."hai";
                                        $q=$this->featuredvideos['pageno'];
                                     $q1=$this->featuredvideos['pageno']-1;
                                     if($this->featuredvideos['pageno']>1)
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

                                            ?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
    </div>
          <!--  PAGINATION STARTS HERE-->
                        <br/><br/><br/>



                     <br/>


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
