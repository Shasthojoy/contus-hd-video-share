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
 * @Modified Date   March 2014
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (JRequest::getVar('option') != 'com_contushdvideoshare')
{
	$document = JFactory::getDocument();
	$document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/mod_stylesheet.css');
}

$dispenable = unserialize($result_settings);
$seoOption = $dispenable['seo_option'];
?>
<div class="video_module module_menu <?php echo $class; ?> ">
	<ul class="menu">
		<?php
		if (count($result) > 0)
		{
			foreach ($result as $row)
			{
				$oriname = $row->category;

				// Category name changed here for seo url purpose
				$newrname = explode(' ', $oriname);
				$link = implode('-', $newrname);
				$link1 = explode('&', $link);
				$category = implode('and', $link1);

				$result1  = Modcategorylist::getparentcategory($row->id);

				// For SEO settings
				if ($seoOption == 1)
				{
					$featureCategoryVal = "category=" . $row->seo_category;
				}
				else
				{
					$featureCategoryVal = "catid=" . $row->id;
				}
				?>
				<li class="item27">
					<?php echo str_repeat('<span class="gi">|&mdash;</span>', $row->level) ?>	
					<a href="<?php 
						echo JRoute::_("index.php?option=com_contushdvideoshare&view=category&" . $featureCategoryVal);
						?>">
						<span><?php echo $row->category; ?></span></a>
				</li>
				<?php
			}
		}
		else
		{
			echo "<li class='hd_norecords_found'>No Category</li>";
		}
		?>
	</ul>
</div>
<div class="clear"></div>
