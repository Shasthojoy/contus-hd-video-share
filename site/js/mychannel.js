/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	  	  : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Mychannel Script
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/

/**
 * function to edit channel details
 */
function editChanneldetail() {
	if (document.getElementById("channel_name").value == "") {
		alert("Please Enter Channel Name");
		document.getElementById("channel_name").focus();
		return false;
	}
	if (document.getElementById('website').value != "") {		
		website = document.getElementById('website').value;
		var websiteregex = website.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
		if (websiteregex == null) {
			alert('Please Enter Valid URL');
			return;
		}
	}
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('channel_details').style.display = "block";
			document.getElementById("msg_channel_details").style.display = '';
			document.getElementById("channel_details").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=editchannel&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var channel_name = document.getElementById('channel_name').value;
	var description = tinyMCE.get('description').getContent();
	var about_me = document.getElementById('about_me').value;
	var tags = document.getElementById('tags').value;
	var website = document.getElementById('website').value;
	var id = document.getElementById('channelid').value;
	xmlhttp.send('channel_name=' + channel_name + '&description=' + description
			+ '&about_me=' + about_me + '&tags=' + tags + '&website=' + website
			+ '&id=' + id + '&function=save');
	if (document.getElementById('edit_channel').style.display == "block") {
		document.getElementById('edit_channel').style.display = "none";
		document.getElementById('editbtn').style.display = "block";
	} else {
		document.getElementById('edit_channel').style.display = "block";
	}
}

/**
 * function to search channel
 */
function otherChannel() {
	if (document.getElementById('output').style.display = "block") {
		document.getElementById('output').style.display = "none";
	} else {
		document.getElementById('output').style.display = "block";
	}
	if (document.getElementById("other_channel").value == "") {
		alert("Please Enter Channel Name To Search!");
		document.getElementById("other_channel").focus();
		return false;
	}
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("channel_list").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=searchchannel&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var channel_name = document.getElementById('other_channel').value;
	xmlhttp.send('other_channel=' + channel_name);
}

/**
 * function to apply channel
 */
function applyChannel() {
	var xmlhttp;
	if(!document.getElementById("channel_id")) {
        alert('Please search channel and add as favorite channel');
        return false;
    }
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("output").innerHTML = "<p id='output1'>Added Successfully</p>";
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=searchchannel&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var apply_channel = 'apply';
	var channel_id = document.getElementById("channel_id").value;
	var channel_name = document.getElementById("channel_name").value;
	xmlhttp.send('apply_channel=' + apply_channel + '&channel_name='
			+ channel_name + '&channel_id=' + channel_id);
	if (document.getElementById('output').style.display = "none") {
		document.getElementById('output').style.display = "block";
	} else {
		document.getElementById('output').style.display = "none";
	}
}

/**
 * function to delete other channel
 */
function deleteChannel(val) {
	
	var retVal = confirm("Are you sure want to delete this channel from the list ?");
	if (retVal == false) {
		return false;
	} 
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(val).innerHTML = "";
			document.getElementById(val).className = "newclass";
			document.getElementById("output").innerHTML = "<font id='output1' style=\"color:green;\">Deleted Successfully</font>";
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=searchchannel&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var delete_channel = 'delete';
	var channel_id = val;
	xmlhttp.send('delete_channel=' + delete_channel + '&channel_id='
			+ channel_id);

}

/**
 * function to retrieve channel videos
 */
function channelvideos(val, channelId, clsname, startno) {
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("channel_videos").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=channelvideos&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var channelvideo = val;
	var channelid = channelId;
	xmlhttp.send('channel_videos=' + channelvideo + '&channelid=' + channelid);
	var i = startno;
	for (i = startno; i <= 1004; i++) {
		if (document.getElementById(i)) {
			if (i == clsname) {
				document.getElementById(i).className = "activetab";
			} else {
				document.getElementById(i).className = "disabletab";
			}
		}
	}
}
/**
 * function to ajax pagination
 */
function ajaxpagination(val, channelVideos, channelId) {
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("channel_videos").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp
			.open(
					"POST",
					"index.php?option=com_contushdvideoshare&view=channelvideos&tmpl=component",
					true);
	xmlhttp.setRequestHeader('Content-Type',
			'application/x-www-form-urlencoded');
	var page = val;
	var channel_videos = channelVideos;
	var channelId = channelId;
	xmlhttp.send('page=' + page + '&channel_videos=' + channel_videos
			+ '&channelid=' + channelId);
}
/**
 * validation for channel settings
 */
function validation() {
	if (document.getElementById("player_width").value == ""
			|| document.getElementById("player_width").value == 0) {
		alert('Please Enter Player Width(Recommended Width : 600)');
		document.getElementById("player_width").focus();
		return false;
	}
	if (document.getElementById("player_height").value == ""
			|| document.getElementById("player_height").value == 0) {
		alert('Please Enter Player Height(Recommended Height : 400)');
		document.getElementById("player_height").focus();
		return false;
	}
	if (document.getElementById("video_row").value == "") {
		alert('Please Enter Number of rows');
		document.getElementById("video_row").focus();
		return false;
	}
	if (document.getElementById("video_colomn").value == "") {
		alert('Please Enter Number of columns');
		document.getElementById("video_colomn").focus();
		return false;
	}
}

/**
 * function to add playlist
 */
function addplaylist() {
	if (document.getElementById('add_playlist').style.display == "none") {
		document.getElementById('add_playlist').style.display = "block";
		document.getElementById('addnewbutton').style.display = "none";
	} else {
		document.getElementById('add_playlist').style.display = "none";
		document.getElementById('addnewbutton').style.display = "block";
	}
}

/**
 * function to cancel playlist
 */
function cancelplaylist() {
	document.getElementById('add_playlist').style.display = "none";
	document.getElementById('addnewbutton').style.display = "block";
}

/**
 * function to playlist validation
 */
function playlistvalidation() {
	if (document.getElementById("category").value == "") {
		alert('Please Enter Playlist Name!');
		document.getElementById("category").focus();
		return false;
	}
}