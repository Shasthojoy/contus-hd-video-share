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
 * @abstract      : Contushdvideoshare Component Playlist View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user =  JFactory::getUser();
$session =  JFactory::getSession();
$logoutval_2 = base64_encode('index.php?option=com_contushdvideoshare&view=player');
$editing = '';
$requestpage = '';
$requestpage = JRequest::getVar('page', '', 'post', 'int');
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
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/mychannel.js' );
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/upload_script.js' );
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
          <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a></div>
            <?php }else { ?>
                <div class="toprightmenu">
                <a href="index.php?option=com_contushdvideoshare&view=mychannel"><?php echo JText::_('HDVS_MY_CHANNEL'); ?></a> |
                 <a href="index.php?option=com_contushdvideoshare&view=playlist"><?php echo JText::_('HDVS_MY_PLAYLIST'); ?></a> | 
                 <a href="index.php?option=com_contushdvideoshare&view=channelsettings"><?php echo JText::_('HDVS_CHANNEL_SETTINGS'); ?></a> | 
                 <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> | 
                 <a href="index.php?option=com_user&task=logout&return=<?php echo base64_encode('index.php?option=com_contushdvideoshare&view=player'); ?>"><?php echo JText::_('HDVS_LOGOUT'); ?></a></div>
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
<div class="player clearfix">
<div id="add_playlist" style="display: none;">
            <h1> <?php echo JText::_('HDVS_CREATE_PLAYLIST');?></h1>
            <form action="<?php echo JRoute::_( 'index.php?option=com_contushdvideoshare&view=playlist' ); ?>" method="post">
            <div class="playlist_enter_name"><label><?php echo JText::_('HDVS_PLAYLIST_NAME');?>: </label> <input type="text" id="category" name="category" ></div>
            <div class="clear"></div>
            <h2 class="select_playlist_video"><?php echo JText::_('HDVS_PLAYLIST_COMMENT');?></h2>
            <?php $myVideos = $this->myvideos;
            for($i=0;$i<count($myVideos);$i++) {
            if ($myVideos[$i]->filepath == "File" || $myVideos[$i]->filepath == "FFmpeg")
            $src_path = "components/com_contushdvideoshare/videos/" . $myVideos[$i]->thumburl;
            if ($myVideos[$i]->filepath == "Url" || $myVideos[$i]->filepath == "Youtube")
            $src_path = $myVideos[$i]->thumburl;?>
            <div class="select_playlist">
            <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  title="" alt="thumb_image" />
            <input type="checkbox" name="playlist_videos[]" style=" margin-top: 10px; " value="<?php echo $myVideos[$i]->id;?>"/>
                                        <?php
                                         if (strlen($myVideos[$i]->title) > 35)
                                        {
                                            echo (substr($myVideos[$i]->title, 0, 35)) . "..";
                                        }else {
                                            echo $myVideos[$i]->title;
                                        }
					?>									
                                        
                                        </div>
 <?php }?>
            <div class="clear"></div>
                <button class="button floatright" type="button" onclick="cancelplaylist();"><?php echo JText::_('HDVS_CANCEL');?></button>
                <button class="button floatright playlist_savebtn" type="submit" onclick="return playlistvalidation();"><?php echo JText::_('HDVS_SAVE');?></button>
                <input type="hidden" name="controller" value="contushdvideoshare" />
		<input type="hidden" name="option" value="com_contushdvideoshare" />
		</form>
         
         </div>





    <div id="edit_playlist" style="display: none;">
            <h1> <?php echo "Edit your Playlist";?></h1>
            <form action="<?php echo JRoute::_( 'index.php?option=com_contushdvideoshare&view=playlist' ); ?>" method="post">
            <div class="playlist_enter_name"><label><?php echo "Edit Playlist Name";?>: </label> <input type="text" id="edit_category" name="edit_category" ></div>
            <input type="hidden" id="edit_category_hide" name="edit_category_hide" value="" />
            <div class="clear"></div>
            <h2 class="select_playlist_video"><?php echo JText::_('HDVS_PLAYLIST_COMMENT');?></h2>
            <?php $myVideos = $this->myvideos;
            for($i=0;$i<count($myVideos);$i++) {
            if ($myVideos[$i]->filepath == "File" || $myVideos[$i]->filepath == "FFmpeg")
            $src_path = "components/com_contushdvideoshare/videos/" . $myVideos[$i]->thumburl;
            if ($myVideos[$i]->filepath == "Url" || $myVideos[$i]->filepath == "Youtube")
            $src_path = $myVideos[$i]->thumburl;?>
            <div class="select_playlist">
            <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  title="" alt="thumb_image" />
            <input type="checkbox" id="playlistvideo<?php echo $i+1;?>" name="playlist_videos[]" style=" margin-top: 10px; " value="<?php echo $myVideos[$i]->id;?>"/>
                                        <?php
                                         if (strlen($myVideos[$i]->title) > 35)
                                        {
                                            echo (substr($myVideos[$i]->title, 0, 35)) . "..";
                                        }else {
                                            echo $myVideos[$i]->title;
                                        }
					?>

                                        </div>
 <?php }?>
            <div class="clear"></div>
                <button class="button floatright" type="button" onclick="edit_cancelplaylist();"><?php echo JText::_('HDVS_CANCEL');?></button>
                <button class="button floatright playlist_savebtn" type="submit" onclick="return editplaylistvalidation();"><?php echo JText::_('HDVS_SAVE');?></button>
                <input type="hidden" name="controller" value="contushdvideoshare" />
                                <input type="hidden" name="parentid" id="parentid" value="" />
		<input type="hidden" name="option" value="com_contushdvideoshare" />
		</form>

         </div>





<?php if(JRequest::getString('category')) {?>
<div id="playlist_videos" class="clearfix">
<h1 class="home-link hoverable"><?php echo $this->playlistvideos[0]->category; ?></h1>
                         <div id="video-grid-container" class="clearfix">
                            <?php
                            $totalrecords = 12;
                            if (count($this->playlistvideos) - 4 < $totalrecords)
                            {
                                $totalrecords = count($this->playlistvideos) - 4;
                            }
                            $no_of_columns = 4;
                            $current_column = 1;
                            for ($i = 0; $i < $totalrecords; $i++)
                            {
                                $colcount = $current_column % $no_of_columns;
                                if ($colcount == 1 || $no_of_columns==1)
                                {
                                    echo '<ul class="ulvideo_thumb clearfix">';
                                }
 		//For SEO settings
                                $seoOption = $this->getplaylistsitesettings[0]->seo_option;
                                if ($seoOption == 1)
                                {
                                    $popularCategoryVal = "category=" . $this->playlistvideos[$i]->seo_category;
                                    $popularVideoVal = "video=" . $this->playlistvideos[$i]->seotitle;
                                }
                                else
                                {
                                    $popularCategoryVal = "catid=" . $this->playlistvideos[$i]->catid;
                                    $popularVideoVal = "id=" . $this->playlistvideos[$i]->id;
                                }


                                if ($this->playlistvideos[$i]->filepath == "File" || $this->playlistvideos[$i]->filepath == "FFmpeg")
                                    $src_path = "components/com_contushdvideoshare/videos/" . $this->playlistvideos[$i]->thumburl;
                                if ($this->playlistvideos[$i]->filepath == "Url" || $this->playlistvideos[$i]->filepath == "Youtube")
                                    $src_path = $this->playlistvideos[$i]->thumburl;
                            ?>
                                <li class="video-item sort-videos">
                                <?php
                                $orititle = $this->playlistvideos[$i]->title;       //Title name changed here for seo url purpose
                                $newtitle = explode(' ', $orititle);
                                $displaytitle1 = implode('-', $newtitle);
                                $displaytitle = str_replace('.', '', $displaytitle1);
                                $final = explode('-', $displaytitle);
                                $final1 = implode(' ', $final);
                                $final2 = explode('and', $final1);
                                $displaytitle11 = implode('&', $final2);
                                ?>
                                <div class="home-thumb">
                                     <a class=" info_hover featured_vidimg" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $popularCategoryVal . "&amp;" . $popularVideoVal); ?>" class="info_hover" >
                                      <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"    title=""  /></a>
                                   
                                    <div class="show-title-container">
                                        <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $popularCategoryVal . "&amp;" . $popularVideoVal); ?>" class="show-title-gray info_hover">
                                        <?php
                                        if (strlen($this->playlistvideos[$i]->title) > 50)
                                        {
                                            echo JHTML::_('string.truncate', ($this->playlistvideos[$i]->title), 50);
                                        }else {
                                            echo $this->playlistvideos[$i]->title;
                                        }

                                        ?></a>
                                    </div>
<!--                                    <span class="video-info"> <a href="<?php //echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&'.$popularCategoryVal);?>"><?php //echo $this->playlistvideos[$i]->category; ?></a> </span>-->
                                        <?php 
                                        if ($this->getplaylistsitesettings[0]->ratingscontrol == 1) {
                                        $var = 1;if ($var == 1)
                                                {
                                         ?> <?php
                                                        if (isset($this->playlistvideos[$i]->ratecount) && $this->playlistvideos[$i]->ratecount != 0)
                                                        {
                                                            $ratestar = round($this->playlistvideos[$i]->rate / $this->playlistvideos[$i]->ratecount);
                                                        }
                                                        else
                                                        {
                                                            $ratestar = 0;
                                                        }
                                        ?>
                                                        <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                                                        <?php }
                                                        }
                                                        if ($this->getplaylistsitesettings[0]->viewedconrtol == 1) {
                                                        ?>
                                                            <span class="floatright viewcolor"><?php echo $this->playlistvideos[$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?> </span> <?php } ?>
                                                         </div>
                                                    </li>
                            <?php
                                                    if ($colcount == 0)
                                                    {
                                                        echo '</ul>';
                                                        $current_column = 0;
                                                    }
                                                    $current_column++;
                                                }
//                                                if ($current_column != 0)
//                                                {
//                                                    $rem_columns = $no_of_columns - $current_column + 1;
//                                                    echo "<td colspan=$rem_columns></td></tr>";
//                                                }
                            ?>
                                            </div>
                                          <!-- pagination starts here  -->
                                           <ul class="hd_pagination">
                                            <?php
                                                $pages = $this->playlistvideos['pages'];
                                                $q = $this->playlistvideos['pageno'];
                                                $q1 = $this->playlistvideos['pageno'] - 1;
                                                if ($this->playlistvideos['pageno'] > 1)
                                                    echo("<li><a onclick='changepage($q1);'>" . JText::_('HDVS_PREVIOUS') . "</a></li>");
                                                if ($requestpage)
                                                 {
                                                    if ($requestpage > 4)
                                                      {
                                                        $page = $requestpage - 2;
                                                        if ($requestpage > 3)
                                                        {
                                                            echo("<li><a onclick='changepage(1)'>1</a></li>");
                                                            echo ("<li>...</li>");
                                                        }
                                                    }
                                                    else
                                                        $page=1;
                                                }
                                                else
                                                    $page=1;
                                                if($pages>1){
                                                for ($i = $page, $j = 1; $i <= $pages; $i++, $j++)
                                                {
                                                    if ($q != $i)
                                                        echo("<li><a onclick='changepage(" . $i . ")'>" . $i . "</a></li>");
                                                    else
                                                        echo("<li><a onclick='changepage($i);' class='activepage'>$i</a></li>");
                                                    if ($j > 3)
                                                        break;
                                                }
                                                if ($i < $pages)
                                                {
                                                    if ($i + 1 != $pages)
                                                        echo ("<li>....</li>");
                                                    echo("<li><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></li>");
                                                }
                                                $p = $q + 1;
                                                if ($q < $pages)
                                                    echo ("<li><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></li>");}
                        ?>
                                            </ul>
                                               <?php
                                                $page = $_SERVER['REQUEST_URI'];
                                                $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                                $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                                                $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                                                if ($requestpage)
                                                {
                                                    $hidden_page = $requestpage;
                                                } else {
                                                    $hidden_page = '';
                                                }
                                                if ($searchtextbox) {
                                                    $hidden_searchbox = $searchtextbox;
                                                } else {
                                                    $hidden_searchbox = $hiddensearchbox;
                                                }
?>
                                                <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                                                    <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                                                    <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                                                </form>
                            <script type="text/javascript">
                                function changepage(pageno)
                                {
                                    document.getElementById("page").value=pageno;
                                    document.pagination.submit();
                                }
                            </script>


</div>
<?php }else {?>
<div id="playlist" class="clearfix">
    <h1><?php echo JText::_('HDVS_MY_PLAYLISTS');?></h1>
    <div  id="addnewbutton" class="addnew_btnbg"><button type="button" class="button floatright" onclick="addplaylist()"><?php echo JText::_('HDVS_ADD_NEW');?></button></div>
<?php		if(isset($this->channelvideos)) {
  
                                                    $totalrecords = count($this->channelvideos);
                                                    $j = 0;
                                                    $k = 0;
                                                    for ($i = 0; $i < $totalrecords; $i++)
                                                    {?>
                                                    <?php
                                                    $category = $this->channelvideos[$i][0]->category;
                                                                                                        $parent_id = $this->channelvideos[$i][0]->parent_id;
                                                        if ($this->channelvideos[$i][0]->filepath == "File" || $this->channelvideos[$i][0]->filepath == "FFmpeg")
                                                            $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                                        if ($this->channelvideos[$i][0]->filepath == "Url" || $this->channelvideos[$i][0]->filepath == "Youtube")
                                                            $src_path = $this->channelvideos[$i][0]->thumburl;
                                                        else
                                                        $src_path = "components/com_contushdvideoshare/videos/" . $this->channelvideos[$i][0]->thumburl;
                                        ?>
                                        <div class="playlist_main">
                                        <a class="playlist_title" href = "<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&category='.base64_encode($this->channelvideos[$i][0]->category),true); ?>"><?php echo $this->channelvideos[$i][0]->category; ?></a>
					<a class="featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&category='.base64_encode($this->channelvideos[$i][0]->category),true); ?>">
                                              <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"   title="" alt="thumb_image" />
                                        </a>
<input type="button" name="playlistedit" id="playlistedit" onclick="editplaylist('<?php echo trim($category); ?>','<?php echo $parent_id; ?>')" value="<?php echo JText::_('HDVS_EDIT'); ?>" class="button" />
<input type="button" name="playlistdelete" id="playlistdelete" value="<?php echo JText::_('HDVS_DELETE'); ?>" class="button" onclick="var flg=my_message('<?php echo $this->channelvideos[$i][0]->playlistid; ?>'); return flg;" />

                                        </div>
                                                  <?php   }
?><div class="clear"></div>
<ul class="hd_pagination">
<?php
$channel_id = JRequest::getVar('channelid');
 $page_rows = 12;
 $rows = count($this->channelvideos);
 $last = round($rows/$page_rows);
 if(JRequest::getVar('page')) {
 $curr_page = JRequest::getVar('page');
 } else {
 	$curr_page = 1;
 }
 $prev = $curr_page - 1;
 $next = $curr_page + 1;?>
    <?php if($prev > 0) {?>
    <li><a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$prev,true); ?>"><?php echo 'prev';?></a></li>
 <?php }
 if($last > 1) {
 for($i=1;$i<=$last;$i++) { ?>
    <li><a class="<?php if($curr_page == $i) { echo 'activepage'; }?>" style="color: white;" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$i,true); ?>" ><?php echo $i;?></a></li>
<?php  } }
if($curr_page < $last) {
 ?>
    <li><a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=playlist&page='.$next,true); ?>"><?php echo 'next';?></a></li>
 <?php }?>
 </ul>
<?php } else {?>
<div class="hd_norecords_found"><?php echo JText::_('HDVS_NO_PLAYLIST');?></div>
<?php }?>
</div>
<?php }?>
</div>
<form name="deletemyvideo"  action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="deletevideo" id="deletevideo" value="">
</form>
 <script type="text/javascript">
function my_message(vid)
                                    {
                                        var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
                                        if (flg)
                                        {
                                            document.getElementById('deletevideo').value=vid;
                                            document.deletemyvideo.submit();
                                            return true;
                                        }
                                        else
                                        {
                                            return false;
                                        }
                                    }
                                      </script>