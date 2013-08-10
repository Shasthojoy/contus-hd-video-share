<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.3
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Sitesettings View Page
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */
/*
 ***********************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
$editsitesettings = $showsitesettings = $this->sitesettings;
JHTML::_('behavior.tooltip');
?>
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')){ ?>
<style type="text/css">
fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button{float: none;}
.order_pos select{width:35px;}
</style>
<?php } else { ?>
<style type="text/css">
fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button{float: none;}
.order_pos select{width: 50px;}
table.adminlist input[type="checkbox"], table.adminlist input[type="radio"]{vertical-align: top;}
table.adminlist input[type="radio"]{margin-right: 5px;}
table.adminlist .radio_algin{padding-top: 28px;}
</style>
<?php } ?>
<script language="JavaScript" type="text/javascript">
function enablefbapi(val) {
	if(val == 1) {		
		document.getElementById('facebook_api').style.display = '';			
		document.getElementById('facebookapi').style.display = '';
	} else {		
		document.getElementById('facebook_api').style.display = 'none';		
		document.getElementById('facebookapi').style.display = 'none';
	}
}
   <?php if(version_compare(JVERSION,'1.6.0','ge'))
                    { ?>Joomla.submitbutton = function(pressbutton) {<?php } else { ?>
                        function submitbutton(pressbutton) {<?php } ?>
        if (pressbutton)
        {           
        	for (var i = 0; i<document.adminForm.elements.length; i++) {  
        		if (document.adminForm.elements[i].type=="text" && document.adminForm.elements[i].style.display != 'none') {      		
        		if (document.adminForm.elements[i].value == "" || document.adminForm.elements[i].value == 0) {
        		alert('Please make sure all fields are entered');
        		return;
        		}
        		}
        		}   		
                 
            submitform( pressbutton );
            return;
        }        
    }
                    
</script>
<!-- sitesettings form start -->
<form
	action="index.php?option=com_contushdvideoshare&layout=sitesettings"
	method="post" name="adminForm" id="adminForm"
	enctype="multipart/form-data" style="position: relative;">
	<fieldset class="adminform">
            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')){ ?>
		<legend>Site settings</legend>
                 <?php } else { ?>
      <h2>Site settings</h2>
                <?php } ?>
		<table <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="adminlist table table-striped"'; else echo 'class="admintable"'; ?> >
			<tr>
				<td width="300px;"><?php echo JHTML::tooltip('Select the commenting system to be displayed in player page', 'Commenting System', 
	            '', 'Commenting System');?></td>
				<td colspan="4"><select name="comment" onchange="enablefbapi(this.value)">
						<option value="0"
						<?php if ($editsitesettings->comment == 0)
						echo "selected=selected"; ?>>None</option>
						<option value="2"
						<?php if ($editsitesettings->comment == 2)
						echo "selected=selected"; ?>>Default</option>
						<option value="1"
						<?php if ($editsitesettings->comment == 1)
						echo "selected=selected"; ?>>FaceBookComment</option>
						<?php
						$jomselected = "";
						if ($this->jomcomment) {

							if ($editsitesettings->comment == 3) {
								$jomselected = "selected=selected";
							}
							echo "<option value='3'" . $jomselected . " >Jom Comment</option>";
						}
						$jcselected = "";
						if ($this->jcomment) {

							if ($editsitesettings->comment == 4) {
								$jcselected = "selected=selected";
							}
							echo "<option value='4'" . $jcselected . " >JComment</option>";
						}						
						?>
				</select> If you want to have Jom Comment or JComment as your
					commenting system for videos, please install them and activate it
					from here.</td>

			</tr>
			<tr id="facebook_api" style="display: none;" >
				<td><?php echo JHTML::tooltip('Enter API key for commenting system', 'Facebook API',
	            '', 'Facebook API');?></td>
				<td colspan="4"><input type="text" name="facebookapi" id="facebookapi" style="display: none;"
					maxlength="100"
					value="<?php echo ($editsitesettings->facebookapi && $editsitesettings->comment == '1')?$editsitesettings->facebookapi:'';?>">
				</td>
			</tr>

			<!-- <tr>
				<td><?php echo JHTML::tooltip('Select the language for front end', 'Language Settings',
	            '', 'Language Settings');?></td>
				<td colspan="4"><select name="language_settings">

				<?php
				/*$selectedlan = "";
				$myabsoluteurl = getcwd();
				$myabsoluteurl = str_replace('administrator', '', $myabsoluteurl);
				$dir ='';
				$image_file_path = $myabsoluteurl . "components/com_contushdvideoshare/language/";
				$d = dir($image_file_path) or die("Wrong path: $image_file_path");
				while (false !== ($entry = $d->read())) {

					if ($entry != 'index.html') {
						if ($editsitesettings->language_settings == $entry)
						$selectedlan = "selected=selected";
						else
						$selectedlan="";


						if ($entry != '.' && $entry != '..' && !is_dir($dir . $entry))
						echo "<option value='" . $entry . "' " . $selectedlan . ">" . str_replace('.php', '', $entry) . "</option>";
					}
				}*/
				?>
				</select>
				</td>
			</tr> -->
			<tr>
				<td width="300px;"><?php echo JHTML::tooltip('Enter row and column for featured videos', 'Featured Videos', 
	            '', 'Featured Videos');?></td>
				<td width="200px;">Row : <input type="text" name="featurrow" id="featurrow"
					maxlength="100" value="<?php echo $editsitesettings->featurrow; ?>">
                                </td><td>Column : <input type="text"  name="featurcol" id="featurcol"
					maxlength="100" value="<?php echo $editsitesettings->featurcol; ?>">
				</td>
                                <td>Gutter Width : <input type="text"  name="featurwidth" id="featurwidth"
					maxlength="100" value="<?php echo $editsitesettings->featurwidth; ?>">
				</td>
      <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
          <?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for recent videos', 'Recent Videos', 
	            '', 'Recent Videos');?></td>
				<td>Row : <input  type="text" name="recentrow" id="recentrow" maxlength="100"
					value="<?php echo $editsitesettings->recentrow; ?>">
				</td><td>Column : <input type="text" name="recentcol" id="recentcol"
					maxlength="100" value="<?php echo $editsitesettings->recentcol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="recentwidth" id="recentwidth"
					maxlength="100" value="<?php echo $editsitesettings->recentwidth; ?>">
				</td>
   <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for popular videos', 'Popular Videos', 
	            '', 'Popular Videos');?></td>
				<td>Row : <input type="text" name="popularrow" id="popularrow" maxlength="100"
					value="<?php echo $editsitesettings->popularrow; ?>">
				</td><td>Column : <input type="text" name="popularcol" id="popularycol"
					maxlength="100"
					value="<?php echo $editsitesettings->popularcol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="popularwidth" id="popularwidth"
					maxlength="100"
					value="<?php echo $editsitesettings->popularwidth; ?>">
				</td>
  <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for category view', 'Category View', 
	            '', 'Category View');?></td>
				<td>Row : <input type="text" name="categoryrow" id="categoryrow" maxlength="100"
					value="<?php echo $editsitesettings->categoryrow; ?>">
				</td><td>Column : <input type="text" name="categorycol" id="categorycol"
					maxlength="100"
					value="<?php echo $editsitesettings->categorycol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="categorywidth" id="categorywidth"
					maxlength="100"
					value="<?php echo $editsitesettings->categorywidth; ?>">
				</td>
   <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for search result videos', 'Search View', 
	            '', 'Search View');?></td>
				<td>Row : <input type="text" name="searchrow" id="searchrow" maxlength="100"
					value="<?php echo $editsitesettings->searchrow; ?>">
				</td><td>Column : <input type="text" name="searchcol" id="searchcol"
					maxlength="100" value="<?php echo $editsitesettings->searchcol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="searchwidth" id="searchwidth"
					maxlength="100" value="<?php echo $editsitesettings->searchwidth; ?>">
				</td>
 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for Related videos', 'Related Videos', 
	            '', 'Related Videos');?></td>
				<td>Row : <input type="text" name="relatedrow" id="relatedrow" maxlength="100"
					value="<?php echo $editsitesettings->relatedrow; ?>">
				</td>
                                <td>Column : <input type="text" name="relatedcol" id="relatedcol"
					maxlength="100"
					value="<?php echo $editsitesettings->relatedcol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="relatedwidth" id="relatedwidth"
					maxlength="100"
					value="<?php echo $editsitesettings->relatedwidth; ?>">
				</td>
                              <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for my videos display', 'My Videos', 
	            '', 'My Videos');?></td>
				<td>Row : <input type="text" name="myvideorow" id="myvideorow" maxlength="100"
					value="<?php echo $editsitesettings->myvideorow; ?>">
				</td>
                                <td>Column : <input type="text" name="myvideocol" id="myvideocol"
					maxlength="100"
					value="<?php echo $editsitesettings->myvideocol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="myvideowidth" id="myvideowidth"
					maxlength="100"
					value="<?php echo $editsitesettings->myvideowidth; ?>">
				</td>
                                <td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for member videos display', 'Member Page View', 
	            '', 'Member Page View');?></td>
				<td>Row : <input type="text" name="memberpagerow" id="memberpagerow"
					maxlength="100"
					value="<?php echo $editsitesettings->memberpagerow; ?>">
				</td>
                                <td>Column : <input type="text" name="memberpagecol"
					id="memberpagecol" maxlength="100"
					value="<?php echo $editsitesettings->memberpagecol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="memberpagewidth"
					id="memberpagewidth" maxlength="100"
					value="<?php echo $editsitesettings->memberpagewidth; ?>">
				</td>
                                                                 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for popular videos module', 'Side Popular Videos', 
	            '', 'Side Popular Videos');?></td>
				<td>Row : <input type="text" name="sidepopularvideorow" id="sidepopularvideorow"
					maxlength="100"
					value="<?php echo $editsitesettings->sidepopularvideorow; ?>">
				</td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo 'colspan="3"'; ?> >Column : <input type="text" name="sidepopularvideocol"
					id="sidepopularvideocol" maxlength="100"
					value="<?php echo $editsitesettings->sidepopularvideocol; ?>">
				</td>
<?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for featured videos module', 'Side Featured Videos', 
	            '', 'Side Featured Videos');?></td>
				<td>Row : <input type="text" name="sidefeaturedvideorow"
					id="sidefeaturedvideorow" maxlength="100"
					value="<?php echo $editsitesettings->sidefeaturedvideorow; ?>">
				</td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo 'colspan="3"'; ?> >Column : <input type="text" name="sidefeaturedvideocol"
					id="sidefeaturedvideocol" maxlength="100"
					value="<?php echo $editsitesettings->sidefeaturedvideocol; ?>">
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for related videos module', 'Side Related Videos', 
	            '', 'Side Related Videos');?></td>
				<td>Row : <input type="text" name="siderelatedvideorow" id="siderelatedvideorow"
					maxlength="100"
					value="<?php echo $editsitesettings->siderelatedvideorow; ?>">
				</td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo 'colspan="3"'; ?> >Column : <input type="text" name="siderelatedvideocol"
					id="siderelatedvideocol" maxlength="100"
					value="<?php echo $editsitesettings->siderelatedvideocol; ?>">
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
<?php } ?>
			</tr>

			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for recent videos module', 'Side Recent Videos', 
	            '', 'Side Recent Videos');?></td>
				<td>Row : <input type="text" name="siderecentvideorow" id="siderecentvideorow"
					maxlength="100"
					value="<?php echo $editsitesettings->siderecentvideorow; ?>">
				</td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo 'colspan="3"'; ?> >Column : <input type="text" name="siderecentvideocol"
					id="siderecentvideocol" maxlength="100"
					value="<?php echo $editsitesettings->siderecentvideocol; ?>">
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td><td>&nbsp;</td>
<?php } ?>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for popular videos in home page', 'Home Page Popular Videos', 
	            '', 'Home Page Popular Videos');?></td>
				<td>Row : <input type="text" name="homepopularvideorow" id="homepopularvideorow"
					maxlength="100"
					value="<?php echo $editsitesettings->homepopularvideorow; ?>">
 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                </td>
				<td>
                                    <?php } ?>
                                    Column : <input type="text" name="homepopularvideocol"
					id="homepopularvideocol" maxlength="100"
					value="<?php echo $editsitesettings->homepopularvideocol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="homepopularvideowidth"
					id="homepopularvideowidth" maxlength="100"
					value="<?php echo $editsitesettings->homepopularvideowidth; ?>">
				</td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="homepopularvideo"
				<?php if ($editsitesettings->homepopularvideo == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="homepopularvideo"
					<?php if ($editsitesettings->homepopularvideo == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="order_pos">Order : <select name="homepopularvideoorder">
						<option value="1"
						<?php if ($editsitesettings->homepopularvideoorder == 1)
						echo "selected=selected"; ?>>1</option>
						<option value="2"
						<?php if ($editsitesettings->homepopularvideoorder == 2)
						echo "selected=selected"; ?>>2</option>
						<option value="3"
						<?php if ($editsitesettings->homepopularvideoorder == 3)
						echo "selected=selected"; ?>>3</option>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for featured videos in home page', 'Home Page Featured Videos', 
	            '', 'Home Page Featured Videos');?></td>
				<td>Row : <input type="text" name="homefeaturedvideorow"
					id="homefeaturedvideorow" maxlength="100"
					value="<?php echo $editsitesettings->homefeaturedvideorow; ?>">
	 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                </td>
				<td>
                                    <?php } ?>
                                    Column : <input type="text" name="homefeaturedvideocol"
					id="homefeaturedvideocol" maxlength="100"
					value="<?php echo $editsitesettings->homefeaturedvideocol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="homefeaturedvideowidth"
					id="homefeaturedvideowidth" maxlength="100"
					value="<?php echo $editsitesettings->homefeaturedvideowidth; ?>">
				</td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="homefeaturedvideo"
				<?php if ($editsitesettings->homefeaturedvideo == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="homefeaturedvideo"
					<?php if ($editsitesettings->homefeaturedvideo == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="order_pos">Order : <select name="homefeaturedvideoorder">
						<option value="1"
						<?php if ($editsitesettings->homefeaturedvideoorder == 1)
						echo "selected=selected"; ?>>1</option>
						<option value="2"
						<?php if ($editsitesettings->homefeaturedvideoorder == 2)
						echo "selected=selected"; ?>>2</option>
						<option value="3"
						<?php if ($editsitesettings->homefeaturedvideoorder == 3)
						echo "selected=selected"; ?>>3</option>
				</select>
				</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Enter row and column for recent videos in home page', 'Home Page Recent Videos', 
	            '', 'Home Page Recent Videos');?></td>
				<td>Row : <input type="text" name="homerecentvideorow" id="homerecentvideorow"
					maxlength="100"
					value="<?php echo $editsitesettings->homerecentvideorow; ?>">
	 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                </td>
				<td>
                                    <?php } ?>
                                    Column : <input type="text" name="homerecentvideocol"
					id="homerecentvideocol" maxlength="100"
					value="<?php echo $editsitesettings->homerecentvideocol; ?>">
				</td>
                                <td>Gutter Width : <input type="text" name="homerecentvideowidth"
					id="homerecentvideowidth" maxlength="100"
					value="<?php echo $editsitesettings->homerecentvideowidth; ?>">
				</td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="homerecentvideo"
				<?php if ($editsitesettings->homerecentvideo == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="homerecentvideo"
					<?php if ($editsitesettings->homerecentvideo == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="order_pos">Order : <select name="homerecentvideoorder">
						<option value="1"
						<?php if ($editsitesettings->homerecentvideoorder == 1)
						echo "selected=selected"; ?>>1</option>
						<option value="2"
						<?php if ($editsitesettings->homerecentvideoorder == 2)
						echo "selected=selected"; ?>>2</option>
						<option value="3"
						<?php if ($editsitesettings->homerecentvideoorder == 3)
						echo "selected=selected"; ?>>3</option>
				</select>
				</td>
			</tr>

			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable video upload option to members', 'Video Upload Option to Members', 
	            '', 'Video Upload Option to Members');?></td>
				<td><input type="radio" name="allowupload" id="allowupload"
				<?php if ($editsitesettings->allowupload == '1' || $editsitesettings->allowupload == '') {
					echo 'checked="checked" ';
				} ?>
					value="1" />Yes</td>
				<td colspan="3"><input type="radio" name="allowupload"
					id="allowupload"
					<?php if ($editsitesettings->allowupload == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />No</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable member Login/Register', 'Members Login/Register', 
	            '', 'Members Login/Register');?></td>
				<td><input type="radio" name="user_login" id="allowupload"
				<?php if ($editsitesettings->user_login == '1') {
					echo 'checked="checked" ';
				} ?>
					value="1" />Yes</td>
				<td colspan="3"><input type="radio" name="user_login"
					id="allowupload"
					<?php if ($editsitesettings->user_login == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />No</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable display ratings', 'Display Ratings', 
	            '', 'Display Ratings');?></td>
				<td><input type="radio" name="ratingscontrol" id="ratingscontrol"
				<?php if ($editsitesettings->ratingscontrol == '1') {
					echo 'checked="checked" ';
				} ?>
					value="1" />Yes</td>
				<td colspan="3"><input type="radio" name="ratingscontrol"
					id="ratingscontrol"
					<?php if ($editsitesettings->ratingscontrol == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />No</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable views display', 'Display Viewed', 
	            '', 'Display Viewed');?></td>
				<td><input type="radio" name="viewedconrtol" id="viewedconrtol"
				<?php if ($editsitesettings->viewedconrtol == '1') {
					echo 'checked="checked" ';
				} ?>
					value="1" />Yes</td>
				<td colspan="3"><input type="radio" name="viewedconrtol"
					id="viewedconrtol"
					<?php if ($editsitesettings->viewedconrtol == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />No</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable social icons display', 'Display Social Links', 
	            '', 'Display Social Links');?></td>
				<td><input type="radio" name="facebooklike" id="facebooklike"
				<?php
				if ($editsitesettings->facebooklike == '1') {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Yes</td>
				<td colspan="3"><input type="radio" name="facebooklike"
					id="facebooklike"
					<?php
					if ($editsitesettings->facebooklike == '0') {
						echo 'checked="checked" ';
					}
					?>
					value="0" />No</td>
			</tr>
			<tr>
				<td><?php echo JHTML::tooltip('Option to enable/disable search engine friendly url', 'Search Engine Friendly URLs', 
	            '', 'Search Engine Friendly URLs');?></td>
				<td ><input type="radio" name="seo_option"
				<?php if ($editsitesettings->seo_option == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable</td>
				<td colspan="3"><input type="radio" name="seo_option"
				<?php if ($editsitesettings->seo_option == 0) {
					echo 'checked="checked" ';
				} ?>
					value="0" />Disable</td>
			</tr>
		</table>
	</fieldset>
	<input type="hidden" name="id"
		value="<?php echo $editsitesettings->id; ?>" /> <input type="hidden"
		name="published" id="published" value="1" /> <input type="hidden"
		name="task" value="" /> <input type="hidden" name="submitted"
		value="true" id="submitted">
</form>
<!-- sitesettings form end -->
<script>
if(<?php echo $editsitesettings->comment == 1?>){	
	enablefbapi('1');		
}
</script>