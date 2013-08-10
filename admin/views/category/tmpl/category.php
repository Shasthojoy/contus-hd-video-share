<?php
/**
* @Copyright Copyright (C) 2010-2011 Contus Support Interactive Private Limited
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html,
**/
defined('_JEXEC') or die('Restricted access'); ?>
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
<?php
if(JRequest::getVar('task')=='edit' || JRequest::getVar('task')=='add')
{?>

  <form action="index.php?option=com_contushdvideoshare&layout=category" method="POST" name="adminForm" id="adminForm" >
           <fieldset class="adminform">
                 <legend>Category</legend>
                 <table class="admintable">
                 <tr>
                            <td class="key">Parent Category</td>
                            <td>                          
                                <select  id="parent_id" name="parent_id" >
                                <option id="-1" value="-1">Main</option>
                                    <?php                                 
                                    foreach($this->categorylist as $val) {?>
                                    <option id="<?php echo $val->id;?>" value="<?php echo $val->id;?>" <?php  if($this->categary->parent_id==$val->id){ echo 'selected="selected"'; }  ?> ><?php echo $val->category;?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                               <tr>
                               <td class="key">Category</td>
                               <td><input type="text" name="category" id="category" size="32" maxlength="250" value="<?php echo $this->categary->category; ?>" /></td>
                               </tr>
                               <tr>
                               <td class="key">Order</td>
                               <td><input type="text" name="ordering" id="ordering" size="10" maxlength="30" value="<?php echo $this->categary->ordering; ?>" /></td>
                               </tr>
                               <tr>
                               <td class="key">Published</td>
                               <?php
                               $y="checked";
                               $n="";
                               if($this->categary->published=="1")
                               {
                               $y="checked";
                               $n="";
                               }
                               else if($this->categary->published=="1")
                               {
                               $y="";
                               $n="checked";
                               }
                               ?>
                               <td><input type="radio" name="published" id="published" value="1" <?php echo $y; ?> />Yes&nbsp;&nbsp;<input type="radio" name="published" id="published" value="0" <?php echo $n; ?> />No </td>
                               </tr>

                 </table>
           </fieldset>

           <input type="hidden" name="option" value="<?php echo JRequest::getVar('option');?>"/>
           <input type="hidden" name="id" value="<?php echo $this->categary->id; ?>"/>
           <input type="hidden" name="task" value=""/>
  
    </form>

<?php }
else
{ $category=$this->category;

$lists=$this->category['lists'];
?>

<form action="index.php?option=com_contushdvideoshare&layout=category" method="POST" name="adminForm">
       <table class="adminlist">
             <thead>
                    <tr>
                           <th>#</th>
                           <th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->category); ?>)" /></th>
                           <th>Category</th>
                           <th>                           
                          <?php echo JHTML::_('grid.sort',  'Ordering Position', 'ordering', @$lists['order_Dir'], @$lists['order'] ); ?> </th>
                           <th>Published</th>
                           <th width="10">ID</th>
                    </tr>              
             </thead>
             <tbody>
                    <?php
                    $k = 0;
                    $i = 0;
                  
                    foreach ($category['category'] as $row){
                        //print_r($row);
                        $published=JHTML::_('grid.published',$row,$i);
                        $link= JRoute::_( 'index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]='. $row->id);
                         // $published = JHTML::_('grid.id', $i, $row->id );
                    	$checked = JHTML::_('grid.id', $i, $row->id);
                           //$link = JRoute::_( 'index.php?option='.JRequest::getVar('option').'&task=edit&cid[]='. $row->id.'&hidemainmenu=1' );                      ?>
                           <tr class="<?php echo "row$k";?>">
                                 <td align="center" style="width:50px;"><?php echo $i+1; ?></td>
                                  <td><?php echo $checked; ?></td>
                                  <td><a href="<?php echo $link;?>"><?php echo $row->category;?></a></td>
                                  <td align="center" style="width:20px;"><?php echo $row->ordering;?></td>
                                  <td align="center" style="width:70px;"><?php echo $published; ?></td>
                                   <td align="center" style="width:90px;"><?php echo $row->id;?></td>
                           </tr>
                    <?php
                    $k = 1 - $k;
                    $i++;

                     foreach ($category['categorylist'] as $row1){

                        if($row->id==$row1->parent_id)
                        {
                        
                        $published=JHTML::_('grid.published',$row1,$i);
                        $link= JRoute::_( 'index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]='. $row1->id);
                         // $published = JHTML::_('grid.id', $i, $row->id );
                    	$checked = JHTML::_('grid.id', $i, $row1->id);
                           //$link = JRoute::_( 'index.php?option='.JRequest::getVar('option').'&task=edit&cid[]='. $row->id.'&hidemainmenu=1' );                      ?>
                           <tr class="<?php echo "row$k";?>">
                                 <td align="center" style="width:50px;"><?php echo $i+1; ?></td>
                                  <td><?php echo $checked; ?></td>
                                  <td><a href="<?php echo $link;?>"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;|__".$row1->category;?></a></td>
<td align="center" style="width:20px;"><?php echo $row1->ordering;?></td>
<td align="center" style="width:70px;"><?php echo $published; ?></td>
                                   <td align="center" style="width:90px;"><?php echo $row1->id;?></td>
                           </tr>
                    <?php
                    $k = 1 - $k;
                    $i++;
                    }



                     }


                    }
                    ?>
                    <tr>
                    <td colspan="6">
                     <?php echo $this->category['pageNav']->getListFooter(); ?>
                    </td></tr>
             </tbody>
       </table>
     <input type="hidden" name="option" value="<?php echo $option;?>" />
   
    <input type="hidden" name="filter_order" value="<?php echo @$lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo @$lists['order_Dir']; ?>" />
           
       <input type="hidden" name="task" value=""/>
       <input type="hidden" name="boxchecked" value="0"/>   
       <input type="hidden" name="hidemainmenu" value="0"/>
        <input type="hidden" name="parent_id" value="-1"/>
      
</form>
<?php }?>