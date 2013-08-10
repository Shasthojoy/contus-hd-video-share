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
 * @abstract      : Contushdvideoshare Component Adminvideos View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
 // no direct access
defined('_JEXEC') or die('Restricted access');
$editVideo = $this->editvideo;
$editor = JFactory::getEditor();
$k = 0;
$usergroups = $editVideo['user_groups'];
$fileOption = $editVideo['rs_editupload']->filepath;
$streamerOpt = $editVideo['rs_editupload']->streameroption;
$user = JFactory::getUser();
$document = JFactory::getDocument();
$document->addScript( JURI::base().'components/com_contushdvideoshare/js/upload_script.js' );
JHTML::_('behavior.tooltip');
?>
<style>fieldset input, fieldset textarea, fieldset select, fieldset img, fieldset button {float:none;}
form {float:left;}
</style>
<script language="JavaScript" type="text/javascript">
 <?php if(version_compare(JVERSION,'1.6.0','ge'))
        { ?>
            Joomla.submitbutton = function(pressbutton){
        <?php }else  { ?>
    	function submitbutton(pressbutton) {
    	<?php  } ?>
        var form = document.adminForm;
        if (pressbutton == 'CANCEL7')
        {
            submitform( pressbutton );
            return;
        }
        if (pressbutton == 'addvideoupload')
        {
            submitform( pressbutton );
            return;
        }

        // do field validation
        if (pressbutton == "savevideos" || pressbutton=="applyvideos")
        {
            var bol_file1=(document.getElementById('filepath1').checked);
            var bol_file2=(document.getElementById('filepath2').checked);
            var bol_file3=(document.getElementById('filepath3').checked);
            var bol_file4=(document.getElementById('filepath4').checked);
            var streamer_name='';
            var islive = '';
            var stream_opt=document.getElementsByName('streameroption[]');
            var length_stream=stream_opt.length;
            for(i=0;i<length_stream;i++)
            {
                if(stream_opt[i].checked==true)
                {
                    document.getElementById('streameroption-value').value = stream_opt[i].value;
                    if(stream_opt[i].value=='rtmp')
                    {
                        streamer_name = document.getElementById('streamname').value;
                        var islivevalue2=(document.getElementById('islive2').checked);
                        if(streamer_name == ''){
                            alert( "<?php  echo JText::_( 'You must provide a streamer path!', true ); ?>" )
                            return false;
                         }
                        var tomatch= /rtmp:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|rtmp:\/\//
                        if (!tomatch.test(streamer_name))
                        {
                            alert( "<?php echo JText::_( 'Please enter a valid streamer path', true ); ?>" )
                            document.getElementById('streameroption-value').focus();
                            return false;
                        }
                        document.getElementById('streamerpath-value').value=streamer_name;
                        if(islivevalue2==true) {
                            document.getElementById('islive-value').value=1;
                        } else {
                            document.getElementById('islive-value').value=0;
                    }
                }
            }
            }
				/**
				* validation for video url
				* @ empty url
				* @ valid url
				*/
                if(bol_file2==true)
                {
                    if(document.getElementById('videourl').value=="")
                    {
                        alert( "<?php  echo JText::_( 'You must provide a Video URL', true ); ?>" )
                        return;
                    }
                    else
                     {
                        var theurl=document.getElementById("videourl").value;

                         var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|http:\/\//
                         if (!tomatch.test(theurl))
                         {
                             for(i=0;i<length_stream;i++)
                            {
                                if(stream_opt[i].checked==true)
                                {
                                    if(stream_opt[i].value!='rtmp')
                                    {
                                       alert( "<?php echo JText::_( 'Please Enter Valid URL', true ); ?>" )
                                       document.getElementById("videourl").focus();
                                       return false;
                                    }
                                }
                           }

                         }
                    }
                    document.getElementById('fileoption').value='Url';
                    if(document.getElementById('videourl').value!="")
                        document.getElementById('videourl-value').value=document.getElementById('videourl').value;
                    if(document.getElementById('thumburl').value!="") {
                        document.getElementById('thumburl-value').value=document.getElementById('thumburl').value;
                        thumbUrl = document.getElementById('thumburl').value;
	                    var thumburlregex = thumbUrl.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
						if (thumburlregex == null) {
							alert('Please Enter Valid Thumb URL');
							return;
						}
                    }
                    if(document.getElementById('previewurl').value!="") {
                        document.getElementById('previewurl-value').value=document.getElementById('previewurl').value;
	                    previewUrl = document.getElementById('previewurl').value;
	                    var previewurlregex = previewUrl.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
						if (previewurlregex == null) {
							alert('Please Enter Valid Preview URL');
							return;
						}
                    }
                    if(document.getElementById('hdurl').value!="") {
                        document.getElementById('hdurl-value').value=document.getElementById('hdurl').value;
	                    hdUrl = document.getElementById('hdurl').value;
	                    var hdurlregex = hdUrl.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
						if (hdurlregex == null) {
							alert('Please Enter Valid HD URL');
							return;
                }
                    }
                }

				/**
				* validation for Upload File
				* @ Upload a video
				*/

                if(bol_file1==true)
                {
                    document.getElementById('fileoption').value='File';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress',true);?>");
                        return;
                    }
                       if(document.getElementById('id').value=="")
                       {
                        if(document.getElementById('normalvideoform-value').value=="" && document.getElementById('hdvideoform-value').value=="")
                        {
                        alert("<?php echo JText::_('You must Upload a Video',true);?>");
                        return;
                        }
                        if(document.getElementById('thumbimageform-value').value=="")
                        {
                        alert("<?php echo JText::_('You must Upload a Thumb Image',true);?>");
                        return;
                        }
                        }
                }

				/**
				* validation for Video File
				* @ Upload a video file
				* @ Youtube and vimeo
				*/

                if(bol_file4==true)
                {
                    if(document.getElementById('videourl').value=="")
                    {
                        alert( "<?php echo JText::_( 'You must provide a Video URL', true ); ?>" )
                        return;
                    }
                    else
                     {
                        var theurl=document.getElementById("videourl").value;                         
                         if (theurl.contains("youtube.com") || theurl.contains("vimeo.com"))
                         {
                                   document.getElementById('fileoption').value='Youtube';
                                   if(document.getElementById('videourl').value!="")
                                   document.getElementById('videourl-value').value=document.getElementById('videourl').value;
                         }
                         else
                         {
                             alert( "<?php echo JText::_( 'Please Enter Valid youtube or vimeo url', true ); ?>" )
                             document.getElementById("videourl").focus();
                             return false;
                         }
                    }
                }

                if(bol_file3==true)
                {
                document.getElementById('fileoption').value='FFmpeg';
                    if(uploadqueue.length!="")
                    {
                        alert("<?php echo JText::_('Upload in Progress',true);?>");
                        return;
                    }

                    if(document.getElementById('ffmpegform-value').value=="")
                        {
                        alert("<?php echo JText::_('You must Upload a Video',true);?>");
                        return;
                        }
                }

				/**
				* validation for Video Title
				* @ Video Title
				*/

                if (document.getElementById('title').value == "")
                {
                    alert( "<?php echo JText::_( 'You must provide a Title', true ); ?>" )
                    return;
                }

				/**
				* validation for Video Category
				* @ Video Category
				*/

                if (document.getElementById('playlistid').value == 0)
                {
                    alert( "<?php echo JText::_( 'You must select a category', true ); ?>" )
                    return;
                }
                
            submitform( pressbutton );
            return;
        }
    }
</script>

<!-- video fields start -->
<div style="position: relative;">
<fieldset class="adminform">
    <legend>Video </legend>
    <table class="admintable">
<?php
    $streamerOptionNone = '';
    $streamerOptionLighthttpd = '';
    $streamerOptionRtmp = '';
    $filePath = '';
    $filePathUrl = '';
    $filePathYoutube = '';
    $filePathFfmpeg = '';
    $youtubefilepathchk = $isfilepathchk = $ffmpegchk = '';
    if($editVideo['rs_editupload']->streameroption == 'None' ||$editVideo['rs_editupload']->streameroption == '')
        {
          $streamerOptionNone = 'checked="checked" ';

        }
     if($editVideo['rs_editupload']->streameroption == 'lighttpd')
        {
          $streamerOptionLighthttpd = 'checked="checked" ';

        }
     if($editVideo['rs_editupload']->streameroption=="rtmp")
        {

         $streamerOptionRtmp = 'checked="checked" ';

        }
      if($editVideo['rs_editupload']->filepath == 'File' ||$editVideo['rs_editupload']->filepath == '')
       {
          $filePath = 'checked="checked" ';

       }
      if($editVideo['rs_editupload']->filepath == 'Url')
       {
       if ($editVideo['rs_editupload']->streameroption == "lighttpd" || $editVideo['rs_editupload']->streameroption == "rtmp" ) {
                $youtubefilepathchk = 'disabled';
                $isfilepathchk = 'disabled';
                $ffmpegchk = 'disabled';
         }
          $filePathUrl = 'checked="checked" ';

       }
     if($editVideo['rs_editupload']->filepath == 'Youtube')
       {
         $filePathYoutube = 'checked="checked" ';

       }
      if($editVideo['rs_editupload']->filepath == 'FFmpeg')
       {
          $filePathFfmpeg = 'checked="checked" ';

       }
?>
        <tr>
            <td><?php echo JHTML::tooltip('Select streamer option', 'Streamer Option',
	            '', 'Streamer Option');?></td>
            <td>

                <input type="radio" name="streameroption[]" id="streameroption1" <?php echo $streamerOptionNone; ?> value="None"  checked="checked" onclick="streamer1('None');" />None
                <input type="radio" name="streameroption[]" id="streameroption2" <?php echo $streamerOptionLighthttpd; ?>value="lighttpd"  onclick="streamer1('lighttpd');" />Lighttpd
                <input type="radio" name="streameroption[]" id="streameroption3" <?php echo $streamerOptionRtmp; ?> value="rtmp"  onclick="streamer1('rtmp');" />RTMP
            </td>
        </tr>

        <tr id="stream1" name="stream1"><td><?php echo JHTML::tooltip('Select Streamer Path', 'Streamer Path',
	            '', 'Streamer Path');?></td>
            <td>
                <input type="text" name="streamname"  id="streamname" style="width:300px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->streamerpath ;?>" />
            </td>
        </tr>
        <tr id="islive_visible" name="islive_visible">
            <td>Is Live</td>
            <td>
                <input type="radio" style="float:none;" name="islive[]"  id="islive2" <?php
                       if ($editVideo['rs_editupload']->islive == '1') {
                           echo 'checked="checked" ';
                       }
?>  value="1" />Yes
                <input type="radio" style="float:none;" name="islive[]"  id="islive1"  <?php
                       if ($editVideo['rs_editupload']->islive == '0' || $editVideo['rs_editupload']->islive == '') {
                           echo 'checked="checked" ';
                       }
?>  value="0" />No
                   </td>
        </tr>
        <tr><td width="200px;"><?php echo JHTML::tooltip('Select file path', 'File Option',
	            '', 'File Option');?></td>
            <td>
                <input type="radio" name="filepath" id="filepath1" <?php echo $filePath; ?> <?php echo $isfilepathchk;?> value="File" onclick="fileedit('File');" />File
                <input type="radio" name="filepath" id="filepath2"<?php echo $filePathUrl; ?> value="Url" onclick="fileedit('Url');"/>URL
                <input type="radio" name="filepath" id="filepath4"<?php echo $filePathYoutube; ?> <?php echo $youtubefilepathchk;?> value="Youtube" onclick="fileedit('Youtube');" />You Tube / Vimeo
                <input type="radio" name="filepath" id="filepath3"<?php echo $filePathFfmpeg; ?> <?php echo $ffmpegchk;?> value="FFmpeg" onclick="fileedit('FFmpeg');" />FFmpeg
        </td></tr>

        <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td><?php echo JHTML::tooltip('Select video to upload', 'Upload Video',
	            '', 'Upload Video');?></td>
            <td>
                <div id="f1-upload-form" >
                    <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label id="lbl_normal"><?php if($editVideo['rs_editupload']->filepath == 'File') echo $editVideo['rs_editupload']->videourl;?></label>

                        <input type="hidden" name="mode" value="video" />
                    </form>
                </div>
				<div id="f1-upload-progress" style="display: none">
				<table>
				<tr>
					<td>
						<img id="f1-upload-image" style="float: left;"
						src="components/com_contushdvideoshare/images/empty.gif"
						alt="Uploading" />
					</td>
					<td><span style="float: left; clear:none;font-weight: bold;" id="f1-upload-filename">&nbsp;</span></td>
					<td>
						<span id="f1-upload-message" style="float: left;">
						</span>
						<label id="f1-upload-status" style="float: left;"> &nbsp; </label>
					</td>
					<td>
					<span id="f1-upload-cancel">
					<a style="float: left;font-weight: bold" href="javascript:cancelUpload('normalvideoform');"
					   name="submitcancel">Cancel</a> </span>
					</td>
				</tr>
				</table>
				</div>
        </td></tr>
        <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new2"> <td><?php echo JHTML::tooltip('Select Hdvideo to upload', 'Upload HD Video',
	            '', 'Upload HD Video(optional)');?></td>
            <td>
                <div id="f2-upload-form" >
                    <form name="hdvideoform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload HD Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php if($editVideo['rs_editupload']->filepath == 'File') echo $editVideo['rs_editupload']->hdurl;?></label>
                        <input type="hidden" name="mode" value="video" />
                    </form>
                </div>
				<div id="f2-upload-progress" style="display: none">
				<table>
				<tr>
					<td>
						<img id="f2-upload-image" style="float: left;"
						src="components/com_contushdvideoshare/images/empty.gif"
						alt="Uploading" />
					</td>
					<td><span style="float: left; clear:none;font-weight: bold;" id="f2-upload-filename">&nbsp;</span></td>
					<td>
						<span id="f2-upload-message" style="float: left;">
						</span>
						<label id="f2-upload-status" style="float: left;"> &nbsp; </label>
					</td>
					<td>
					<span id="f2-upload-cancel">
					<a style="float: left;font-weight: bold" href="javascript:cancelUpload('hdvideoform');"
					   name="submitcancel">Cancel</a> </span>
					</td>
				</tr>
				</table>
				</div>
        </td></tr>
        <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new3"><td><?php echo JHTML::tooltip('Select thumb image to upload', 'Upload Thumb Image',
	            '', 'Upload Thumb Image');?></td><td>
                <div id="f3-upload-form" >
                    <form name="thumbimageform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile"  onchange="enableUpload(this.form.name);"/>
                        <input type="button" name="uploadBtn" value="Upload Thumb Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php if($editVideo['rs_editupload']->filepath == 'File') echo $editVideo['rs_editupload']->thumburl;?></label>
                        <input type="hidden" name="mode" value="image" />
                    </form>
                </div>
				<div id="f3-upload-progress" style="display: none">
				<table>
				<tr>
					<td>
						<img id="f3-upload-image" style="float: left;"
						src="components/com_contushdvideoshare/images/empty.gif"
						alt="Uploading" />
					</td>
					<td><span style="float: left; clear:none;font-weight: bold;" id="f3-upload-filename">&nbsp;</span></td>
					<td>
						<span id="f3-upload-message" style="float: left;">
						</span>
						<label id="f3-upload-status" style="float: left;"> &nbsp; </label>
					</td>
					<td>
					<span id="f3-upload-cancel">
					<a style="float: left;font-weight: bold" href="javascript:cancelUpload('thumbimageform');"
					   name="submitcancel">Cancel</a> </span>
					</td>
				</tr>
				</table>
				</div>
        </td></tr>

        <tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new4"><td><?php echo JHTML::tooltip('Select preview image to upload', 'Upload Preview Image',
	            '', 'Upload Preview Image(optional)');?></td><td>
                <div id="f4-upload-form" >
                    <form name="previewimageform" method="post" enctype="multipart/form-data" >

                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Preview Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php if($editVideo['rs_editupload']->filepath == 'File') echo $editVideo['rs_editupload']->previewurl;?></label>
                        <input type="hidden" name="mode" value="image" />
                    </form>
                </div>
				<div id="f4-upload-progress" style="display: none">
				<table>
				<tr>
					<td>
						<img id="f4-upload-image" style="float: left;"
						src="components/com_contushdvideoshare/images/empty.gif"
						alt="Uploading" />
					</td>
					<td><span style="float: left; clear:none;font-weight: bold;" id="f4-upload-filename">&nbsp;</span></td>
					<td>
						<span id="f4-upload-message" style="float: left;">
						</span>
						<label id="f4-upload-status" style="float: left;"> &nbsp; </label>
					</td>
					<td>
					<span id="f4-upload-cancel">
					<a style="float: left;font-weight: bold" href="javascript:cancelUpload('previewimageform');"
					   name="submitcancel">Cancel</a> </span>
					</td>
				</tr>
				</table>
				</div>
                <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
        </td>
        </tr>
        <tr id="ffmpeg_disable_new5" name="ffmpeg_disable_edit5" style="width:200px;">
            <td><?php echo JHTML::tooltip('Enter Youtube/Vimeo/Video URL', 'Video URL','', 'Video URL');?></td>
            <td><input type="text" name="videourl"  id="videourl" size="100" maxlength="250" value="<?php  if($editVideo['rs_editupload']->filepath == 'Url' || $editVideo['rs_editupload']->filepath == 'Youtube') echo $editVideo['rs_editupload']->videourl;?>"/>
            </td>
        </tr>
        <tr id="ffmpeg_disable_new8" name="ffmpeg_disable_edit8"><td><?php echo JHTML::tooltip('Enter HD Video URL (Eg:http://www.yourdomain.com/video.flv)', 'HD URL','', 'HD URL');?></td>
            <td><input type="text" name="hdurl"  id="hdurl" size="100" maxlength="250" value="<?php  if($editVideo['rs_editupload']->filepath == 'Url') echo $editVideo['rs_editupload']->hdurl;?>"/>
        </td></tr>
        <tr id="ffmpeg_disable_new6" name="ffmpeg_disable_edit6"><td><?php echo JHTML::tooltip('Enter Video Thumb URL (Eg:http://www.yourdomain.com/images)', 'Thumb URL','', 'Thumb URL');?></td>
            <td><input type="text" name="thumburl"  id="thumburl" size="100" maxlength="250" value="<?php  if($editVideo['rs_editupload']->filepath == 'Url') echo $editVideo['rs_editupload']->thumburl;?>"/>
        </td></tr>
        <tr id="ffmpeg_disable_new7" name="ffmpeg_disable_edit7"><td><?php echo JHTML::tooltip('Enter Video Preview URL (Eg:http://www.yourdomain.com/images)', 'Preview URL','', 'Preview URL');?></td>
            <td><input type="text" name="previewurl"  id="previewurl" size="100" maxlength="250" value="<?php  if($editVideo['rs_editupload']->filepath == 'Url') echo $editVideo['rs_editupload']->previewurl;?>"/>
        </td></tr>
        <tr id="fvideos" name="fvideos"> <td><?php echo JHTML::tooltip('Select video to upload', 'Upload Video',
	            '', 'Upload Video');?></td>
            <td>
                <div id="f5-upload-form" >
                    <form name="ffmpegform" method="post" enctype="multipart/form-data" >
                        <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                        <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                        <label><?php if($editVideo['rs_editupload']->filepath == 'FFmpeg') echo $editVideo['rs_editupload']->videourl;?></label>
                        <input type="hidden" name="mode" value="video_ffmpeg" />
                    </form>
                </div>
				<div id="f5-upload-progress" style="display: none">
				<table>
				<tr>
					<td>
						<img id="f5-upload-image" style="float: left;"
						src="components/com_contushdvideoshare/images/empty.gif"
						alt="Uploading" />
					</td>
					<td><span style="float: left; clear:none;font-weight: bold;" id="f5-upload-filename">&nbsp;</span></td>
					<td>
						<span id="f5-upload-message" style="float: left;">
						</span>
						<label id="f5-upload-status" style="float: left;"> &nbsp; </label>
					</td>
					<td>
					<span id="f5-upload-cancel">
					<a style="float: left;font-weight: bold" href="javascript:cancelUpload('ffmpegform');"
					   name="submitcancel">Cancel</a> </span>
					</td>
				</tr>
				</table>
				</div>
        </td></tr>
    </table>
</fieldset>
</div>
<!-- video fields end -->

<!-- video info form start -->
<form action='index.php?option=com_contushdvideoshare&layout=adminvideos<?php echo (JRequest::getVar('user','','get') == 'admin') ? "&user=".JRequest::getVar('user','','get') : ''; ?>' method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="float: none;position: relative;">
    <fieldset class="adminform">
        <legend>Video Info</legend>
        <table  class="admintable" width="100%">

            <tr><td width="17%"><?php echo JHTML::tooltip('Enter title for the video', 'Title',
	            '', 'Title');?></td><td width="83%"><input type="text" name="title"  id="title" style="width:300px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->title; ?>" /></td></tr>
            <tr><td><?php echo JHTML::tooltip('Enter description for the video', 'Description',
	            '', 'Description');?></td><td>
            <?php
            $editor = JFactory::getEditor();
            $imageDesc = "";
            if (isset($editVideo['rs_editupload']->description))
            $imageDesc = $editVideo['rs_editupload']->description;            
            echo $editor->display('description', $imageDesc, '350', '200', '60', '20', false);
		?>
	            </td></tr>
            <tr><td><?php echo JHTML::tooltip('Enter tags for the video', 'Tags',
	            '', 'Tags');?></td><td><input type="text" name="tags"  id="tags" style="width:300px;float:left;" maxlength="250" value="<?php echo $editVideo['rs_editupload']->tags; ?>" /><label>Separate tags by space</label></td></tr>
            <tr id="target"><td><?php echo JHTML::tooltip('Enter target url for the video (Not supported for vimeo)', 'Target URL',
	            '', 'Target URL');?></td><td><input type="text" name="targeturl"  id="targeturl" style="width:300px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->targeturl; ?>" /></td></tr>
                <script language="JavaScript">
                var user = new Array(<?php echo count($editVideo['rs_play']);?>);
<?php
for ($i=0; $i<count($editVideo['rs_play']); $i++)
{
    $playlistnames=$editVideo['rs_play'][$i];
    ?>
        user[<?php echo $i;?>]= new Array(2);
        user[<?php echo $i;?>][1]= "<?php echo $playlistnames->id; ?>";
        user[<?php echo $i;?>][0]= "<?php echo $playlistnames->category; ?>";
    <?php
}
?>
            </script>
            <!-- <tr><td><?php echo JHTML::tooltip('Select option to display category', 'Display Category',
	            '', 'Display Category');?></td>
                <td>
                    <input type="radio" name="displayplaylist"  id="displayplaylist1"  <?php echo 'checked="checked" ';?> value="1" />All&nbsp;&nbsp;
                    <input type="radio" name="displayplaylist"  id="displayplaylist2" value="2"  onchange="select_alphabet('2')" />Most Recently Added(Up to 25 Playlist Names)
                </td>
            </tr>-->
            <tr><td><?php echo JHTML::tooltip('Select option to filter categories', 'Filter by Category',
	            '', 'Filter by Category');?></td>
            <td>
            <input type="radio" name="playliststart" id='playliststart0' value="0z"  <?php echo 'checked'; ?> onchange="select_alphabet('0z')" />All&nbsp;&nbsp;
            <input type="radio" name="playliststart" id="playliststart1" value="AF"  onchange="select_alphabet('AF')" />A-F&nbsp;&nbsp;
            <input type="radio" name="playliststart" id='playliststart2' value="GL"  onchange="select_alphabet('GL')" />G-L&nbsp;&nbsp;
            <input type="radio" name="playliststart" id='playliststart3' value="MR"  onchange="select_alphabet('MR')" />M-R&nbsp;&nbsp;
            <input type="radio" name="playliststart" id='playliststart4' value="SV"  onchange="select_alphabet('SV')" />S-V&nbsp;&nbsp;
            <input type="radio" name="playliststart" id='playliststart5' value="WZ"  onchange="select_alphabet('WZ')" />W-Z&nbsp;&nbsp;
            <input type="radio" name="playliststart" id='playliststart6' value="09"  onchange="select_alphabet('09')" />0-9&nbsp;&nbsp;
			</td>
			</tr>
            <tr><td><?php echo JHTML::tooltip('Select category for the video', 'Category',
	            '', 'Category');?></td><td>
                    <select name="playlistid" id="playlistid" >
                        <option value="0" id="0">Uncategorised</option>
                        <?php
                        $count=count( $editVideo['rs_play'] );
                        if ($count>=1)
                        {
                            for ($i=0; $i < $count; $i++)
                            {
                                $row_play = &$editVideo['rs_play'][$i];
                                ?>
                                <option value="<?php echo $row_play->id ;?>" id="<?php echo $row_play->id ;?>"><?php echo $row_play->category?></option>
                        <?php
                           }
                        }

                ?>
                    </select>
                    <?php
                    if($editVideo['rs_editupload']->playlistid)
                    {

                        echo '<script>document.getElementById("'.$editVideo['rs_editupload']->playlistid.'").selected="selected"</script>';
                    }
                        $selected = '';
                    ?>
            </td></tr>
            <tr>
                <td><?php echo JHTML::tooltip('Enter order for the video', 'Order',
	            '', 'Order');?></td>
                <td><input type="text" name="ordering"  id="ordering" style="width:50px" maxlength="250" value="<?php echo $editVideo['rs_editupload']->ordering ;?>"/></td>
            </tr>
             <tr>
                <td><?php echo JHTML::tooltip('Select user access level (Not supported for vimeo)', 'User Acess Level',
	            '', 'User Acess Level');?></td>
                <td>
                    <select name="useraccess"  >
                     <?php for($i=0;$i<count($usergroups);$i++)
                     { $selected = '';
                         if($editVideo['rs_editupload']->useraccess)
                         {
                             if($editVideo['rs_editupload']->useraccess == $usergroups[$i]->id)
                            {
                             $selected ='selected="selected"';
                            }
                         }
                       echo '<option value='.$usergroups[$i]->id.' '.$selected.' >'.$usergroups[$i]->title.'</option>';
                     }
                     ?>
                    </select>
                </td>
            </tr>
            <tr id="postroll-ad"><td><?php echo JHTML::tooltip('Post-roll ads (Not supported for vimeo)', 'Post-roll Ad',
	            '', 'Post-roll Ad');?></td>
                <?php
                $postRollEnable = '';
                $postRollDisable = '';
                if($editVideo['rs_editupload']->postrollads == '1')
                  {
                    $postRollEnable = "inside ".'checked="checked" ';
                  }
                  if($editVideo['rs_editupload']->postrollads == '0' || $editVideo['rs_editupload']->postrollads == '')
                  {
                      $postRollDisable = 'checked="checked" ';
                 }
                ?>
                <td>
                    <input type="radio" name="postrollads"  id="postrollads"  <?php echo $postRollEnable;?> value="1"  onclick="postroll('1');"/>Enable
                    <input type="radio" name="postrollads"  id="postrollads" <?php echo $postRollDisable; ?> value="0" onclick="postroll('0');"/>Disable
            </td></tr>
             <tr id="postroll"><td class="key"><?php echo JHTML::tooltip('Post-roll Name (Not supported for vimeo)', 'Post-roll Name',
	            '', 'Post-roll Name');?></td><td>
                    <select name="postrollid" id="postrollid" >

                        <?php

                        $count=count( $editVideo['rs_ads'] );

                        if ($count>=1)
                        {
                            for ($i=0; $i < $count; $i++)
                            {
                                $row_Ads = &$editVideo['rs_ads'][$i];
                                ?>
                        <option value="<?php echo $row_Ads->id ;?>" id="5<?php echo $row_Ads->id ;?>" name="<?php echo $row_Ads->id ;?>" ><?php echo $row_Ads->adsname ;?></option>
                        <?php
                           }
                      }
                ?>
                    </select>
                    <?php
                    $prerolladsEnable = '';
                    $prerolladsDisable = '';
                    if($editVideo['rs_editupload']->postrollid)
                    {

                        echo '<script>document.getElementById("5'.$editVideo['rs_editupload']->postrollid.'").selected="selected"</script>';
                    }
                    if($editVideo['rs_editupload']->prerollads == '1')
                     {
                        $prerolladsEnable = 'checked="checked" ';

                     }
                    if($editVideo['rs_editupload']->prerollads == '0' || $editVideo['rs_editupload']->prerollads == '')
                     {
                        $prerolladsDisable = 'checked="checked" ';
                     }

                    ?>
            </td></tr>
            <tr id="preroll-ad"><td><?php echo JHTML::tooltip('Pre-roll ads (Not supported for vimeo)', 'Pre-roll Ad',
	            '', 'Pre-roll Ad');?></td>
                <td>
                    <input type="radio" name="prerollads"  id="prerollads"  <?php echo $prerolladsEnable; ?>  value="1"  onclick="preroll('1');"/>Enable
                    <input type="radio" name="prerollads"  id="prerollads" <?php echo $prerolladsDisable; ?> value="0"  onclick="preroll('0');"/>Disable
            </td></tr>
            <tr id="preroll"><td class="key"><?php echo JHTML::tooltip('Pre-roll Name (Not supported for vimeo)', 'Pre-roll Name',
	            '', 'Pre-roll Name');?></td>
            <td>
                    <select name="prerollid" id="prerollid" >
                        <?php
                        $count = count( $editVideo['rs_ads'] );
                        if ($count >=1)
                        {
                            for ($v=0; $v < $count; $v++)
                            {
                                $row_Ads = &$editVideo['rs_ads'][$v];
                                ?>
                        <option value="<?php echo $row_Ads->id ;?>" id="6<?php echo $row_Ads->id ;?>" name="<?php echo $row_Ads->id ;?>"><?php echo $row_Ads->adsname ;?></option>
                        <?php
                            }
                       }

                ?>
                    </select>
                    <?php
                    $downloadEnable = '';
                    $downloadDisable = '';
                    $publishedYes = '';
                    $publishedNo = '';
                    if($editVideo['rs_editupload']->prerollid)
                    {
                        echo '<script>document.getElementById("6'.$editVideo['rs_editupload']->prerollid.'").selected="selected"</script>';
                    }
                    if($editVideo['rs_editupload']->download=='1' || $editVideo['rs_editupload']->download=='')
                     {
                        $downloadEnable = 'checked="checked" ';
                     }
                    if($editVideo['rs_editupload']->download=='0')
                      {
                        $downloadDisable = 'checked="checked" ';
                      }                    
                       $midrollenable = $midrolldisable = '';
                       if ($editVideo['rs_editupload']->midrollads == '1')
                       {
                       	   $midrollenable  = 'checked="checked"';
                       }
                       if ($editVideo['rs_editupload']->midrollads == '0' || $editVideo['rs_editupload']->midrollads == '')
                       {
                           $midrolldisable = 'checked="checked"';
                       }
                    ?>
            </td>
            </tr>
             <tr>
                        <td><?php echo JHTML::tooltip('Option to enable/disable mid-roll ads', 'Mid-roll Ad',
	            '', 'Mid-roll Ad');?></td>
                        <td>
                            <input type="radio" style="float:none;"  name="midrollads"  id="midrollads"  <?php echo $midrollenable; ?>  value="1"/>Enable
                            <input type="radio"  style="float:none;"  name="midrollads"  id="midrollads" <?php echo $midrolldisable; ?> value="0"  />Disable
                        </td>
             </tr>
            <tr id="download"><td><?php echo JHTML::tooltip('Download Video (Not supported for vimeo, youtube and streamer)', 'Download Video',
	            '', 'Download Video');?></td>
                <td>
                    <input type="radio" name="download"  id="download"  <?php echo $downloadEnable; ?>  value="1" />Enable
                    <input type="radio" name="download"  id="download" <?php echo $downloadDisable; ?>  value="0" />Disable
                </td>
            </tr>
            <?php
            $baseUrl = JURI::base()."components/com_contushdvideoshare/"; ?>
            <tr><td><?php echo JHTML::tooltip('Option to enable/disable video', 'Status',
	            '', 'Status');?></td>
                <td>
                <select name="published" id="published">					
					<option value="1" <?php if(isset($editVideo['rs_editupload']->published) && $editVideo['rs_editupload']->published == 1) echo 'selected';?>>Published</option>
					<option value="0" <?php if(isset($editVideo['rs_editupload']->published) && $editVideo['rs_editupload']->published == 0) echo 'selected';?>>Unpublished</option>
					<option value="-2" <?php if(isset($editVideo['rs_editupload']->published) && $editVideo['rs_editupload']->published == -2) echo 'selected';?>>Trashed</option>
				</select>	
                </td>
            </tr>
        </table>
    </fieldset>
    <?php
        $user = JFactory::getUser();
        $userid = $user->get('id');
         if (isset($editVideo['rs_editupload']->memberid))
            $videosid = $editVideo['rs_editupload']->memberid;
        else
            $videosid= $userid;
        if (isset($editVideo['rs_editupload']->memberid)){
            $videostype = $editVideo['rs_editupload']->usergroupid;
        }
        else {
            $videostype=$editVideo['user_group_id']->group_id;
        }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $editVideo['rs_editupload']->id; ?>" />
    <input type="hidden" name="task" />
    <input type="hidden" name="newupload" id="newupload" value="1">
    <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $editVideo['rs_editupload']->filepath ; ?>" />
    <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
    <input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="" />
    <input type="hidden" name="thumbimageform-value" id="thumbimageform-value" value="" />
    <input type="hidden" name="previewimageform-value" id="previewimageform-value" value="" />
    <input type="hidden" name="ffmpegform-value" id="ffmpegform-value" value="" />
    <input type="hidden" name="videourl-value" id="videourl-value" value="" />
    <input type="hidden" name="thumburl-value" id="thumburl-value" value="" />
    <input type="hidden" name="previewurl-value" id="previewurl-value" value="" />
    <input type="hidden" name="hdurl-value" id="hdurl-value" value="" />
    <input type="hidden" name="streameroption-value" id="streameroption-value" value="<?php echo $editVideo['rs_editupload']->streameroption ;?>" />
    <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" />
    <input type="hidden" name="islive-value" id="islive-value" value="" />
    <input type="hidden" name="usergroupid" id="usergroupid" value="<?php echo $videostype ;?>" />
    <input type="hidden" name="memberid" id="memberid" value="<?php echo $videosid;?>" />
    <input type="hidden" name="mode1" id="mode1" value="<?php echo $editVideo['rs_editupload']->filepath ;?>" />
    <!-- Ends -->
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>
<?php //$document->addScript( JURI::base().'components/com_contushdvideoshare/js/adminvideos.js' );?>
<script type="text/javascript" src="<?php echo JURI::base().'components/com_contushdvideoshare/js/adminvideos.js';?>"></script>

<!-- video info form end --> 