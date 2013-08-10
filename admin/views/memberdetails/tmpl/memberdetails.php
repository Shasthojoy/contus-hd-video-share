<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted access'); 

?>
<?php $document =& JFactory::getDocument();
$document->addStyleSheet('components/com_contushdvideoshare/css/cc.css'); ?>


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
<form action="index.php?option=com_contushdvideoshare&layout=memberdetails" method="post" name="adminForm" enctype="multipart/form-data">
    <table class="adminlist">
        <thead>
            <tr>

                <th width="2%">#</th>

                <th width="2%">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->memberdetails['memberdetails'] ); ?>);" />
                </th>
<th width="2%" style="color:#3366CC">
    <?php echo JHTML::_('grid.sort',  'ID', 'id', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order'] ); ?>
</th>
<th width="10%" style="color:#3366CC">
    <?php echo JHTML::_('grid.sort',  'First Name', 'name', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order'] ); ?>
</th>

<th width="10%" style="color:#3366CC">User Name
    <?php //echo JHTML::_('grid.sort',  'Last Name', 'username', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order'] ); ?>
</th>
<th width="10%" style="color:#3366CC">Email
    <?php //echo JHTML::_('grid.sort',  'Email', 'email', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order'] ); ?>
</th>
<th width="10%" style="color:#3366CC">Joined Date
    <th width="5%" align="center" style="color:#3366CC">Allow Upload</th>
    <?php //echo JHTML::_('grid.sort',  'Joined Date', 'created_date', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order'] ); ?></th>
<th width="2%" align="center" style="color:#3366CC">Status</th>
      </tr>
        </thead><?php
        

         
                jimport('joomla.filter.output');
        $j=$this->memberdetails['limitstart'];
         $upload=$this->memberdetails['settingupload'];
        
 $n=count( $this->memberdetails['memberdetails'] );


                  for($i=0;$i < $n; $i++){
                //foreach ($this->memberdetails['memberdetails'] as $row){
                $row=$this->memberdetails['memberdetails'][$i];
                
                   $published=$row->block;

  if($published==0)
            {
                $fimg='<img src="components/com_contushdvideoshare/images/tick.png" />';
            }
            else
            {
                $fimg='<img src="components/com_contushdvideoshare/images/publish_x.png" />';
            }

                  $checked = JHTML::_('grid.id', $i, $row->id);
                 $link =JRoute::_('index.php?option=' .$option . '&task=editmember&cid[]='. $row->id );
         
                    ?>

        <tr class="<?php echo "row".($i%2);?>">
            <td align="center">
                <?php echo $i+1;?>
            </td>
            <td align="center">
                <?php echo $checked; ?>
            </td>

           <td>

<?php echo $row->id; ?>
</td>
<td>
<?php echo $row->name; ?>
</td>
<td>
<?php echo $row->username; ?>
</td>
<td>
<?php echo $row->email; ?>
</td>
<td>
<?php echo JHTML::Date($row->registerDate); ?>
</td>
 <td align="center">
          <?php $allowupload=$row->allowupload;

          if($allowupload==null)
          $allowupload=$upload[0]->allowupload;;

            if($allowupload=="1")
            {
                $aimg='<img src="components/com_contushdvideoshare/images/tick.png" />';
            }
            else
            {
                $aimg='<img src="components/com_contushdvideoshare/images/publish_x.png" />';
            }

            ?>
                <?php echo $aimg;?>
          </td>
<td align="center">
<?php echo $fimg; ?>
</td>

        </tr>
        <?php
    }
    ?>


<tfoot>

            <td colspan="15"><?php echo $this->memberdetails['pageNav']->getListFooter(); ?></td>

        </tfoot>


    </table>


    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->memberdetails['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->memberdetails['lists']['order_Dir']; ?>" />
    <input type="hidden" name="submitted" value="true" id="submitted"/>



</form>

