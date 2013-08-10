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
 * @abstract      : Contus HD Video Share Component Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */
/*
 ***********************************************************/
defined('_JEXEC') or die('Restricted access');
$rs_editsettings = $rs_showsettings = $this->playersettings;
JHTML::_('behavior.tooltip');
?>
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')){ ?>
<style>
fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button
	{
	float: none;
}

table.admintable td.key {
	background-color: #F6F6F6;
	text-align: left;
	width: auto;
	color: #666;
	font-weight: bold;
	border-bottom: 1px solid #E9E9E9;
	border-right: 1px solid #E9E9E9;

}

fieldset label,fieldset span.faux-label {
	float: none;
	clear: left;
	display: block;
	margin: 5px 0;
}
</style>
<?php } else { ?>
<style type="text/css">
    fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button	{float: none;}
    table.admintable td.key {}
    table.adminlist .radio_algin input[type="radio"]{margin:0 5px 0 0;}
    fieldset label,fieldset span.faux-label {float: none;clear: left;display: block;margin: 5px 0;}
</style>
<?php } ?>
<script type="text/javascript">

/**
 * function to hide and show Google Analytics ID
 */

function Toggle(theDiv) {
    if(theDiv=="shows")
    {
        document.getElementById("show").style.display = '';
        document.getElementById("show1").style.display = '';
    }
    else
    {
        document.getElementById("show").style.display = "none";
        document.getElementById("show1").style.display = "none";
    }
}

/**
 * function to hide and show Intermediate Ad
 */

function Toggle1(theDiv) {
    if(theDiv=="showss")
    {
        document.getElementById("imashow").style.display = '';
        document.getElementById("imashow1").style.display = '';
    }
    else
    {
        document.getElementById("imashow").style.display = "none";
        document.getElementById("imashow1").style.display = "none";
    }
}

/**
 * validation for player width and height
 */

	<?php if(version_compare(JVERSION,'1.6.0','ge')){ ?>

		Joomla.submitbutton = function(pressbutton) {
	<?php
	} else {
	?>
	    function submitbutton(pressbutton){
	    <?php
	 } ?>
		if (pressbutton){
			var playerWidth = document.getElementById('player_width').value;
				playerWidth = parseInt(playerWidth);
			var	playerHeight = document.getElementById('player_height').value;
				playerHeight = parseInt(playerHeight);
			var googleana_visible = document.getElementById('googleana_visible').checked;
			var googleanalyticsID =  document.getElementById('googleanalyticsID').value;
					if (!playerWidth || !playerHeight) {
					alert('Please enter minimum width and height value for player');
					return false;
					}
					if(googleana_visible == 1 && googleanalyticsID == '') {
						alert('Please Enter Google Analytics ID');
						return false;
					}
		}
		 submitform( pressbutton );
	     return;
	    }
</script>
<!-- Form For Edit Player Settings Start Here -->
<form
	action="index.php?option=com_contushdvideoshare&layout=settings"
	method="post" name="adminForm" id="adminForm"
	enctype="multipart/form-data">

	<!-- Player Settings Fields Start Here -->
 	<div style="position: relative;">
	<fieldset class="adminform">
            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')){ ?>
		<legend>Player Settings</legend>
                <?php } else { ?>
                <h2>Player Settings</h2>
                <?php } ?>
		<table <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="adminlist table table-striped"'; else echo 'class="admintable adminlist" width="80%"'; ?>>
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Recommended value is 3', 'Buffer Time',
	            '', 'Buffer Time');?></td>
				<td><input type="text" name="buffer"
					value="<?php if(isset($rs_editsettings[0]->buffer)) echo $rs_editsettings[0]->buffer; ?>" /> secs
				</td>
				<td class="key" width=20%><?php echo JHTML::tooltip('Edit the value	to have transparency depth of logo', 'Logo Alpha',
	            '', 'Logo Alpha');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'width="25%"'; ?>><input type="text" name="logoalpha"
					value="<?php if(isset($rs_editsettings[0]->logoalpha)) echo $rs_editsettings[0]->logoalpha; ?>" /> %
				</td>
			</tr>
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Width of the
						video can be 300px with all the controls enabled. If you would
						like to have smaller than 300px then you have to disable couple of
						controls like Timer, Zoom.', 'Width',
	            '', 'Width');?></td>
				<td width=400px;><input type="text" id="player_width" name="width"
					value="<?php if(isset($rs_editsettings[0]->width)) echo $rs_editsettings[0]->width; ?>" /> px
				</td>
				<td class="key"><?php echo JHTML::tooltip('Select Enable to auto hide skin', 'Skin Auto Hide',
	            '', 'Skin Auto Hide');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="skin_autohide"
				<?php if(isset($rs_editsettings[0]->skin_autohide) && $rs_editsettings[0]->skin_autohide == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="skin_autohide"
					<?php if(isset($rs_editsettings[0]->skin_autohide) && $rs_editsettings[0]->skin_autohide == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Recommended value is 400', 'Height',
	            '', 'Height');?></td>
				<td><input type="text" name="height"
					value="<?php if(isset($rs_editsettings[0]->height)) echo $rs_editsettings[0]->height; ?>"
					id="player_height" /> px</td>
				<td class="key"><?php echo JHTML::tooltip('Set the background color for the player in the format ffffff', 'Stage Color',
	            '', 'Stage Color');?></td>
				<td>#<input type="text" name="stagecolor"
					value="<?php if(isset($rs_editsettings[0]->stagecolor)) echo $rs_editsettings[0]->stagecolor; ?>" />
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Select Normal Screen Scale', 'Normal Screen Scale',
	            '', 'Normal Screen Scale');?></td>
				<td><select name="normalscale">
						<option value="0" id="20">Aspect Ratio</option>
						<option value="1" id="21">Original Size</option>
						<option value="2" id="22">Fit to Screen</option>


				</select> <?php
				if(isset($rs_editsettings[0]->normalscale) && $rs_editsettings[0]->normalscale) {

					echo '<script>document.getElementById("2' . $rs_editsettings[0]->normalscale . '").selected="selected"</script>';
				}
				?>
				</td>
				<td class="key"><?php echo JHTML::tooltip('Select Skin for the player', 'Skin',
	            '', 'Skin');?></td>
				<td><select name="skin">

						<option value="skin_black.swf" id="skin_black.swf">Skin Black</option>
						<option value="skin_fancyblack.swf" id="skin_fancyblack.swf">Skin Fancy Black</option>
						<option value="skin_Overlay.swf" id="skin_Overlay.swf">Skin Overlay</option>
						<option value="skin_sleekblack.swf" id="skin_sleekblack.swf">Skin Sleek Black</option>
						<option value="skin_white.swf" id="skin_white.swf">Skin White</option>
						<option value="skin_youtube.swf" id="skin_youtube.swf">Skin Youtube</option>
                                                						<option value="skin_fresh_blue.swf" id="skin_fresh_blue.swf">Skin Fresh Blue</option>
						<option value="skin_fresh_white.swf" id="skin_fresh_white.swf">Skin Fresh White</option>
						<option value="skin_fresh_yellow.swf" id="skin_fresh_yellow.swf">Skin Fresh Yellow</option>
						<option value="skin_neat_fresh_yellow.swf" id="skin_neat_fresh_yellow.swf">Skin Neat Fresh Yellow</option>
				</select> <?php
				if(isset($rs_editsettings[0]->skin) && $rs_editsettings[0]->skin) {
					echo '<script>document.getElementById("' . $rs_editsettings[0]->skin . '").selected="selected"</script>';
				}
				?>
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Select Full Screen Scale', 'Full Screen Scale',
	            '', 'Full Screen Scale');?></td>
				<td><select name="fullscreenscale">
						<option value="0" id="10" name=0>Aspect Ratio</option>
						<option value="1" id="11" name=1>Original Size</option>
						<option value="2" id="12" name=2>Fit to Screen</option>
				</select> <?php
				if(isset($rs_editsettings[0]->fullscreenscale) && $rs_editsettings[0]->fullscreenscale) {
					echo '<script>document.getElementById("1' . $rs_editsettings[0]->fullscreenscale . '").selected="selected"

                                                                                                                                                                                                                                                                                        </script>';
				}
				?>
				</td>
				<td class="key"><?php echo JHTML::tooltip('Fullscreen button can be enable/disabled from here', 'Full Screen',
	            '', 'Full Screen');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="fullscreen"
				<?php if(isset($rs_editsettings[0]->fullscreen) && $rs_editsettings[0]->fullscreen == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="fullscreen"
					<?php if(isset($rs_editsettings[0]->fullscreen) && $rs_editsettings[0]->fullscreen == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to play the videos one by one continuously without clicking on next video', 'Autoplay',
	            '', 'Autoplay');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="autoplay"
				<?php if(isset($rs_editsettings[0]->autoplay) && $rs_editsettings[0]->autoplay == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="autoplay"
					<?php if(isset($rs_editsettings[0]->autoplay) && $rs_editsettings[0]->autoplay == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Zoom button on the player control can be disable / enable here', 'Zoom',
	            '', 'Zoom');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="zoom"
				<?php if(isset($rs_editsettings[0]->zoom) && $rs_editsettings[0]->zoom == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="zoom"
					<?php if(isset($rs_editsettings[0]->zoom) && $rs_editsettings[0]->zoom == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Recommended value is 50', 'Volume',
	            '', 'Volume');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'width="25%"'; ?>><input type="text" name="volume"
					value="<?php if(isset($rs_editsettings[0]->volume)) echo $rs_editsettings[0]->volume; ?>" /> %
				</td>
                                 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                                </tr>


			<tr>
                                <?php } ?>
				<td class="key"><?php echo JHTML::tooltip('Enter FFMpeg Binary Path', 'FFMpeg Binary Path',
	            '', 'FFMpeg Binary Path');?></td>
				<td><input style="width: 150px;" type="text" name="ffmpegpath"
					value="<?php if(isset($rs_editsettings[0]->ffmpegpath)) echo $rs_editsettings[0]->ffmpegpath; ?>" />
				</td>
 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>


			<tr>
<?php } ?>
				<td class="key"><?php echo JHTML::tooltip('Option to set enable / disable timer control on player', 'Timer',
	            '', 'Timer');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="timer"
				<?php if(isset($rs_editsettings[0]->timer) && $rs_editsettings[0]->timer == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="timer"
					<?php if(isset($rs_editsettings[0]->timer) && $rs_editsettings[0]->timer == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>

			<tr>
<?php } ?>
                                <td class="key"><?php echo JHTML::tooltip('Share button on the player can be enabled/disabled from here', 'Share URL',
	            '', 'Share URL');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="shareurl"
				<?php if(isset($rs_editsettings[0]->shareurl) && $rs_editsettings[0]->shareurl == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="shareurl"
					<?php if(isset($rs_editsettings[0]->shareurl) && $rs_editsettings[0]->shareurl == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>


			<tr>
<?php } ?>
				<td class="key"><?php echo JHTML::tooltip('Option to play all the videos from playlist continuously', 'Playlist Autoplay',
	            '', 'Playlist Autoplay');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="playlist_autoplay"
				<?php if(isset($rs_editsettings[0]->playlist_autoplay) && $rs_editsettings[0]->playlist_autoplay == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="playlist_autoplay"
					<?php if(isset($rs_editsettings[0]->playlist_autoplay) && $rs_editsettings[0]->playlist_autoplay == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>

			<tr>
<?php } ?>
                                <td class="key"><?php echo JHTML::tooltip('Option to set the HD videos to play by default', 'HD Default',
	            '', 'HD Default');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="hddefault"
				<?php if(isset($rs_editsettings[0]->hddefault) && $rs_editsettings[0]->hddefault == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="hddefault"
					<?php if(isset($rs_editsettings[0]->hddefault) && $rs_editsettings[0]->hddefault == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
 <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>


			<tr>
<?php } ?>
				<td class="key"><?php echo JHTML::tooltip('Set playlist to open / close always by enable / disable this option', 'Playlist Open',
	            '', 'Playlist Open');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="playlist_open"
				<?php if(isset($rs_editsettings[0]->playlist_open) && $rs_editsettings[0]->playlist_open == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="playlist_open"
					<?php if(isset($rs_editsettings[0]->playlist_open) && $rs_editsettings[0]->playlist_open == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
 <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			</tr>
			<tr>
<?php } ?>
                                <td class="key"><?php echo JHTML::tooltip('Option to set enable/disable related videos display within player', 'Related Videos',
	            '', 'Related Videos');?></td>
				<td><select name="related_videos">
						<option value="1" id="1">Enable</option>
						<option value="2" id="2">Disable</option>
						<!--                        <option value="3" id="3">Within Player</option>
                        <option value="4" id="4">Outside Player</option>-->
				</select> <?php
				if(isset($rs_editsettings[0]->related_videos) && $rs_editsettings[0]->related_videos) {
					echo '<script>document.getElementById("' . $rs_editsettings[0]->related_videos . '").selected="selected"</script>';
				}
				?>
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <?php } ?>
			</tr>
                        <tr>
				<td class="key"><?php echo JHTML::tooltip('Enter Login Page URL', 'Login Page URL',
	            '', 'Login Page URL');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>>
                              <input type="text" name="login_page_url"
					value="<?php if(isset($rs_editsettings[0]->login_page_url)) echo $rs_editsettings[0]->login_page_url; ?>" />
</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Player Settings Fields End -->

	<!-- Pre/Post-Roll Ads Settings Fields Start Here -->
	<div style="position: relative;">
	<fieldset class="adminform">
            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
		<legend>Pre/Post-Roll Ad Settings</legend>
                <?php } else { ?>
                <h2>Pre/Post-Roll Ad Settings</h2>
                <?php } ?>
		<table class="<?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'adminlist table table-striped'; else echo " admintable adminlist"; ?>" width="23%">
			<tr>
                            <td class="key" width="20%"><?php echo JHTML::tooltip('Option to enable/disable post-roll ads', 'Post-roll Ad',
	            '', 'Post-roll Ad');?>
                            </td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin" width="80%"'; else echo 'width="30%"'; ?> ><input type="radio" name="postrollads"
				<?php
				if(isset($rs_editsettings[0]->postrollads) && $rs_editsettings[0]->postrollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="postrollads"
					<?php
					if(isset($rs_editsettings[0]->postrollads) && $rs_editsettings[0]->postrollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
<?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo "</tr>
					<tr>"; ?>
                            <td class="key" width="20%"><?php echo JHTML::tooltip('Option to enable/disable pre-roll ads', 'Pre-roll Ad',
	            '', 'Pre-roll Ad');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin" width="80%"'; ?>><input type="radio" name="prerollads"
				<?php
				if(isset($rs_editsettings[0]->prerollads) && $rs_editsettings[0]->prerollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="prerollads"
					<?php
					if(isset($rs_editsettings[0]->prerollads) && $rs_editsettings[0]->prerollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
			</tr>
			<tr>
                            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable Google Analytics', 'Google Analytics',
	            '', 'Google Analytics');?></td>
                                <td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; else echo 'colspan="3"';?>  width="80%">
                                    <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo '<div style="float: left">'; ?>

                                    <input type="radio" style="float: none;"
					onclick="Toggle('shows')" name="googleana_visible"
					id="googleana_visible"
					<?php if(isset($rs_editsettings[0]->googleana_visible) && $rs_editsettings[0]->googleana_visible == 1) { echo 'checked="checked" '; } ?>
					value="1" />Enable <input type="radio" style="float: none;"
					onclick="Toggle('unshow')" name="googleana_visible"
					id="googleana_visible"
					<?php if(isset($rs_editsettings[0]->googleana_visible) && $rs_editsettings[0]->googleana_visible == 0) { echo 'checked="checked" '; } ?>
					value="0" />Disable
                                    <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) echo '</div>'; ?>
                                    
                                <div id="show" style="display: none; float: right;width: 62%;">
                                    <table style="padding: 0; width: 100%;">
                                        <tr>
					<td style="padding: 0; width: 35%;">
                                            <?php echo JHTML::tooltip('Enter Google Analytics ID', 'Google Analytics ID', '', 'Google Analytics ID');?>
                                        </td>
                                        <td style="padding: 0;">
                                            <input style="margin: 0;" name="googleanalyticsID" id="googleanalyticsID" maxlength="100" value="<?php if(isset($rs_editsettings[0]->googleanalyticsID)) echo $rs_editsettings[0]->googleanalyticsID; ?>">
                                        </td>
                                        </tr>
                                    </table>
                                </div>
                                </td>
                        </tr>
                        <tr>
				<td class="key"><?php echo JHTML::tooltip('Option to select Ads type', 'Ads Type',
	            '', 'Ads Type');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; else ?> colspan="3" width="80%">
                                    <div style="float: left">
                                    <input type="radio" style="float: none;"
					onclick="Toggle1('showss')" name="IMAAds"
					id="IMAAds"
					<?php if(isset($rs_editsettings[0]->IMAAds) && $rs_editsettings[0]->IMAAds == 1) { echo 'checked="checked" '; } ?>
					value="1" />Intermediate Ad <input type="radio" style="float: none;"
					onclick="Toggle1('unshows')" name="IMAAds"
					id="IMAAds"
					<?php if(isset($rs_editsettings[0]->IMAAds) && $rs_editsettings[0]->IMAAds == 0) { echo 'checked="checked" '; } ?>
					value="0" />Pre-roll/Post-roll
                                    </div>
                                    <div id="imashow" style="display: none; float: right;width: 62%;">
                                        <table style="padding: 0; width: 100%;">
                                            <tr>
                                            <td style="padding: 0; width: 35%;">
                                                <?php echo JHTML::tooltip('Enter Intermediate Ads Path', 'Intermediate Ads Path', '', 'Intermediate Ads Path');?>
                                            </td>
                                            <td style="padding: 0;">
                                                <input style="margin: 0;" name="IMAAds_path" id="IMAAds_path" maxlength="100" value="<?php if(isset($rs_editsettings[0]->IMAAds_path)) echo $rs_editsettings[0]->IMAAds_path; ?>">
                                            </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
			</tr>
                        <tr>
                                                        <td class="key" style="" colspan="4">
<span style="
    float: left;
    font-style: italic;
">(If you enabled Intermediate Ad, then Pre-roll and Post-roll ads will not be played in the player.)</span>
                                    </td>
			</tr>
                        <?php } else { ?>
   <td class="key" width="20%"><?php echo JHTML::tooltip('Option to enable/disable Google Analytics', 'Google Analytics',
	            '', 'Google Analytics');?></td>
				<td class="radio_algin" width="80%"><input type="radio" style="float: none;"
					onclick="Toggle('shows')" name="googleana_visible"
					id="googleana_visible"
					<?php if(isset($rs_editsettings[0]->googleana_visible) && $rs_editsettings[0]->googleana_visible == 1) { echo 'checked="checked" '; } ?>
					value="1" />Enable <input type="radio" style="float: none;"
					onclick="Toggle('unshow')" name="googleana_visible"
					id="googleana_visible"
					<?php if(isset($rs_editsettings[0]->googleana_visible) && $rs_editsettings[0]->googleana_visible == 0) { echo 'checked="checked" '; } ?>
					value="0" />Disable</td>
			</tr>
			<tr>
				<td class="key">
					<div id="show" style="display: none;"><?php echo JHTML::tooltip('Enter Google Analytics ID', 'Google Analytics ID',
	            '', 'Google Analytics ID');?></div>
				</td>
				<td>
					<div id="show1" style="display: none;">
						<input name="googleanalyticsID" id="googleanalyticsID"
							maxlength="100"
							value="<?php if(isset($rs_editsettings[0]->googleanalyticsID)) echo $rs_editsettings[0]->googleanalyticsID; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td class="key" width="20%"><?php echo JHTML::tooltip('Option to select Ad type', 'Ad Type',
	            '', 'Ad Type');?></td>
				<td class="radio_algin" width="80%"><input type="radio" style="float: none;"
					onclick="Toggle1('showss')" name="IMAAds"
					id="IMAAds"
					<?php if(isset($rs_editsettings[0]->IMAAds) && $rs_editsettings[0]->IMAAds == 1) { echo 'checked="checked" '; } ?>
					value="1" />Intermediate Ad <input type="radio" style="float: none;"
					onclick="Toggle1('unshows')" name="IMAAds"
					id="IMAAds"
					<?php if(isset($rs_editsettings[0]->IMAAds) && $rs_editsettings[0]->IMAAds == 0) { echo 'checked="checked" '; } ?>
					value="0" />Pre-roll/Post-roll</td>
			</tr>
                        <tr> <td colspan="2"><span style="
    float: left;
    font-style: italic;
">(If you enabled Intermediate Ad, then Pre-roll and Post-roll ads will not be played in the player.)</span></td></tr>
			<tr>
				<td class="key">
					<div id="imashow" style="display: none;"><?php echo JHTML::tooltip('Enter Intermediate Ads Path', 'Intermediate Ads Path', '', 'Intermediate Ads Path');?></div>
				</td>
				<td>
					<div id="imashow1" style="display: none;">
						<input name="IMAAds_path" id="IMAAds_path"
							maxlength="100"
							value="<?php if(isset($rs_editsettings[0]->IMAAds_path)) echo $rs_editsettings[0]->IMAAds_path; ?>">
					</div>
				</td>
			</tr>
                        <?php } ?>
		</table>
	</fieldset>
	</div>
	<!-- Pre/Post-Roll Ads Settings Fields End -->

	<!-- Mid Roll Ads Settings Fields Start Here -->
	<div style="position: relative;">
	<fieldset class="adminform">
             <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
		<legend>Mid Roll Ad Settings</legend>
                <?php } else { ?>
                <h2>Mid Roll Ad Settings</h2>
                <?php } ?>
		<table class="<?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'adminlist table table-striped'; else echo 'admintable adminlist'; ?> " width="80%">
			<tr>
                            <td class="key"  <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>width="15%" <?php } ?>><?php echo JHTML::tooltip('Option to enable/disable Mid-roll ads', 'Mid-roll Ad',
	            '', 'Mid-roll Ad');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; else ?>width="20%"><input type="radio" name="midrollads"
				<?php
				if(isset($rs_editsettings[0]->midrollads) && $rs_editsettings[0]->midrollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midrollads"
					<?php
					if(isset($rs_editsettings[0]->midrollads) && $rs_editsettings[0]->midrollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
				<td class="key"  <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>width="20%" <?php } ?>><?php echo JHTML::tooltip('Enter begin time for mid roll ad', 'Begin',
	            '', 'Begin');?></td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) ?> width="15%"><input type="text" name="midbegin"
					value="<?php if(isset($rs_editsettings[0]->midbegin)) echo $rs_editsettings[0]->midbegin; ?>" />
				</td>


				<td class="key"  <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?> width="20%" <?php } ?>><?php echo JHTML::tooltip('Option to enable/disable rotation of ads', 'Ad Rotate',
	            '', 'Ad Rotate');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; else ?> width="15%"><input type="radio" name="midadrotate"
				<?php
				if(isset($rs_editsettings[0]->midadrotate) && $rs_editsettings[0]->midadrotate == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midadrotate"
					<?php
					if(isset($rs_editsettings[0]->midadrotate) && $rs_editsettings[0]->midadrotate == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
			</tr>
			<tr>

				<td class="key"  <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>width="15%" <?php } ?>><?php echo JHTML::tooltip('Option to enable/disable random display of ads', 'Mid-roll Ads Random',
	            '', 'Mid-roll Ads Random');?></td>
				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; else ?> width="20%"><input type="radio" name="midrandom"
				<?php
				if(isset($rs_editsettings[0]->midrandom) && $rs_editsettings[0]->midrandom == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midrandom"
					<?php
				if(isset($rs_editsettings[0]->midrandom) && $rs_editsettings[0]->midrandom == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
				<td class="key" <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?> width="20%" <?php } ?>><?php echo JHTML::tooltip('Enter the time interval between ads', 'Ad Interval',
	            '', 'Ad Interval');?></td>
				<td <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?> width="15%"<?php } ?>><input type="text" name="midinterval"
					value="<?php if(isset($rs_editsettings[0]->midinterval)) echo $rs_editsettings[0]->midinterval; ?>" />
				</td>
                                                      <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <?php } else { ?>
                                          <td class="key" width="20%"></td>
				<td width="15%"></td>
                                <?php } ?>
			</tr>
			<tr>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Mid Roll Ads Settings Fields End -->

	<!-- Logo Settings Fields Start Here -->
	<div style="position: relative;">
	<fieldset class="adminform">
		<legend>Logo Settings</legend>
		<table class="<?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'adminlist table table-striped'; else echo 'admintable adminlist'; ?> ">
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Enter Licence Key', 'Licence Key',
	            '', 'Licence Key');?></td>
				<td><input type="text" name="licensekey" id="licensekey" style="float: left;" size="60" maxlength="200" value="<?php if(isset($rs_editsettings[0]->licensekey)) echo $rs_editsettings[0]->licensekey; ?>" />
                                <?php
				if(isset($rs_editsettings[0]->licensekey) && $rs_editsettings[0]->licensekey == '') {
					?> <a style="float: left;"
					href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share"
					target="_blank"><img alt=""
						src="components/com_contushdvideoshare/images/buynow.gif"
						width="77" height="23" style="margin: 3px 0 0 0;" /> </a> <?php
				}
				?>
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Allowed Extensions : jpg/jpeg, gif, png', 'Logo',
	            '', 'Logo');?></td>
				<td>
					<div id="var_logo">
						<input name="logopath" id="logopath" maxlength="100"
							readonly="readonly"
							value="<?php if(isset($rs_editsettings[0]->logopath)) echo $rs_editsettings[0]->logopath; ?>"> <input
							type="button" name="change1" value="Change" maxlength="100"
							onclick="getFileUpload()">
					</div>
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) ?><td>&nbsp;</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Enter Logo Target URL', 'Logo Target URL',
	            '', 'Logo Target URL');?></td>
				<td><input style="width: 150px;" type="text" name="logourl"
					value="<?php if(isset($rs_editsettings[0]->logourl)) echo $rs_editsettings[0]->logourl; ?>" />
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) ?><td>&nbsp;</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Select the Logo Position.Disabled in Demo Version.', 'Logo Position',
	            '', 'Logo Position');?></td>
				<td><select name="logoalign">
						<option value="TR" id="TR">Top Right</option>
						<option value="TL" id="TL">Top Left</option>
						<option value="BL" id="BL">Bottom Left</option>
						<option value="BR" id="BR">Bottom Right</option>
				</select> <?php
				if(isset($rs_editsettings[0]->logoalign) && $rs_editsettings[0]->logoalign) {
					echo '<script>document.getElementById("' . $rs_editsettings[0]->logoalign . '").selected="selected"</script>';
				}
				?>
				</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) ?><td>&nbsp;</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to hide youtube logo', 'Hide Youtube Logo',
	            '', 'Hide Youtube Logo');?></td>

				<td <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"';?> ><input type="radio" name="scaletologo" id="scaletologo1"
				<?php if(isset($rs_editsettings[0]->scaletologo) && $rs_editsettings[0]->scaletologo == '1') {
					echo 'checked="checked" ';
				} ?>
					checked="checked" value="1" />True <input type="radio"
					name="scaletologo" id="scaletologo2"
					<?php if(isset($rs_editsettings[0]->scaletologo) && $rs_editsettings[0]->scaletologo == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />False</td>
                                <?php if(version_compare(JVERSION, '3.0.0', 'ge')) ?><td>&nbsp;</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Logo Settings Fields End -->

	<input type="hidden" name="id"
		value="<?php if(isset($rs_editsettings[0]->id)) echo $rs_editsettings[0]->id; ?>" /> <input type="hidden"
		name="task" value="" /> <input type="hidden" name="submitted"
		value="true" id="submitted">
</form>
<!-- script for get file upload-->
<script language="javascript">
function getFileUpload(){
var var_logo;
var_logo='<input type="file" name="logopath" id="logopath" maxlength="100"  value="" />';
document.getElementById('var_logo').innerHTML=var_logo;
}

var googleAnalyticsId = '';
googleAnalyticsId = "<?php if(isset($rs_editsettings[0]->googleanalyticsID)) echo $rs_editsettings[0]->googleanalyticsID; ?>";
if(googleAnalyticsId){
document.getElementById("show").style.display = '';
}

var IMAAds_path = '';
IMAAds_path = "<?php if(isset($rs_editsettings[0]->IMAAds_path)) echo $rs_editsettings[0]->IMAAds_path; ?>";
var IMAAds = "<?php if(isset($rs_editsettings[0]->IMAAds)) echo $rs_editsettings[0]->IMAAds; ?>";
if(IMAAds_path && IMAAds==1){
document.getElementById("imashow").style.display = '';
}
if(IMAAds==0){
    document.getElementById("imashow").style.display = 'none';

}
</script>

<!-- Form For Edit Player Settings End -->