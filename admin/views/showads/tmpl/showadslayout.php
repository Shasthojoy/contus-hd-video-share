<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
 // no direct access
defined('_JEXEC') or die('Restricted access');
$rs_showads = $this->showads;

            ?>
            <script language="javascript">
document.getElementById('toolbar-box').style.marginTop=120+"px";
</script>
            <div  style="position:absolute;top:100px;left:20px;width:97%">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div style="float:left;width:20%;padding-top:8px;"><img src="components/com_contushdvideoshare/assets/customization_contushdvideoshare.jpg" alt="" /></div><div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;font-size:12px;font-family:Arial, Helvetica, sans-serif;line-height:18px;color:#333333;">
Do you know that HDVideo Share not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
</div><div style="float:right;padding:8px 0 0 50px;;text-decoration:underline;color:#0B55C4;"><div><img src="components/com_contushdvideoshare/assets/logo.jpg" alt="" /></div><div> <div style="padding: 8px 0pt 0pt 10px;float:left;"> <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a></div><div style="padding: 8px 0pt 0pt 10px;float:left;"><a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a></div></div></div>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
  		</div>
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <?php
    $basepath=explode('administrator',JURI::base());
    $path=$basepath[0]."administrator/components/com_contushdvideoshare/images/uploads/";
    $path1=$basepath[0]."components/com_contushdvideoshare/videos/"

    ?>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th width="1%">
                    <input type="checkbox" name="toggle"
                           value="" onClick="checkAll(<?php echo
                           count( $rs_showads ); ?>);" />
                </th>
                <th width="5%">
                    <?php echo JHTML::_('grid.sort',  'Ads name', 'adsname', @$lists['order_Dir'], @$lists['order'] ); ?>

                </th>
                <th width="2%">
                    <?php echo JText::_( 'Default' ); ?>
                </th>
                <th width="5%">
                    Ads video path
                </th>
                <th width="5%">
                    Published
                </th>
                <th width="5%">
                    <?php echo JHTML::_('grid.sort',  'Id', 'Id', @$lists['order_Dir'], @$lists['order'] ); ?>
                </th>
                <th width="5%">
                    Click Hits
                </th>
                <th width="5%">
                    Impression Hits
                </th>


                <!--<th width="5%">
        Preroll video path
        </th> -->

            </tr>
        </thead>
        <?php
        $k = 0;
        jimport('joomla.filter.output');
//        $j=$limitstart;
        $n=count($rs_showads);
        //$i=0;
        if ($n>=1)
        {
            for ($i=0; $i < $n; $i++)
            {
                $rsplay = $rs_showads[$i];
                $checked = JHTML::_('grid.id', $i, $rsplay->id );
                $published = JHTML::_('grid.published', $rsplay, $i );
                $link= JRoute::_( 'index.php?option=com_contushdvideoshare&layout=ads&task=editads&cid[]='. $rsplay->id);
                ?>
        <tr class="<?php echo "row$k"; ?>">
            <td align="center">
                <?php  echo $i+1;?>
            </td>
            <td align="center">
                <?php  echo $checked;?>
            </td>

            <td align="center">
                <a href="<?php echo $link; ?>">
                    <?php echo $rsplay->adsname;?>
                </a>
            </td>
            <td align="center">
                <?php if ( $rsplay->home == 1 ) : ?>
                <img src="templates/khepri/images/menu/icon-16-default.png" alt="<?php echo JText::_( 'Default' ); ?>" />
                <?php else : ?>
                &nbsp;
                <?php endif; ?>
            </td>
            <td align="center">
                <?php echo $rsplay->postvideopath;?>
            </td>
            <td align="center">
                <?php echo $published;?>
            </td>
            <td align="center">
                <?php echo $rsplay->id;?>
            </td>
                <td align="center">
<?php echo $rsplay->clickcounts; ?>
                </td>
                <td align="center">
<?php echo $rsplay->impressioncounts; ?>
                </td>

        </tr>

                        <?php
                        //$i++;
                    }
                }

                ?>
        <tfoot>
            <td colspan="13"><?php  //$rs_showads['pageNav']->getListFooter() ;?></td>
        </tfoot>

    </table>

    <!--<input type="hidden" name="id" value="<?php ?>"/>-->
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="submitted" value="true" id="submitted">

</form>


