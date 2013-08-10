<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contushdvideoshare Component Edit Channel View Page
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$user =  JFactory::getUser();
$session =  JFactory::getSession();
ob_clean();
?>

  <?php if(isset($this->channeldetails[0])) {
    $channelDetails = $this->channeldetails[0];
    }?>
<div id="channel_details" class="channel_details">
                    <div class="bot_dot1 clearfix">
                        <div class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_NAME');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->channel_name)) { echo $channelDetails->channel_name; }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo JText::_('HDVS_CHANNEL_VIEWS');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->channel_views)) { echo $channelDetails->channel_views; }?></div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo JText::_('HDVS_TOTAL_UPLOADS');?> :</div>
						<div class="rightdiv"><?php if(isset($this->totaluploads)) { echo $this->totaluploads; }?></div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo JText::_('HDVS_RECENT_ACTIVITY');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->updated_date)) {echo date('Y-m-d H:i:s',strtotime($channelDetails->updated_date)); }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo JText::_('HDVS_ABOUT_ME');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->about_me)) { echo $channelDetails->about_me; }?>
						</div>
					</div>
                    <div class="bot_dot1 clearfix">
						<div class="leftdiv"><?php echo JText::_('HDVS_TAGS');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->tags)) { echo $channelDetails->tags; }?>
						</div>
					</div>
					<div class="bot_dot1">
						<div class="leftdiv"><?php echo JText::_('HDVS_WEBSITE');?> :</div>
						<div class="rightdiv"><?php if(isset($channelDetails->website)) { echo $channelDetails->website; }?>
						</div>
					</div>
</div>
<?php exit();?>
