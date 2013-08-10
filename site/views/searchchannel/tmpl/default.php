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
 * @abstract      : Contushdvideoshare Component Edit Channel View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
$session = JFactory::getSession();
$editing = '';
if ($user->get('id') == '')
{
    $url = $baseurl . "index.php?option=com_user&view=register";
    header("Location: $url");
}
if (JRequest::getVar('type', '', 'get', 'string') == 'edit') {
    $videoedit1 = $this->videodetails;
    if (isset($videoedit1[0]))
        $videoedit = $videoedit1[0];
    if (isset($videoedit->filepath))
        $editing = $videoedit->filepath;
}
ob_clean();
?>
<?php
//if(isset($this->searchannelid)) {
//    echo 'Sorry, this Channel is already available';
//}else {
$channelName = '';
if(isset($this->searchannel)) {
    for($i=0;$i<count($this->searchannel);$i++){

	$channelName = $this->searchannel[$i];
?>

<div class="bot_dot2">
<input type="checkbox" name="fav_channel[]" style="float: left;"

       value="<?php if(isset($this->searchannel[$i]->id)) {
					echo $this->searchannel[$i]->id;
				} ?>" />
    <div class="leftdiv">
        <?php if($channelName->logo) {?>
        <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/videos/<?php echo $channelName->logo;?>" alt="logo" width="36" height="41" class="floatleft"/>
        <?php } else {?>
        <img id="closeimgm" src="<?php echo JURI::base();?>components/com_contushdvideoshare/images/default_thumb.jpg" alt="logo" width="36" height="41" class="floatleft"/>
        <?php }?>
        <a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=mychannel&channelname='.$channelName->channel_name,true); ?>" target="_blank"><?php echo $channelName->channel_name?></a>
    </div>

                                </div>
<?php
    }
    ?>

<input type="hidden" name="channel_id" id="channel_id" value="" />
<input type="hidden" name="channelname" id="channelname" value="" />
<?php
} else {
echo JText::_('HDVS_NO_CHANNEL_AVAILABLE');
}
//}
exit();
?>



