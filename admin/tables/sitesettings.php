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
 * @abstract      : Contus HD Video Share Component Sitesettings Table
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for sitesettings
class Tablesitesettings extends JTable {
  var $id = null;
  var $published = null;
  var $facebookapi = null;
  var $comment = null;
  var $featurrow = null;
  var $featurcol = null;
  var $recentrow = null;
  var $recentcol = null;
  var $categoryrow = null;
  var $categorycol = null;
  var $popularrow = null;
  var $popularcol = null;
  var $searchrow = null;
  var $searchcol = null;
  var $relatedrow = null;
  var $relatedcol = null;
  var $memberpagerow = null;
  var $memberpagecol = null;
  var $homepopularvideo = null;
  var $homepopularvideorow = null;
  var $homepopularvideocol = null;
  var $homefeaturedvideo = null;
  var $homefeaturedvideorow = null;
  var $homefeaturedvideocol = null;
  var $homerecentvideo = null;
  var $homerecentvideorow = null;
  var $homerecentvideocol = null;
  var $myvideorow = null;
  var $myvideocol = null;
  var $sidepopularvideorow = null;
  var $sidepopularvideocol = null;
  var $sidefeaturedvideorow = null;
  var $sidefeaturedvideocol = null;
  var $siderelatedvideorow = null;
  var $siderelatedvideocol = null;
  var $siderecentvideorow = null;
  var $siderecentvideocol = null;
  var $allowupload =null;
  var $homepopularvideoorder =null;
  var $homefeaturedvideoorder =null;
  var $homerecentvideoorder =null;
  var $user_login =null;
  var $ratingscontrol =null;
  var $viewedconrtol =null;
  var $facebooklike =null;
  var $seo_option =null;
  var $featurwidth =null;
  var $recentwidth =null;
  var $categorywidth =null;
  var $popularwidth =null;
  var $searchwidth =null;
  var $relatedwidth =null;
  var $memberpagewidth =null;
  var $homepopularvideowidth =null;
  var $homefeaturedvideowidth =null;
  var $homerecentvideowidth =null;
  var $myvideowidth =null;
  var $language_settings =null;

	function Tablesitesettings(&$db){
		parent::__construct('#__hdflv_site_settings', 'id', $db);
	}
}
?>
