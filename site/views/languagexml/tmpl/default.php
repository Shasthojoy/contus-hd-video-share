<?php
/**
 * @name       Joomla HD Video Share
 * @SVN        3.5.1
 * @package    Com_Contushdvideoshare
 * @author     Apptha <assist@apptha.com>
 * @copyright  Copyright (C) 2014 Powered by Apptha
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @since      Joomla 1.5
 * @Creation Date   March 2010
 * @Modified Date   February 2014
 * */
// No direct acesss
defined('_JEXEC') or die('Restricted access');
ob_clean();

// Geberate langage xml here
header("content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<language>';
echo '<Play><![CDATA[Play]]></Play>
<Pause><![CDATA[Pause]]></Pause>
<Replay><![CDATA[Replay]]></Replay>
<Changequality><![CDATA[Change Quality]]></Changequality>
<zoomIn><![CDATA[Zoom In]]></zoomIn>
<zoomOut><![CDATA[Zoom Out]]></zoomOut>
<zoom><![CDATA[Zoom]]></zoom>
<share><![CDATA[Share]]></share>
<FullScreen><![CDATA[Full Screen]]></FullScreen>
<ExitFullScreen><![CDATA[Exit Full Screen]]></ExitFullScreen>
<PlayListHide><![CDATA[Hide Related Videos]]></PlayListHide>
<PlayListView><![CDATA[Show Related Videos]]></PlayListView>
<sharetheword><![CDATA[Share This Video]]></sharetheword>
<sendanemail><![CDATA[Send an Email]]></sendanemail>
<Mail><![CDATA[Email]]></Mail>
<to><![CDATA[To Email]]></to>
<from><![CDATA[From Email]]></from>
<note><![CDATA[Message]]></note>
<send><![CDATA[Send]]></send>
<copy><![CDATA[Copy]]></copy>
<link><![CDATA[Link]]></link>
<social><![CDATA[Social]]></social>
<embed><![CDATA[Embed]]></embed>
<Quality><![CDATA[Quality]]></Quality>
<facebook><![CDATA[Share on Facebook]]></facebook>
<tweet><![CDATA[Share on Twitter]]></tweet>
<tumblr><![CDATA[Share on Tumblr]]></tumblr>
<google+><![CDATA[Share on Google+]]></google+>
<autoplayOff><![CDATA[Turn Off Playlist Autoplay]]></autoplayOff>
<autoplayOn><![CDATA[Turn On Playlist Autoplay]]></autoplayOn>
<adindicator><![CDATA[Your selection will follow this sponsors message in - seconds]]></adindicator>
<skip><![CDATA[Skip this ad now >>]]></skip>
<skipvideo><![CDATA[You can skip to video in]]></skipvideo>
<download><![CDATA[Download]]></download>
<Volume><![CDATA[Volume]]></Volume>
<ads><![CDATA[mid]]></ads>
<nothumbnail><![CDATA[No Thumbnail Available]]></nothumbnail>
<live><![CDATA[LIVE]]></live>
<fill_required_fields><![CDATA[Please fill in all required fields.]]></fill_required_fields>
<wrong_email><![CDATA[Missing field Or Invalid email]]></wrong_email>
<email_wait><![CDATA[Wait..]]></email_wait>
<email_sent><![CDATA[Thank you! Video has been sent.]]></email_sent>
<video_not_allow_embed_player><![CDATA[The requested video does not allow playback in the embedded players.]]></video_not_allow_embed_player>
<youtube_ID_Invalid><![CDATA[The video ID that does not have 11 characters, or if the video ID contains invalid characters.]]></youtube_ID_Invalid>
<video_Removed_or_private>
<![CDATA[The requested video is not found. This occurs when a video has been removed (for any reason),
 or it has been marked as private.]]></video_Removed_or_private>
<streaming_connection_failed><![CDATA[Requested streaming provider connection failed]]></streaming_connection_failed>
<audio_not_found><![CDATA[The requested audio is not found or access denied]]></audio_not_found>
<video_access_denied><![CDATA[The requested video is not found or access denied]]></video_access_denied>
<FileStructureInvalid>
<![CDATA[Flash Player detects an invalid file structure and will not try to play this type of file.
Supported by Flash Player 9 Update 3 and later.]]></FileStructureInvalid>
<NoSupportedTrackFound>
<![CDATA[
Flash Player does not detect any supported tracks (video, audio or data) and will not try to play the file.
Supported by Flash Player 9 Update 3 and later.
]]>
</NoSupportedTrackFound>';
echo '</language>';
exit();
