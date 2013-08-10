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
 * @abstract      : Contushdvideoshare Component Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
defined('_JEXEC') or die('Restricted access');
$rs_editsettings = $rs_showsettings = $this->playersettings;
JHTML::_('behavior.tooltip');
?>
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
	padding: 0 10px 0 0;
}

fieldset label,fieldset span.faux-label {
	float: none;
	clear: left;
	display: block;
	margin: 5px 0;
}
</style>
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
		<legend>Player Settings</legend>
		<table class="admintable">
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Recommended value is 3', 'Buffer Time', 
	            '', 'Buffer Time');?></td>
				<td><input type="text" name="buffer"
					value="<?php echo $rs_editsettings[0]->buffer; ?>" /> secs
				</td>
				<td class="key" width=20%><?php echo JHTML::tooltip('Edit the value	to have transparency depth of logo', 'Logo Alpha', 
	            '', 'Logo Alpha');?></td>
				<td><input type="text" name="logoalpha"
					value="<?php echo $rs_editsettings[0]->logoalpha; ?>" /> %
				</td>
			</tr>
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Width of the
						video can be 300px with all the controls enabled. If you would
						like to have smaller than 300px then you have to disable couple of
						controls like Timer, Zoom.', 'Width', 
	            '', 'Width');?></td>
				<td width=400px;><input type="text" id="player_width" name="width"
					value="<?php echo $rs_editsettings[0]->width; ?>" /> px
				</td>
				<td class="key"><?php echo JHTML::tooltip('Select Enable to auto hide skin', 'Skin Auto Hide', 
	            '', 'Skin Auto Hide');?></td>
				<td><input type="radio" name="skin_autohide"
				<?php if ($rs_editsettings[0]->skin_autohide == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="skin_autohide"
					<?php if ($rs_editsettings[0]->skin_autohide == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key" width=20%><?php echo JHTML::tooltip('Recommended value is 400', 'Height', 
	            '', 'Height');?></td>
				<td><input type="text" name="height"
					value="<?php echo $rs_editsettings[0]->height; ?>"
					id="player_height" /> px</td>
				<td class="key"><?php echo JHTML::tooltip('Set the background color for the player in the format ffffff', 'Stage Color', 
	            '', 'Stage Color');?></td>
				<td>#<input type="text" name="stagecolor"
					value="<?php echo $rs_editsettings[0]->stagecolor; ?>" />
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
				if ($rs_editsettings[0]->normalscale) {

					echo '<script>document.getElementById("2' . $rs_editsettings[0]->normalscale . '").selected="selected"</script>';
				}
				?>
				</td>
				<td class="key"><?php echo JHTML::tooltip('Select Skin for the player', 'Skin', 
	            '', 'Skin');?></td>
				<td><select name="skin">

						<option value="skin_neat_fresh_yellow.swf"
							id="skin_neat_fresh_orange.swf">Skin neat fresh yellow</option>
						<option value="skin_fresh_blue.swf" id="skin_fresh_blue.swf">Skin fresh blue</option>
						<option value="skin_fresh_white.swf" id="skin_fresh_white.swf">Skin fresh white</option>
						<option value="skin_fresh_yellow.swf" id="skin_fresh_orange.swf">Skin fresh yellow</option>
				</select> <?php
				if ($rs_editsettings[0]->skin) {
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
				if ($rs_editsettings[0]->fullscreenscale) {
					echo '<script>document.getElementById("1' . $rs_editsettings[0]->fullscreenscale . '").selected="selected"

                                                                                                                                                                                                                                                                                        </script>';
				}
				?>
				</td>
				<td class="key"><?php echo JHTML::tooltip('Fullscreen button can be enable/disabled from here', 'Full Screen', 
	            '', 'Full Screen');?></td>
				<td><input type="radio" name="fullscreen"
				<?php if ($rs_editsettings[0]->fullscreen == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="fullscreen"
					<?php if ($rs_editsettings[0]->fullscreen == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to play the videos one by one continuously without clicking on next video', 'Autoplay', 
	            '', 'Autoplay');?></td>
				<td><input type="radio" name="autoplay"
				<?php if ($rs_editsettings[0]->autoplay == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="autoplay"
					<?php if ($rs_editsettings[0]->autoplay == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Zoom button on the player control can be disable / enable here', 'Zoom', 
	            '', 'Zoom');?></td>
				<td><input type="radio" name="zoom"
				<?php if ($rs_editsettings[0]->zoom == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="zoom"
					<?php if ($rs_editsettings[0]->zoom == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>

			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Recommended value is 50', 'Volume', 
	            '', 'Volume');?></td>
				<td><input type="text" name="volume"
					value="<?php echo $rs_editsettings[0]->volume; ?>" /> %
				</td>

			</tr>


			<tr>
				<td class="key"><?php echo JHTML::tooltip('Enter FFMpeg Binary Path', 'FFMpeg Binary Path', 
	            '', 'FFMpeg Binary Path');?></td>
				<td><input style="width: 150px;" type="text" name="ffmpegpath"
					value="<?php echo $rs_editsettings[0]->ffmpegpath; ?>" />
				</td>
				<td class="key"><?php echo JHTML::tooltip('Option to set enable / disable timer control on player', 'Timer', 
	            '', 'Timer');?></td>
				<td><input type="radio" name="timer"
				<?php if ($rs_editsettings[0]->timer == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="timer"
					<?php if ($rs_editsettings[0]->timer == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
			</tr>

			<tr>

				<td class="key"><?php echo JHTML::tooltip('Share button on the player can be enabled/disabled from here', 'Share URL', 
	            '', 'Share URL');?></td>
				<td><input type="radio" name="shareurl"
				<?php if ($rs_editsettings[0]->shareurl == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="shareurl"
					<?php if ($rs_editsettings[0]->shareurl == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Option to play all the videos from playlist continuously', 'Playlist Autoplay', 
	            '', 'Playlist Autoplay');?></td>
				<td><input type="radio" name="playlist_autoplay"
				<?php if ($rs_editsettings[0]->playlist_autoplay == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="playlist_autoplay"
					<?php if ($rs_editsettings[0]->playlist_autoplay == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
			</tr>

			<tr>

				<td class="key"><?php echo JHTML::tooltip('Option to set the HD videos to play by default', 'HD Default', 
	            '', 'HD Default');?></td>
				<td><input type="radio" name="hddefault"
				<?php if ($rs_editsettings[0]->hddefault == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="hddefault"
					<?php if ($rs_editsettings[0]->hddefault == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Set playlist to open / close always by enable / disable this option', 'Playlist Open', 
	            '', 'Playlist Open');?></td>
				<td><input type="radio" name="playlist_open"
				<?php if ($rs_editsettings[0]->playlist_open == 1) {
					echo 'checked="checked" ';
				} ?>
					value="1" />Enable <input type="radio" name="playlist_open"
					<?php if ($rs_editsettings[0]->playlist_open == 0) {
						echo 'checked="checked" ';
					} ?>
					value="0" />Disable</td>
			</tr>
			<tr>

				<td class="key"><?php echo JHTML::tooltip('Option to set enable/disable related videos display within player', 'Related Videos', 
	            '', 'Related Videos');?></td>
				<td><select name="related_videos">
						<option value="1" id="1">Enable</option>
						<option value="2" id="2">Disable</option>
						<!--                        <option value="3" id="3">Within Player</option>
                        <option value="4" id="4">Outside Player</option>-->
				</select> <?php
				if ($rs_editsettings[0]->related_videos) {
					echo '<script>document.getElementById("' . $rs_editsettings[0]->related_videos . '").selected="selected"</script>';
				}
				?>
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Player Settings Fields End -->

	<!-- Pre/Post-Roll Ads Settings Fields Start Here -->
	<div style="position: relative;">
	<fieldset class="adminform">
		<legend>Pre/Post-Roll Ad Settings</legend>
		<table class="admintable" width="23%">
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable post-roll ads', 'Post-roll Ad', 
	            '', 'Post-roll Ad');?></td>
				<td><input type="radio" name="postrollads"
				<?php
				if ($rs_editsettings[0]->postrollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="postrollads"
					<?php
					if ($rs_editsettings[0]->postrollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
					</tr>
					<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable pre-roll ads', 'Pre-roll Ad', 
	            '', 'Pre-roll Ad');?></td>
				<td><input type="radio" name="prerollads"
				<?php
				if ($rs_editsettings[0]->prerollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="prerollads"
					<?php
					if ($rs_editsettings[0]->prerollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable Google Analytics', 'Google Analytics', 
	            '', 'Google Analytics');?></td>
				<td><input type="radio" style="float: none;"
					onclick="Toggle('shows')" name="googleana_visible"
					id="googleana_visible"
					<?php if ($rs_editsettings[0]->googleana_visible == 1) { echo 'checked="checked" '; } ?>
					value="1" />Enable <input type="radio" style="float: none;"
					onclick="Toggle('unshow')" name="googleana_visible"
					id="googleana_visible"
					<?php if ($rs_editsettings[0]->googleana_visible == 0) { echo 'checked="checked" '; } ?>
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
							value="<?php echo $rs_editsettings[0]->googleanalyticsID; ?>">
					</div>
				</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Pre/Post-Roll Ads Settings Fields End -->

	<!-- Mid Roll Ads Settings Fields Start Here -->
	<div style="position: relative;">
	<fieldset class="adminform">
		<legend>Mid Roll Ad Settings</legend>
		<table class="admintable" width="80%">
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable Mid-roll ads', 'Mid-roll Ad', 
	            '', 'Mid-roll Ad');?></td>
				<td><input type="radio" name="midrollads"
				<?php
				if ($rs_editsettings[0]->midrollads == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midrollads"
					<?php
					if ($rs_editsettings[0]->midrollads == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Enter begin time for mid roll ad', 'Begin', 
	            '', 'Begin');?></td>
				<td><input type="text" name="midbegin"
					value="<?php echo $rs_editsettings[0]->midbegin; ?>" />
				</td>


				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable rotation of ads', 'Ad Rotate', 
	            '', 'Ad Rotate');?></td>
				<td><input type="radio" name="midadrotate"
				<?php
				if ($rs_editsettings[0]->midadrotate == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midadrotate"
					<?php
					if ($rs_editsettings[0]->midadrotate == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
			</tr>
			<tr>

				<td class="key"><?php echo JHTML::tooltip('Option to enable/disable random display of ads', 'Mid-roll Ads Random', 
	            '', 'Mid-roll Ads Random');?></td>
				<td><input type="radio" name="midrandom"
				<?php
				if ($rs_editsettings[0]->midrandom == 1) {
					echo 'checked="checked" ';
				}
				?>
					value="1" />Enable <input type="radio" name="midrandom"
					<?php
					if ($rs_editsettings[0]->midrandom == 0) {
						echo 'checked="checked" ';
					}
					?>
					value="0" />Disable</td>
				<td class="key"><?php echo JHTML::tooltip('Enter the time interval between ads', 'Ad Interval', 
	            '', 'Ad Interval');?></td>
				<td><input type="text" name="midinterval"
					value="<?php echo $rs_editsettings[0]->midinterval; ?>" />
				</td>
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
		<table class="admintable">
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Enter Licence Key', 'Licence Key', 
	            '', 'Licence Key');?></td>
				<td><input type="text" name="licensekey" id="licensekey" size="60"
					maxlength="200"
					value="<?php echo $rs_editsettings[0]->licensekey; ?>" /></td>
				<td><?php
				if ($rs_editsettings[0]->licensekey == '') {
					?> <a
					href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share"
					target="_blank"><img
						src="components/com_contushdvideoshare/images/buynow.gif"
						width="77" height="23" /> </a> <?php
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
							value="<?php echo $rs_editsettings[0]->logopath; ?>"> <input
							type="button" name="change1" value="Change" maxlength="100"
							onclick="getFileUpload()"> 
					</div>
				</td>

				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Enter Logo Target URL', 'Logo Target URL', 
	            '', 'Logo Target URL');?></td>
				<td><input style="width: 150px;" type="text" name="logourl"
					value="<?php echo $rs_editsettings[0]->logourl; ?>" />
				</td>
			</tr>
			<tr>
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
				if ($rs_editsettings[0]->logoalign) {
					echo '<script>document.getElementById("' . $rs_editsettings[0]->logoalign . '").selected="selected"</script>';
				}
				?> 
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JHTML::tooltip('Option to hide youtube logo', 'Hide Youtube Logo', 
	            '', 'Hide Youtube Logo');?></td>

				<td><input type="radio" name="scaletologo" id="scaletologo1"
				<?php if ($rs_editsettings[0]->scaletologo == '1') {
					echo 'checked="checked" ';
				} ?>
					checked="checked" value="1" />True <input type="radio"
					name="scaletologo" id="scaletologo2"
					<?php if ($rs_editsettings[0]->scaletologo == '0') {
						echo 'checked="checked" ';
					} ?>
					value="0" />False</td>
			</tr>
		</table>
	</fieldset>
	</div>
	<!-- Logo Settings Fields End -->

	<input type="hidden" name="id"
		value="<?php echo $rs_editsettings[0]->id; ?>" /> <input type="hidden"
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
googleAnalyticsId = "<?php echo $rs_editsettings[0]->googleanalyticsID; ?>";
if(googleAnalyticsId){
document.getElementById("show").style.display = '';
document.getElementById("show1").style.display = '';
}                   
</script>

<!-- Form For Edit Player Settings End -->