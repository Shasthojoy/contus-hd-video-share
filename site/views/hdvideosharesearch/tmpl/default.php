<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Hdvideoshare Search View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');
//ratings array declaration
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = JFactory::getUser();
//get current page
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css');?>
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
<div class="player clearfix">
    <div id="clsdetail">
        <div class="lodinpad">
            <?php         
               if (USER_LOGIN == '1')
            {
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
           <?php  } }
                else
                {
                    if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><span class="toprightmenu"><b><a href="index.php?option=com_users&view=registration"><?php ECHO JText::_('HDVS_REGISTER'); ?></a> |
                <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a></b></span>
           <?php }  else {      ?>
                    <span class="toprightmenu"><b><a href="index.php?option=com_user&view=register"><?php ECHO JText::_('HDVS_REGISTER'); ?></a> |
                            <a  href="index.php?option=com_user&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a></b></span>
        <?php
                } }
            }
            
            ?>
            <?php
            $totalRecords = $this->searchrowcol[0]->searchcol * $this->searchrowcol[0]->searchrow;
            if (count($this->search) - 4 < $totalRecords) {
                $totalRecords = count($this->search) - 4;
            }
            if ($totalRecords == -4) {
            ?>
                <div class="callout-header-home">
                    <h2 class="home-link hoverable"><?php echo JText::_('HDVS_SEARCH_RESULT'); ?></h2>
                </div>
            <?php
                echo '<div align="center" style="padding-top:10px;color:#274576;font-weight:bold;"> ' . JText::_('HDVS_NO_RECORDS_FOUND') . ' </div>';
            } else {
            ?>
                <div class="videoheadline"></div>
                <div class="section" >
                    <div class="standard tidy">
                        <div class="layout b-c">
                            <div class="gr b" >
                                <div class="layout a-b-c">
                                    <div class="gr a">
                                        <div class="callout-header-home">
                                            <h2 class="home-link hoverable"><?php echo JText::_('HDVS_SEARCH_RESULT'); ?></h2>
                                        </div>
                                        <table>
                                       
<?php
                $no_of_columns = $this->searchrowcol[0]->searchcol;
                $current_column = 1;
                for ($i = 0; $i < $totalRecords; $i++) {
                    $colcount = $current_column % $no_of_columns;
                    if ($colcount == 1) {
                        echo '<tr>';
                    }
                    $seoOption = $this->searchrowcol[0]->seo_option;
                    if ($seoOption == 1) {
                        $searchCategoryVal = "category=" . $this->search[$i]->seo_category;
                        $searchVideoVal = "video=" . $this->search[$i]->seotitle;
                    } else {
                        $searchCategoryVal = "catid=" . $this->search[$i]->catid;
                        $searchVideoVal = "id=" . $this->search[$i]->vid;
                    }

                    if ($this->search[$i]->filepath == "File" || $this->search[$i]->filepath == "FFmpeg") {
                        $src_path = "components/com_contushdvideoshare/videos/" . $this->search[$i]->thumburl;
                    }elseif ($this->search[$i]->filepath == "Url" || $this->search[$i]->filepath == "Youtube") {
                        $src_path = $this->search[$i]->thumburl;
                    }else {
                    	$src_path = 'channelpath';
                    }?>
                     <td style="vertical-align:top;">
                    <?php 
                        if($src_path == 'channelpath') {
                        if(isset($this->search[$i]->rate) && $this->search[$i]->rate) {
                    		$logo_path = "components/com_contushdvideoshare/videos/" . $this->search[$i]->rate;
                    	} else {
                    		$logo_path = "components/com_contushdvideoshare/videos/default_thumb.jpg";
                    	}
                        ?>
                        
              				<div class="home-thumb">
                                                    <div class="home-play-container" >
                                                        <span class="play-button-hover">
                                                            <div class="movie-entry yt-uix-hovercard">

                                                                <div class="tooltip">                                                                 
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=mychannel&amp;channelname=".$this->search[$i]->seo_category); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $logo_path; ?>"  border="0"  width="125" height="69" title="" alt="thumb_image" /></p></a>
                                                                                               <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage" alt="tip_image"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . JText::_('HDVS_CHANNEL_NAME') . ' : ' . '</span>' .'<span class="clstoolright">'. $this->search[$i]->seo_category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . JText::_('HDVS_DESCRIPTION') . ' : ' . '</span>' .'<p>'. $this->search[$i]->catid.'</p>'; ?>
                                               
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo JText::_('HDVS_VIEWS'); ?>: </span><span class="clstoolright"><?php echo $this->search[$i]->thumburl; ?> </span></div>
                                                          </div></div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="show-title-container">
                                                        <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=mychannel&amp;channelname=".$this->search[$i]->seo_category); ?>" class="show-title-gray info_hover"><?php
                                            if (strlen($this->search[$i]->seo_category) > 18) {
                                                //echo (substr($this->search[$i]->title, 0, 18)) . "...";
                                                echo JHTML::_('string.truncate', ($this->search[$i]->seo_category), 18);
                                            } else {
                                                echo $this->search[$i]->seo_category;
                                            }
?></a>
                                                </div>  
                                                 <span class="video-info"><?php echo JText::_('HDVS_CHANNEL');?></span>
                                                            <span class="floatright viewcolor">  <?PHP echo JText::_('HDVS_VIEWS'); ?></span>

                                                            <span class="floatright viewcolor view"><?php echo $this->search[$i]->thumburl; ?></span>

                                                    
                                                <div class="clear"></div>
                                            </div>
                        	
                        <?php } else {
?>
                                        <?php if ($this->search[$i]->vid != '') {
 ?>
                                            
                                                <div class="home-thumb">
                                                    <div class="home-play-container" >
                                                        <span class="play-button-hover">
                                                            <div class="movie-entry yt-uix-hovercard">

                                                                <div class="tooltip">
                                                                 <?php
                                                                    if (isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount != 0) {
                                                                        $ratestar = round($this->search[$i]->rate / $this->search[$i]->ratecount);
                                                                    } else {
                                                                        $ratestar = 0;
                                                                    }
                                                                ?>
                                          <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $searchCategoryVal . "&amp;" . $searchVideoVal); ?>" ><p class="thumb_resize"><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="125" height="69" title="" alt="thumb_image" /></p></a>
                                                                                               <div class="Tooltipwindow" >
                                               <img src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/tip.png" class="tipimage" alt="tip_image"/>
                                                    <?php echo '<div class="clearfix"><span class="clstoolleft">' . JText::_('HDVS_CATEGORY') . ' : ' . '</span>' .'<span class="clstoolright">'. $this->search[$i]->category.'</span></div>'; ?>
                                                    <?php echo '<span class="clsdescription">' . JText::_('HDVS_DESCRIPTION') . ' : ' . '</span>' .'<p>'. $this->search[$i]->description.'</p>'; ?>
                                               <?php if ($this->searchrowcol[0]->ratingscontrol == 1) { ?>
                                                    <div class="clearfix"> <?php echo '<span class="clstoolleft">' . JText::_('HDVS_RATTING') . ' : ' . '</span>'; ?>
                                                    <div class="clstoolright ratingvalue ratethis1 <?php echo $ratearray[$ratestar]; ?>" ></div></div>
                                              <?php } ?>
                                                        <?php if ($this->searchrowcol[0]->viewedconrtol == 1) { ?>
                                                    <div class="clearfix"><span class="clstoolleft"><?php echo JText::_('HDVS_VIEWS'); ?>: </span><span class="clstoolright"><?php echo $this->search[$i]->times_viewed; ?> </span></div>
                                                           <?php } ?></div></div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="show-title-container">
                                                        <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $searchCategoryVal; ?>&<?php echo $searchVideoVal; ?>" class="show-title-gray info_hover"><?php
                                            if (strlen($this->search[$i]->title) > 18) {
                                                //echo (substr($this->search[$i]->title, 0, 18)) . "...";
                                                echo JHTML::_('string.truncate', ($this->search[$i]->title), 18);
                                            } else {
                                                echo $this->search[$i]->title;
                                            }
?></a>
                                                </div>
                                                <span class="video-info">
<a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $searchCategoryVal; ?>"><?php echo $this->search[$i]->category; ?></a>
                                                </span>
<?php
                                            if ($this->searchrowcol[0]->ratingscontrol == 1) {
?>
                                                <span class="floatleft">

                                                        <?php
                                                        if (isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount != 0) {
                                                            $ratestar = round($this->search[$i]->rate / $this->search[$i]->ratecount);
                                                        } else {
                                                            $ratestar = 0;
                                                        }
                                                        ?>
                                                    <span class="floatleft innerrating"><div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div></span>
                                                </span>
<?php } ?>

                                                <?php if ($this->searchrowcol[0]->viewedconrtol == 1) {
 ?>

                                                            <span class="floatright viewcolor">  <?PHP echo JText::_('HDVS_VIEWS'); ?></span>

                                                            <span class="floatright viewcolor view"><?php echo $this->search[$i]->times_viewed; ?></span>

                                                    <?php } ?>
                                                <div class="clear"></div>
                                            </div>
                                                    <?php } }?>
                                            <!--First row-->
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
        <table cellpadding="0" cellspacing="0" border="0"   class="page_align"   id="pagination" >
                                <tr align="right">
                                    <td align="right"  class="page_rightspace">
                                        <table cellpadding="0" cellspacing="0"  border="0" align="right">
                                            <tr>
                        <?php
                                                    $pages = $this->search['pages'];
                                                    $q = $this->search['pageno'];
                                                    $q1 = $this->search['pageno'] - 1;
                                                    if ($this->search['pageno'] > 1)
                                                        echo("<td align='right'><a onclick='changepage($q1);'>" . JText::_('HDVS_PREVIOUS') . "</a></td>");
                                                    if ($requestpage)
                                                     {
                                                        if ($requestpage > 3)
                                                        {
                                                            $page = $requestpage - 2;
                                                            if ($requestpage > 2)
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
                                                    if($pages >1){
                                                    for ($i = $page, $j = 1; $i <= $pages; $i++, $j++)
                                                     {
                                                        if ($q != $i)
                                                            echo("<td align='right'><a onclick='changepage(" . $i . ")'>" . $i . "</a></td>");
                                                        else
                                                            echo("<td align='right'><a onclick='changepage($i);' class='activepage'>$i</a></td>");
                                                        if ($j > 3)
                                                            break;
                                                    }
                                                    if ($i < $pages)
                                                    {
                                                        if ($i + 1 != $pages)
                                                            echo ("<td align='right'>....</td>");
                                                        echo("<td align='right'><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></td>");
                                                    }
                                                    $p = $q + 1;
                                                    if ($q < $pages)
                                                        echo ("<td align='right'><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></td>");}
                        ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
         <?php } ?>
                    </div>
                </div>
        <?php
                             if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                        {
                                              $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                        }
                                        else{$memberidvalue = '';}
                             ?>

                                        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
                                        </form>
<?php
                                                    $page = $_SERVER['REQUEST_URI'];
                                                    $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                                    $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                                                    $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                                                    if ($requestpage)
                                                    {
                                                        $hidden_page = $requestpage;
                                                    } 
                                                    else
                                                    {
                                                        $hidden_page = '';
                                                    }
                                                    if ($searchtextbox)
                                                    {
                                                        $hidden_searchbox = $searchtextbox;
                                                    } 
                                                    else
                                                    {
                                                        $hidden_searchbox = $hiddensearchbox;
                                                    }
?>
                                                    <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                                                        <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                                                        <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
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
